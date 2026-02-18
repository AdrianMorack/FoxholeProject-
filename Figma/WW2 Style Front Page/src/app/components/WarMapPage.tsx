import { ArrowLeft, MapPin, Flag, Crosshair, Radio, Layers } from 'lucide-react';
import { ImageWithFallback } from './figma/ImageWithFallback';

interface WarMapPageProps {
  onNavigate: (page: string) => void;
}

export function WarMapPage({ onNavigate }: WarMapPageProps) {
  const territories = [
    { name: 'Northern Sector', control: 'Allied', strength: 85, x: '25%', y: '15%', color: '#4a7c59' },
    { name: 'Eastern Front', control: 'Allied', strength: 72, x: '70%', y: '35%', color: '#4a7c59' },
    { name: 'Central Plains', control: 'Contested', strength: 50, x: '45%', y: '50%', color: '#7c6a3a' },
    { name: 'Southern Ridge', control: 'Allied', strength: 90, x: '35%', y: '75%', color: '#4a7c59' },
    { name: 'Western Coast', control: 'Allied', strength: 78, x: '15%', y: '55%', color: '#4a7c59' },
  ];

  const activeOperations = [
    { code: 'OPERATION LIBERTY', objective: 'Secure supply routes', priority: 'HIGH' },
    { code: 'OPERATION FORTRESS', objective: 'Reinforce defensive positions', priority: 'MEDIUM' },
    { code: 'OPERATION EAGLE', objective: 'Reconnaissance mission', priority: 'CRITICAL' }
  ];

  return (
    <div className="min-h-screen bg-[#1a1f1a] text-[#e8e8d5]">
      {/* Background pattern */}
      <div className="absolute inset-0 opacity-10" style={{
        backgroundImage: `repeating-linear-gradient(
          45deg,
          #2a4a2a 0px,
          #2a4a2a 10px,
          #1a3a1a 10px,
          #1a3a1a 20px
        )`
      }}></div>

      <div className="relative z-10">
        {/* Header */}
        <header className="border-b-4 border-[#3a5a7c] bg-[#0f140f] shadow-2xl sticky top-0 z-20">
          <div className="container mx-auto px-4 py-4">
            <div className="flex items-center justify-between">
              <button
                onClick={() => onNavigate('home')}
                className="flex items-center gap-2 hover:text-[#3a5a7c] transition-colors"
              >
                <ArrowLeft className="w-6 h-6" />
                <span className="tracking-wider font-bold">RETURN TO HQ</span>
              </button>
              <h1 className="text-2xl font-bold tracking-wider">TACTICAL WAR MAP</h1>
              <div className="flex items-center gap-2">
                <Layers className="w-5 h-5 text-[#3a5a7c]" />
                <span className="text-sm tracking-wider">LIVE VIEW</span>
              </div>
            </div>
          </div>
        </header>

        {/* Main Content */}
        <div className="container mx-auto px-4 py-8">
          <div className="grid lg:grid-cols-3 gap-6">
            {/* Map Display */}
            <div className="lg:col-span-2">
              <div className="border-4 border-[#3a5a7c] bg-[#0f140f] p-6">
                <div className="flex items-center justify-between mb-4">
                  <h2 className="text-xl font-bold tracking-wider">THEATER OF OPERATIONS</h2>
                  <div className="flex gap-2">
                    <div className="border-2 border-[#3a5a7c] px-3 py-1">
                      <span className="text-xs tracking-wider">GRID: A1-H8</span>
                    </div>
                  </div>
                </div>

                {/* Map Container */}
                <div className="relative bg-[#1a2520] border-4 border-[#2a3a2a] aspect-[4/3] overflow-hidden">
                  {/* Map Background Image */}
                  <ImageWithFallback
                    src="https://images.unsplash.com/photo-1568137223448-0708e0e4779c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtaWxpdGFyeSUyMG1hcCUyMHZpbnRhZ2V8ZW58MXx8fHwxNzcxNDQ5ODkwfDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral"
                    alt="Military Map"
                    className="absolute inset-0 w-full h-full object-cover opacity-30"
                  />

                  {/* Grid Overlay */}
                  <div className="absolute inset-0" style={{
                    backgroundImage: `
                      linear-gradient(rgba(74, 124, 89, 0.2) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(74, 124, 89, 0.2) 1px, transparent 1px)
                    `,
                    backgroundSize: '50px 50px'
                  }}></div>

                  {/* Territory Markers */}
                  {territories.map((territory, index) => (
                    <div
                      key={index}
                      className="absolute transform -translate-x-1/2 -translate-y-1/2 group cursor-pointer"
                      style={{ left: territory.x, top: territory.y }}
                    >
                      <div className="relative">
                        <MapPin
                          className="w-8 h-8 drop-shadow-lg animate-pulse"
                          style={{ color: territory.color }}
                          fill={territory.color}
                        />
                        {/* Tooltip */}
                        <div className="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap">
                          <div className="bg-[#0f140f] border-2 px-3 py-2 shadow-xl" style={{ borderColor: territory.color }}>
                            <p className="text-xs font-bold">{territory.name}</p>
                            <p className="text-xs text-[#8b9d83]">{territory.control}</p>
                            <p className="text-xs">Strength: {territory.strength}%</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  ))}

                  {/* Tactical Lines */}
                  <svg className="absolute inset-0 w-full h-full pointer-events-none">
                    <line x1="25%" y1="15%" x2="45%" y2="50%" stroke="#4a7c59" strokeWidth="2" strokeDasharray="5,5" opacity="0.5" />
                    <line x1="70%" y1="35%" x2="45%" y2="50%" stroke="#4a7c59" strokeWidth="2" strokeDasharray="5,5" opacity="0.5" />
                    <line x1="35%" y1="75%" x2="45%" y2="50%" stroke="#4a7c59" strokeWidth="2" strokeDasharray="5,5" opacity="0.5" />
                  </svg>
                </div>

                {/* Map Legend */}
                <div className="mt-4 flex gap-6 text-sm">
                  <div className="flex items-center gap-2">
                    <div className="w-4 h-4 bg-[#4a7c59]"></div>
                    <span className="text-[#8b9d83]">Allied Control</span>
                  </div>
                  <div className="flex items-center gap-2">
                    <div className="w-4 h-4 bg-[#7c6a3a]"></div>
                    <span className="text-[#8b9d83]">Contested</span>
                  </div>
                  <div className="flex items-center gap-2">
                    <div className="w-4 h-4 bg-[#7c3a3a]"></div>
                    <span className="text-[#8b9d83]">Enemy Control</span>
                  </div>
                </div>
              </div>

              {/* Territory Details */}
              <div className="border-4 border-[#4a7c59] bg-[#0f140f] p-6 mt-6">
                <h3 className="text-xl font-bold mb-4 tracking-wider">TERRITORIAL CONTROL</h3>
                <div className="space-y-3">
                  {territories.map((territory, index) => (
                    <div key={index} className="bg-[#141914] p-3 border-l-4" style={{ borderColor: territory.color }}>
                      <div className="flex items-center justify-between mb-2">
                        <div className="flex items-center gap-3">
                          <Flag className="w-4 h-4" style={{ color: territory.color }} />
                          <span className="font-bold">{territory.name}</span>
                        </div>
                        <span className="text-xs px-2 py-1 border" style={{ borderColor: territory.color }}>
                          {territory.control}
                        </span>
                      </div>
                      <div className="flex items-center gap-2">
                        <div className="flex-1 bg-[#1a1f1a] h-3 border" style={{ borderColor: territory.color }}>
                          <div
                            className="h-full transition-all"
                            style={{ width: `${territory.strength}%`, backgroundColor: territory.color }}
                          ></div>
                        </div>
                        <span className="text-xs w-12 text-right">{territory.strength}%</span>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            {/* Sidebar */}
            <div className="space-y-6">
              {/* Active Operations */}
              <div className="border-4 border-[#3a5a7c] bg-[#0f140f] p-6">
                <div className="flex items-center gap-2 mb-4">
                  <Crosshair className="w-5 h-5 text-[#3a5a7c]" />
                  <h3 className="text-xl font-bold tracking-wider">ACTIVE OPERATIONS</h3>
                </div>
                <div className="space-y-4">
                  {activeOperations.map((op, index) => (
                    <div key={index} className="bg-[#141914] p-4 border-l-4 border-[#3a5a7c]">
                      <div className="flex items-start justify-between mb-2">
                        <h4 className="font-bold text-sm">{op.code}</h4>
                        <span className={`text-xs px-2 py-1 border ${
                          op.priority === 'CRITICAL' ? 'border-[#7c3a3a] text-[#7c3a3a]' :
                          op.priority === 'HIGH' ? 'border-[#7c6a3a] text-[#7c6a3a]' :
                          'border-[#3a5a7c] text-[#3a5a7c]'
                        }`}>
                          {op.priority}
                        </span>
                      </div>
                      <p className="text-xs text-[#8b9d83]">{op.objective}</p>
                    </div>
                  ))}
                </div>
              </div>

              {/* Communications */}
              <div className="border-4 border-[#4a7c59] bg-[#0f140f] p-6">
                <div className="flex items-center gap-2 mb-4">
                  <Radio className="w-5 h-5 text-[#4a7c59]" />
                  <h3 className="text-xl font-bold tracking-wider">FIELD REPORTS</h3>
                </div>
                <div className="space-y-3">
                  <div className="bg-[#141914] p-3 border-l-2 border-[#4a7c59]">
                    <p className="text-xs text-[#8b9d83] mb-1">0845 HRS - SECTOR NORTH</p>
                    <p className="text-sm">Patrol complete. All clear.</p>
                  </div>
                  <div className="bg-[#141914] p-3 border-l-2 border-[#4a7c59]">
                    <p className="text-xs text-[#8b9d83] mb-1">0920 HRS - CENTRAL</p>
                    <p className="text-sm">Increased activity detected.</p>
                  </div>
                  <div className="bg-[#141914] p-3 border-l-2 border-[#4a7c59]">
                    <p className="text-xs text-[#8b9d83] mb-1">1015 HRS - SECTOR SOUTH</p>
                    <p className="text-sm">Reinforcements arrived.</p>
                  </div>
                </div>
              </div>

              {/* Mission Briefing */}
              <div className="border-4 border-[#7c6a3a] bg-[#0f140f] p-6">
                <h3 className="text-xl font-bold mb-3 tracking-wider">MISSION BRIEFING</h3>
                <div className="space-y-2 text-sm text-[#8b9d83]">
                  <p>Current objective: Maintain territorial control and secure strategic positions.</p>
                  <p className="mt-3">All units maintain radio silence unless emergency protocols are activated.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
