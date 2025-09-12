import AboutPageContent from "@/components/sections/about-section";
import CtaSection from "@/components/sections/cta-section";
import TimelineSection from "@/components/sections/timeline-section";
import WhyChooseUsSection from "@/components/sections/why-choose-us-section";

export default function AboutPage() {
  return (
    <>
      <AboutPageContent />
      <TimelineSection />
      <WhyChooseUsSection />
      <CtaSection />
    </>
  );
}
