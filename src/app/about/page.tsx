import AboutPageContent from "@/components/sections/about-section";
import CtaSection from "@/components/sections/cta-section";
import EducationalJourneySection from "@/components/sections/educational-journey-section";
import TimelineSection from "@/components/sections/timeline-section";
import WhyChooseUsSection from "@/components/sections/why-choose-us-section";

export default function AboutPage() {
  return (
    <>
      <AboutPageContent />
      <EducationalJourneySection />
      <TimelineSection />
      <WhyChooseUsSection />
      <CtaSection />
    </>
  );
}
