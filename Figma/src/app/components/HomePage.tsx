import { Star, MapPin, BarChart3 } from 'lucide-react';

interface HomePageProps {
  onNavigate: (page: string) => void;
}

export function HomePage({ onNavigate }: HomePageProps) {
  return (
    <div className="min-h-screen bg-[#1a1f1a] text-[#e8e8d5] relative overflow-hidden">
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
      
      {/* Main content */}
      <div className="relative z-10">
        {/* Header */}
        <header className="border-b-4 border-[#4a7c59] bg-[#0f140f] shadow-2xl">
          <div className="container mx-auto px-4 py-6">
            <div className="flex items-center justify-between">
              <div className="flex items-center gap-3">
                <Star className="w-10 h-10 text-[#ffd700] fill-[#ffd700]" />
                <div>
                  <h1 className="text-3xl font-bold tracking-wider text-[#e8e8d5]">ALLIED COMMAND</h1>
                  <p className="text-sm text-[#8b9d83] tracking-widest">OPERATION HEADQUARTERS</p>
                </div>
              </div>
              <div className="text-right">
                <p className="text-xs text-[#8b9d83] tracking-wider">CLEARANCE LEVEL</p>
                <p className="text-xl font-bold text-[#4a7c59]">TOP SECRET</p>
              </div>
            </div>
          </div>
        </header>

        {/* Hero section */}
        <div className="container mx-auto px-4 py-16">
          <div className="max-w-4xl mx-auto text-center mb-16">
            <div className="inline-block border-4 border-[#4a7c59] bg-[#0f140f] px-8 py-4 mb-8 shadow-xl">
              <p className="text-sm tracking-[0.3em] text-[#8b9d83]">CLASSIFIED BRIEFING</p>
              <h2 className="text-5xl font-bold mt-2 text-[#e8e8d5]">STRATEGIC COMMAND CENTER</h2>
            </div>
            <p className="text-xl text-[#a8b8a0] leading-relaxed max-w-2xl mx-auto">
              Access real-time intelligence reports, tactical assessments, and operational maps. 
              Your clearance grants you entry to vital strategic information.
            </p>
          </div>

          {/* Navigation Cards */}
          <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            {/* Status Card */}
            <button
              onClick={() => onNavigate('status')}
              className="group relative bg-[#0f140f] border-4 border-[#4a7c59] p-8 hover:border-[#5a9c69] transition-all duration-300 hover:scale-105 hover:shadow-2xl"
            >
              <div className="absolute top-0 right-0 bg-[#4a7c59] px-3 py-1">
                <p className="text-xs tracking-wider text-[#e8e8d5]">PRIORITY: HIGH</p>
              </div>
              <div className="mt-6 flex flex-col items-center">
                <div className="bg-[#1a4a2a] p-6 rounded-full mb-4 group-hover:bg-[#2a5a3a] transition-colors">
                  <BarChart3 className="w-12 h-12 text-[#5a9c69]" />
                </div>
                <h3 className="text-2xl font-bold mb-3 text-[#e8e8d5]">OPERATIONAL STATUS</h3>
                <p className="text-[#8b9d83] text-center leading-relaxed">
                  Review current force readiness, supply lines, and tactical assessments of all active fronts.
                </p>
                <div className="mt-6 inline-block border-2 border-[#4a7c59] px-6 py-2 group-hover:bg-[#4a7c59] group-hover:text-[#0f140f] transition-colors">
                  <span className="tracking-wider font-bold">ACCESS REPORT →</span>
                </div>
              </div>
            </button>

            {/* War Map Card */}
            <button
              onClick={() => onNavigate('warmap')}
              className="group relative bg-[#0f140f] border-4 border-[#3a5a7c] p-8 hover:border-[#4a7a9c] transition-all duration-300 hover:scale-105 hover:shadow-2xl"
            >
              <div className="absolute top-0 right-0 bg-[#3a5a7c] px-3 py-1">
                <p className="text-xs tracking-wider text-[#e8e8d5]">PRIORITY: CRITICAL</p>
              </div>
              <div className="mt-6 flex flex-col items-center">
                <div className="bg-[#1a3a4a] p-6 rounded-full mb-4 group-hover:bg-[#2a4a5a] transition-colors">
                  <MapPin className="w-12 h-12 text-[#4a7a9c]" />
                </div>
                <h3 className="text-2xl font-bold mb-3 text-[#e8e8d5]">WAR MAP</h3>
                <p className="text-[#8b9d83] text-center leading-relaxed">
                  Strategic overview of all theaters of operation. Track troop movements and territorial control.
                </p>
                <div className="mt-6 inline-block border-2 border-[#3a5a7c] px-6 py-2 group-hover:bg-[#3a5a7c] group-hover:text-[#0f140f] transition-colors">
                  <span className="tracking-wider font-bold">VIEW MAP →</span>
                </div>
              </div>
            </button>
          </div>

          {/* Footer notice */}
          <div className="mt-16 max-w-4xl mx-auto">
            <div className="border-l-4 border-[#ffd700] bg-[#0f140f] p-6">
              <p className="text-sm text-[#8b9d83] leading-relaxed">
                <span className="font-bold text-[#ffd700]">SECURITY NOTICE:</span> All information contained within this system is classified. 
                Unauthorized disclosure is prohibited. Report any suspicious activity to Intelligence immediately.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
