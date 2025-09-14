import AboutPageContent from "@/components/sections/about-section";
import EducationalJourneySection from "@/components/sections/educational-journey-section";
import MarqueeCtaSection from "@/components/sections/marquee-cta-section";
import TimelineSection from "@/components/sections/timeline-section";
import WhyChooseUsSection from "@/components/sections/why-choose-us-section";

export default function AboutPage() {
  return (
    <>
      <AboutPageContent />
      <EducationalJourneySection />
      <TimelineSection />
      <WhyChooseUsSection />
      <MarqueeCtaSection />
    </>
  );
}
