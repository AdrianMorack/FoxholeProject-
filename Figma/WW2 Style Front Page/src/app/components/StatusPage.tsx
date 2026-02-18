import { ArrowLeft, Users, Package, Shield, AlertTriangle, CheckCircle2, TrendingUp } from 'lucide-react';

interface StatusPageProps {
  onNavigate: (page: string) => void;
}

export function StatusPage({ onNavigate }: StatusPageProps) {
  const statCards = [
    {
      title: 'ACTIVE DIVISIONS',
      value: '42',
      status: 'operational',
      icon: Users,
      color: '#4a7c59',
      bgColor: '#1a4a2a'
    },
    {
      title: 'SUPPLY STATUS',
      value: '87%',
      status: 'adequate',
      icon: Package,
      color: '#4a7c59',
      bgColor: '#1a4a2a'
    },
    {
      title: 'DEFENSIVE READINESS',
      value: 'HIGH',
      status: 'ready',
      icon: Shield,
      color: '#3a5a7c',
      bgColor: '#1a3a4a'
    },
    {
      title: 'THREAT LEVEL',
      value: 'MODERATE',
      status: 'alert',
      icon: AlertTriangle,
      color: '#7c6a3a',
      bgColor: '#4a3a1a'
    }
  ];

  const frontReports = [
    { front: 'Western Front', status: 'Advancing', readiness: 92, trend: 'up' },
    { front: 'Eastern Front', status: 'Holding', readiness: 78, trend: 'stable' },
    { front: 'Southern Front', status: 'Fortifying', readiness: 85, trend: 'up' },
    { front: 'Northern Front', status: 'Patrol Active', readiness: 71, trend: 'stable' }
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
        <header className="border-b-4 border-[#4a7c59] bg-[#0f140f] shadow-2xl sticky top-0 z-20">
          <div className="container mx-auto px-4 py-4">
            <div className="flex items-center justify-between">
              <button
                onClick={() => onNavigate('home')}
                className="flex items-center gap-2 hover:text-[#4a7c59] transition-colors"
              >
                <ArrowLeft className="w-6 h-6" />
                <span className="tracking-wider font-bold">RETURN TO HQ</span>
              </button>
              <h1 className="text-2xl font-bold tracking-wider">OPERATIONAL STATUS</h1>
              <div className="text-right">
                <p className="text-xs text-[#8b9d83]">LAST UPDATE</p>
                <p className="text-sm font-bold text-[#4a7c59]">18 FEB 2026</p>
              </div>
            </div>
          </div>
        </header>

        {/* Main Content */}
        <div className="container mx-auto px-4 py-8">
          {/* Status Cards Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            {statCards.map((card, index) => {
              const Icon = card.icon;
              return (
                <div
                  key={index}
                  className="border-4 bg-[#0f140f] p-6 relative"
                  style={{ borderColor: card.color }}
                >
                  <div className="absolute top-0 right-0 px-2 py-1" style={{ backgroundColor: card.color }}>
                    <CheckCircle2 className="w-4 h-4 text-[#e8e8d5]" />
                  </div>
                  <div className="mt-4">
                    <div className="p-4 rounded-full inline-block mb-3" style={{ backgroundColor: card.bgColor }}>
                      <Icon className="w-8 h-8" style={{ color: card.color }} />
                    </div>
                    <p className="text-xs tracking-widest text-[#8b9d83] mb-2">{card.title}</p>
                    <p className="text-3xl font-bold" style={{ color: card.color }}>{card.value}</p>
                  </div>
                </div>
              );
            })}
          </div>

          {/* Front Reports */}
          <div className="border-4 border-[#4a7c59] bg-[#0f140f] p-6 mb-8">
            <div className="flex items-center justify-between mb-6">
              <h2 className="text-2xl font-bold tracking-wider">FRONT LINE REPORTS</h2>
              <div className="border-2 border-[#4a7c59] px-4 py-1">
                <span className="text-xs tracking-wider">CLASSIFIED</span>
              </div>
            </div>

            <div className="space-y-4">
              {frontReports.map((report, index) => (
                <div key={index} className="border-l-4 border-[#4a7c59] bg-[#141914] p-4">
                  <div className="flex items-center justify-between mb-3">
                    <div className="flex items-center gap-4">
                      <h3 className="text-xl font-bold">{report.front}</h3>
                      <span className="text-sm text-[#8b9d83]">STATUS: {report.status}</span>
                    </div>
                    {report.trend === 'up' && (
                      <TrendingUp className="w-5 h-5 text-[#4a7c59]" />
                    )}
                  </div>
                  
                  <div className="flex items-center gap-3">
                    <span className="text-xs text-[#8b9d83] tracking-wider w-32">READINESS</span>
                    <div className="flex-1 bg-[#1a1f1a] h-6 border-2 border-[#4a7c59] relative">
                      <div
                        className="h-full bg-[#4a7c59] transition-all duration-1000"
                        style={{ width: `${report.readiness}%` }}
                      ></div>
                      <span className="absolute inset-0 flex items-center justify-center text-xs font-bold">
                        {report.readiness}%
                      </span>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>

          {/* Intelligence Summary */}
          <div className="grid md:grid-cols-2 gap-6">
            <div className="border-4 border-[#3a5a7c] bg-[#0f140f] p-6">
              <h3 className="text-xl font-bold mb-4 tracking-wider">INTELLIGENCE SUMMARY</h3>
              <div className="space-y-3">
                <div className="flex items-start gap-3 border-l-2 border-[#3a5a7c] pl-3">
                  <div className="w-2 h-2 bg-[#3a5a7c] rounded-full mt-2"></div>
                  <p className="text-sm text-[#8b9d83]">Enemy movements detected in Sector 7-B</p>
                </div>
                <div className="flex items-start gap-3 border-l-2 border-[#3a5a7c] pl-3">
                  <div className="w-2 h-2 bg-[#3a5a7c] rounded-full mt-2"></div>
                  <p className="text-sm text-[#8b9d83]">Supply convoy arrived safely at Forward Base Delta</p>
                </div>
                <div className="flex items-start gap-3 border-l-2 border-[#3a5a7c] pl-3">
                  <div className="w-2 h-2 bg-[#3a5a7c] rounded-full mt-2"></div>
                  <p className="text-sm text-[#8b9d83]">Reinforcements scheduled for deployment at 0600 hours</p>
                </div>
              </div>
            </div>

            <div className="border-4 border-[#4a7c59] bg-[#0f140f] p-6">
              <h3 className="text-xl font-bold mb-4 tracking-wider">RECENT COMMUNICATIONS</h3>
              <div className="space-y-3">
                <div className="bg-[#141914] p-3 border-l-2 border-[#4a7c59]">
                  <p className="text-xs text-[#8b9d83] mb-1">FROM: Field Commander Baker</p>
                  <p className="text-sm">Position secured. Awaiting further orders.</p>
                </div>
                <div className="bg-[#141914] p-3 border-l-2 border-[#4a7c59]">
                  <p className="text-xs text-[#8b9d83] mb-1">FROM: Supply Corps</p>
                  <p className="text-sm">Next shipment confirmed for 20 FEB 2026.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
