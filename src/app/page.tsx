import AcademicsPreview from "@/components/sections/academics-preview-section";
import CtaSection from "@/components/sections/cta-section";
import HeroSection from "@/components/sections/hero-section";
import WhyChooseUsSection from "@/components/sections/why-choose-us-section";
import NewsPreviewSection from "@/components/sections/news-preview-section";
import StatsSection from "@/components/sections/stats-section";
import StudentLifePreview from "@/components/sections/student-life-preview";
import TestimonialsSection from "@/components/sections/testimonials-section";
import TimelineSection from "@/components/sections/timeline-section";
import GallerySection from "@/components/sections/gallery-section";

export default function Home() {
  return (
    <>
      <HeroSection />
      <WhyChooseUsSection />
      <TimelineSection />
      <AcademicsPreview />
      <StudentLifePreview />
      <GallerySection />
      <TestimonialsSection />
      <NewsPreviewSection />
      <CtaSection />
    </>
  );
}
