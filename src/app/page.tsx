import Header from "@/components/header";
import HeroSection from "@/components/sections/hero-section";
import AboutSection from "@/components/sections/about-section";
import TimelineSection from "@/components/sections/timeline-section";
import GallerySection from "@/components/sections/gallery-section";
import NewsSection from "@/components/sections/news-section";
import ContactSection from "@/components/sections/contact-section";
import Footer from "@/components/footer";

export default function Home() {
  return (
    <div className="flex flex-col min-h-screen">
      <Header />
      <main className="flex-1">
        <HeroSection />
        <AboutSection />
        <TimelineSection />
        <GallerySection />
        <NewsSection />
        <ContactSection />
      </main>
      <Footer />
    </div>
  );
}
