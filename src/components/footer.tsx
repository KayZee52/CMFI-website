import { CMFILogo } from './icons';
import { Facebook, Twitter, Instagram, Linkedin, Youtube, Phone, Mail, MapPin, Search } from 'lucide-react';
import Link from 'next/link';
import { Input } from './ui/input';

const Footer = () => {
  const findUs = {
    address: 'CMFI Bilingual High School, 72nd, Paynesville, Liberia',
    phone: '+231-XX-XXX-XXXX',
    mapHref: "https://www.google.com/maps/place/C+M+F+I+COMPUS/@6.2971525,-10.7074568,17z/data=!3m1!4b1!4m6!3m5!1s0xf09ff47e5c02a07:0x31b2da1a364f8544!8m2!3d6.2971472!4d-10.7048819!16s%2Fg%2F11rp0tf6_0?entry=ttu"
  };

  const followUsLinks = [
    { name: 'YouTube', href: '#' },
    { name: 'Facebook', href: '#' },
    { name: 'Instagram', href: '#' },
    { name: 'LinkedIn', href: '#' },
    { name: 'X', href: '#' },
  ];

  const usefulLinks = [
    { name: 'Academics', href: '/academics' },
    { name: 'Admissions', href: '/admissions' },
    { name: 'Student Life', href: '/student-life' },
    { name: 'Parents', href: '/parents' },
    { name: 'Contact', href: '/contact' },
    { name: 'Portal', href: '#' }
  ];

  return (
    <footer className="bg-primary text-primary-foreground/80">
      <div className="container mx-auto px-6 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 text-sm">
          
          <div className="space-y-4">
            <h3 className="font-headline tracking-widest text-xs uppercase border-t border-primary-foreground/30 pt-4">Find Us</h3>
            <address className="not-italic space-y-2">
              <a href={findUs.mapHref} target="_blank" rel="noopener noreferrer" className="hover:text-accent transition-colors block">
                {findUs.address}
              </a>
              <a href={`tel:${findUs.phone}`} className="hover:text-accent transition-colors block">
                {findUs.phone}
              </a>
            </address>
          </div>

          <div className="space-y-4">
            <h3 className="font-headline tracking-widest text-xs uppercase border-t border-primary-foreground/30 pt-4">Follow Us</h3>
            <ul className="space-y-2">
              {followUsLinks.map((link) => (
                <li key={link.name}>
                  <Link href={link.href} className="hover:text-accent transition-colors">
                    {link.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
          
          <div className="space-y-4">
            <h3 className="font-headline tracking-widest text-xs uppercase border-t border-primary-foreground/30 pt-4">Useful Links</h3>
            <ul className="space-y-2">
              {usefulLinks.map((link) => (
                <li key={link.name}>
                  <Link href={link.href} className="hover:text-accent transition-colors">
                    {link.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          <div className="space-y-6">
            <Link href="/" className="flex items-center gap-3">
              <CMFILogo className="h-10 w-10 text-accent" />
              <span className="font-headline text-xl font-bold text-primary-foreground">CMFI BHS</span>
            </Link>
            <p className="text-xs">
              CMFI Bilingual High School does not discriminate in its admissions or educational programs on the basis of race, color, religion, sex, or national origin.
            </p>
            <div className="relative">
                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-primary-foreground/50" />
                <Input 
                    type="search" 
                    placeholder="What are you looking for?"
                    className="bg-primary-foreground/10 border-primary-foreground/30 text-primary-foreground placeholder:text-primary-foreground/50 pl-9"
                />
            </div>
          </div>
        </div>

        <div className="mt-16 border-t border-primary-foreground/30 pt-8 flex flex-col md:flex-row justify-between items-center text-xs gap-4">
          <p>&copy; {new Date().getFullYear()} CMFI Bilingual High School. All Rights Reserved.</p>
          <div className="flex gap-4">
             <Link href="#" className="hover:text-accent transition-colors">Privacy Policy</Link>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
