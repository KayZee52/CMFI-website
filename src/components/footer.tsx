import { CMFILogo } from './icons';
import { Facebook, Twitter, Instagram, Linkedin, Youtube, Phone, Mail, MapPin } from 'lucide-react';
import Link from 'next/link';

const Footer = () => {
  const navLinks = [
    { name: 'About', href: '/about' },
    { name: 'Admissions', href: '/admissions' },
    { name: 'Academics', href: '/academics' },
    { name: 'Student Life', href: '/student-life' },
    { name: 'Parents', href: '/parents' },
    { name: 'Contact', href: '/contact' },
  ];

  const socialLinks = [
    { name: 'Facebook', icon: Facebook, href: '#' },
    { name: 'Twitter', icon: Twitter, href: '#' },
    { name: 'Instagram', icon: Instagram, href: '#' },
    { name: 'LinkedIn', icon: Linkedin, href: '#' },
    { name: 'YouTube', icon: Youtube, href: '#' },
  ];

  return (
    <footer className="bg-primary text-primary-foreground">
      <div className="container mx-auto px-6 py-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 text-sm">
          <div className="flex flex-col items-start">
            <Link href="/" className="flex items-center gap-2 mb-4">
              <CMFILogo className="h-10 w-10 text-accent" />
              <span className="font-headline text-xl font-bold">CMFI BHS</span>
            </Link>
            <p className="text-blue-100">
              Building leaders for the future.
            </p>
          </div>
          
          <div>
            <h3 className="font-headline font-semibold text-lg mb-4 text-accent">Quick Links</h3>
            <ul className="space-y-2">
              {navLinks.map((link) => (
                <li key={link.name}>
                  <Link
                    href={link.href}
                    className="text-blue-100 hover:text-accent transition-colors"
                  >
                    {link.name}
                  </Link>
                </li>
              ))}
               <li>
                  <Link href="#" className="text-blue-100 hover:text-accent transition-colors">Access Portal</Link>
              </li>
            </ul>
          </div>

          <div>
            <h3 className="font-headline font-semibold text-lg mb-4 text-accent">Contact Us</h3>
             <ul className="space-y-3 text-blue-100">
                <li className="flex items-start gap-3">
                  <MapPin className="h-5 w-5 text-accent mt-0.5 shrink-0" />
                  <span>Paynesville, Liberia</span>
                </li>
                <li className="flex items-start gap-3">
                  <Phone className="h-5 w-5 text-accent mt-0.5 shrink-0" />
                  <span>+231-XX-XXX-XXXX</span>
                </li>
                 <li className="flex items-start gap-3">
                  <Mail className="h-5 w-5 text-accent mt-0.5 shrink-0" />
                  <span>info@cmfibhs.edu.lr</span>
                </li>
              </ul>
          </div>
          
          <div>
            <h3 className="font-headline font-semibold text-lg mb-4 text-accent">Connect With Us</h3>
            <div className="flex space-x-4">
              {socialLinks.map((social) => (
                <Link
                  key={social.name}
                  href={social.href}
                  aria-label={social.name}
                  className="text-blue-100 hover:text-accent transition-colors"
                >
                  <social.icon className="h-6 w-6" />
                </Link>
              ))}
            </div>
          </div>
        </div>
        <div className="mt-12 border-t border-primary/50 pt-8 text-center text-sm text-blue-200">
          <p>&copy; {new Date().getFullYear()} CMFI Bilingual High School. All Rights Reserved.</p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
