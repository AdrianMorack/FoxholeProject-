<!-- ====== Livewire component that auto-refreshes every 1 second ====== -->
<div wire:poll.1s>
    
    <!-- ====== Display raw JSON data nicely formatted ====== -->
    <pre>
        {{ json_encode($data, JSON_PRETTY_PRINT) }} <!-- 
            $data: the PHP variable passed from the Livewire component
            json_encode(..., JSON_PRETTY_PRINT): converts array/object to formatted JSON string
            <pre>: preserves formatting and whitespace
        -->
    </pre>

</div>
