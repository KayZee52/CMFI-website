import AcademicsPreview from "@/components/sections/academics-preview-section";
import CtaSection from "@/components/sections/cta-section";
import HeroSection from "@/components/sections/hero-section";
import IntroSection from "@/components/sections/intro-section";
import NewsPreviewSection from "@/components/sections/news-preview-section";
import StatsSection from "@/components/sections/stats-section";
import StudentLifePreview from "@/components/sections/student-life-preview";
import TestimonialsSection from "@/components/sections/testimonials-section";

export default function Home() {
  return (
    <>
      <HeroSection />
      <IntroSection />
      <AcademicsPreview />
      <StudentLifePreview />
      <TestimonialsSection />
      <StatsSection />
      <CtaSection />
      <NewsPreviewSection />
    </>
  );
}
