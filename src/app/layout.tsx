import type { Metadata } from 'next';
import './globals.css';
import { Toaster } from "@/components/ui/toaster"
import Header from '@/components/header';
import Footer from '@/components/footer';
import WhatsAppButton from '@/components/whatsapp-button';

export const metadata: Metadata = {
  title: "CMFI Bilingual High School - Building Leaders for the Future",
  description: "A leading bilingual educational institution in Paynesville, Liberia, focused on academic excellence and character development.",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" className="!scroll-smooth">
      <head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
      </head>
      <body className="font-body antialiased">
        <Header />
        <main className="flex-1">
          {children}
        </main>
        <WhatsAppButton />
        <Footer />
        <Toaster />
      </body>
    </html>
  );
}
