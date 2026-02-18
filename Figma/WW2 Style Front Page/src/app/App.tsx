import { useState } from 'react';
import { HomePage } from './components/HomePage';
import { StatusPage } from './components/StatusPage';
import { WarMapPage } from './components/WarMapPage';

export default function App() {
  const [currentPage, setCurrentPage] = useState<'home' | 'status' | 'warmap'>('home');

  const handleNavigation = (page: string) => {
    setCurrentPage(page as 'home' | 'status' | 'warmap');
  };

  return (
    <div className="min-h-screen">
      {currentPage === 'home' && <HomePage onNavigate={handleNavigation} />}
      {currentPage === 'status' && <StatusPage onNavigate={handleNavigation} />}
      {currentPage === 'warmap' && <WarMapPage onNavigate={handleNavigation} />}
    </div>
  );
}
