<?php

namespace App\Livewire;

use Livewire\Component; // Base Livewire component class
use Illuminate\Support\Facades\Cache; // Cache facade for caching API responses
use Illuminate\Support\Facades\Log; // Log facade for logging errors
use App\Services\FoxholeApi; // Our API service with shard support

class WarStatus extends Component
{
    /**
     * ====== Public properties ======
     * Livewire automatically exposes these to the Blade view.
     *
     * @var array|null
     */
    public $data; // Holds the current war status data fetched from the Foxhole API
    public $stats; // Additional statistics from map reports
    public $maps; // Map data for the table display

    /**
     * ====== Component render ======
     * Returns the Blade view that represents this Livewire component.
     */
    public function render()
    {
        return view('livewire.war-status')
            ->layout('layouts.app', ['title' => 'Operational Status']);
    }

    /**
     * ====== Component mount ======
     * Called once when the component is first instantiated.
     * Good place to fetch initial data.
     */
    public function mount()
    {
        $shard = session('foxhole_shard', 'baker');
        
        // Cache war status for 5 minutes per shard to avoid slow API calls on every page load
        $this->data = Cache::remember("war_status_{$shard}", 300, function () {
            try {
                $api = new FoxholeApi();
                $response = $api->war();
                
                if ($response) {
                    return $response;
                }
                
                return null;
            } catch (\Exception $e) {
                Log::error('Failed to fetch war status: ' . $e->getMessage());
                return null;
            }
        });
        
        // Get additional stats from database
        $this->stats = Cache::remember("war_status_stats_{$shard}", 300, function () use ($shard) {
            $warState = \App\Models\WarState::where('shard', $shard)->latest()->first();
            $warId = $warState?->war_id;
            
            // Get latest map report per map (only one per map to avoid counting duplicates)
            $reports = \App\Models\MapReport::where('shard', $shard)
                ->whereIn('id', function($query) use ($shard) {
                    $query->select(\DB::raw('MAX(id)'))
                        ->from('map_reports')
                        ->where('shard', $shard)
                        ->groupBy('map_name', 'shard');
                })
                ->get();
            
            return [
                'total_enlistments' => $reports->sum('total_enlistments'),
                'colonial_casualties' => $reports->sum('colonial_casualties'),
                'warden_casualties' => $reports->sum('warden_casualties'),
                'total_casualties' => $reports->sum('colonial_casualties') + $reports->sum('warden_casualties'),
                'active_maps' => \App\Models\MapIcon::where('shard', $shard)->where('war_id', $warId)->distinct('map_name')->count('map_name'),
                'total_structures' => \App\Models\MapIcon::where('shard', $shard)->where('war_id', $warId)->count(),
                // Victory points: Unique VP town hall positions (flag 41) minus 1
                'victory_points_warden' => \App\Models\MapIcon::where('shard', $shard)
                    ->where('war_id', $warId)
                    ->where('team_id', 'WARDENS')
                    ->where('flags', 41)
                    ->whereIn('icon_type', [56, 57, 58])
                    ->selectRaw('COUNT(DISTINCT CONCAT(map_name, "|", x, "|", y)) as count')
                    ->first()->count - 1,
                'victory_points_colonial' => \App\Models\MapIcon::where('shard', $shard)
                    ->where('war_id', $warId)
                    ->where('team_id', 'COLONIALS')
                    ->where('flags', 41)
                    ->whereIn('icon_type', [56, 57, 58])
                    ->selectRaw('COUNT(DISTINCT CONCAT(map_name, "|", x, "|", y)) as count')
                    ->first()->count - 1,
                // All town bases (not just victory points)
                'warden_town_bases' => \App\Models\MapIcon::where('shard', $shard)->where('war_id', $warId)->where('team_id', 'WARDENS')->whereIn('icon_type', [56, 57, 58])->count(),
                'colonial_town_bases' => \App\Models\MapIcon::where('shard', $shard)->where('war_id', $warId)->where('team_id', 'COLONIALS')->whereIn('icon_type', [56, 57, 58])->count(),
            ];
        });
        
        // Get map data for the table
        $this->maps = \App\Models\Map::where('shard', $shard)
            ->withCount([
                'icons as warden_count' => function ($query) {
                    $query->where('team_id', 'WARDENS');
                },
                'icons as colonial_count' => function ($query) {
                    $query->where('team_id', 'COLONIALS');
                },
                'icons as total_structures'
            ])
            ->get();
    }
}
