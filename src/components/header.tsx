'use client';

import { useState, useEffect } from 'react';
import Link from 'next/link';
import { CMFILogo } from './icons';
import { Button } from './ui/button';
import { cn } from '@/lib/utils';
import { Menu, Search } from 'lucide-react';
import {
  Sheet,
  SheetContent,
  SheetTrigger,
  SheetTitle,
} from "@/components/ui/sheet"
import { usePathname } from 'next/navigation';

const Header = () => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const pathname = usePathname();

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 10);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const navLinks = [
    { name: 'Home', href: '/' },
    { name: 'About', href: '/about' },
    { name: 'Admissions', href: '/admissions' },
    { name: 'Academics', href: '/academics' },
    { name: 'Student Life', href: '/student-life' },
    { name: 'Parents', href: '/parents' },
    { name: 'Gallery', href: '/gallery' },
    { name: 'Contact', href: '/contact' },
  ];

  const NavItems = ({ onLinkClick }: { onLinkClick?: () => void }) => (
    <>
      {navLinks.map((link) => (
        <Link
          key={link.name}
          href={link.href}
          onClick={onLinkClick}
          className={cn(
            "font-medium transition-colors hover:text-primary text-2xl lg:text-lg",
            pathname === link.href ? "text-primary font-semibold" : "text-foreground/80"
          )}
        >
          {link.name}
        </Link>
      ))}
    </>
  );

  return (
    <header
      className={cn(
        'sticky top-0 z-50 w-full transition-all duration-300',
        isScrolled ? 'bg-background/80 backdrop-blur-sm border-b' : 'bg-transparent'
      )}
    >
      <div className="container mx-auto px-6 h-20 flex items-center justify-between">
        <Link href="/" className="flex items-center gap-2">
          <CMFILogo className="h-10 w-10 text-primary" />
          <span className={cn("font-headline text-2xl font-bold", isScrolled ? "text-foreground" : "text-white")}>CMFI BHS</span>
        </Link>
        
        <div className="flex items-center gap-4">
          <Button asChild className="hidden sm:flex bg-accent hover:bg-accent/90 text-accent-foreground">
            <Link href="/admissions">Access Portal</Link>
          </Button>

          <Link href="/search" className={cn("hidden sm:flex items-center justify-center h-10 w-10 rounded-full", isScrolled ? "text-foreground" : "text-white")}>
             <Search className="h-6 w-6" />
             <span className="sr-only">Search</span>
          </Link>
          
          <Sheet open={mobileMenuOpen} onOpenChange={setMobileMenuOpen}>
            <SheetTrigger asChild>
              <button className={cn("flex flex-col items-center gap-1.5 group", isScrolled ? "text-foreground" : "text-white")}>
                  <Menu className="h-7 w-7" />
                  <span className="font-headline text-xs tracking-widest uppercase">Menu</span>
              </button>
            </SheetTrigger>
            <SheetContent side="right" className="w-full max-w-sm bg-background p-0">
              <SheetTitle className="sr-only">Mobile Menu</SheetTitle>
              <div className="p-8 h-full flex flex-col">
                <nav className="flex flex-col gap-6 text-lg mt-8">
                  <NavItems onLinkClick={() => setMobileMenuOpen(false)} />
                </nav>
                 <div className="mt-auto space-y-4">
                    <Button asChild className="w-full bg-accent hover:bg-accent/90 text-accent-foreground">
                        <Link href="/admissions">Access Portal</Link>
                    </Button>
                    <Button asChild variant="outline" className="w-full">
                        <Link href="/contact">Inquire</Link>
                    </Button>
                 </div>
              </div>
            </SheetContent>
          </Sheet>
        </div>
      </div>
    </header>
  );
};

export default Header;
