'use client';

import { useState, useEffect } from 'react';
import Link from 'next/link';
import { CMFILogo } from './icons';
import { Button } from './ui/button';
import { cn } from '@/lib/utils';
import { Menu } from 'lucide-react';
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
            "font-medium transition-colors hover:text-primary",
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
          <CMFILogo className="h-8 w-8 text-primary" />
          <span className="font-headline text-2xl font-bold">CMFI BHS</span>
        </Link>
        
        <nav className="hidden lg:flex items-center gap-8">
          <NavItems />
        </nav>

        <div className="flex items-center gap-2">
          <Button asChild className="hidden sm:flex bg-accent hover:bg-accent/90 text-accent-foreground">
            <Link href="#">Access Portal</Link>
          </Button>
          
          <div className="lg:hidden">
            <Sheet open={mobileMenuOpen} onOpenChange={setMobileMenuOpen}>
              <SheetTrigger asChild>
                <Button variant="ghost" size="icon">
                  <Menu className="h-6 w-6" />
                  <span className="sr-only">Open menu</span>
                </Button>
              </SheetTrigger>
              <SheetContent side="right" className="w-full max-w-sm bg-background">
                <SheetTitle className="sr-only">Mobile Menu</SheetTitle>
                <div className="p-6 h-full flex flex-col">
                  <div className="flex items-center justify-between mb-8">
                    <Link href="/" onClick={() => setMobileMenuOpen(false)} className="flex items-center gap-2">
                      <CMFILogo className="h-8 w-8 text-primary" />
                      <span className="font-headline text-2xl font-bold">CMFI BHS</span>
                    </Link>
                  </div>
                  <nav className="flex flex-col gap-6 text-lg">
                    <NavItems onLinkClick={() => setMobileMenuOpen(false)} />
                  </nav>
                  <Button asChild className="mt-auto bg-accent hover:bg-accent/90 text-accent-foreground">
                    <Link href="#">Access Portal</Link>
                  </Button>
                </div>
              </SheetContent>
            </Sheet>
          </div>
        </div>
      </div>
    </header>
  );
};

export default Header;
