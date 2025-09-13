'use client';

import { useRef, useEffect } from 'react';
import Link from 'next/link';
import { Button } from '@/components/ui/button';
import { AnimateOnScroll } from '../animate-on-scroll';
import { ChevronDown } from 'lucide-react';
import { Typewriter } from '../typewriter';

const HeroSection = () => {
  const videoUrl = "/videos/hero-video.mp4";
  const videoRef = useRef<HTMLVideoElement>(null);

  useEffect(() => {
    if (videoRef.current) {
      videoRef.current.playbackRate = 0.75;
    }
  }, []);
  
  const typewriterPhrases = [
    "Leader",
    "Scholar",
    "Global Citizen",
    "Person of Integrity",
    "Champion",
  ];

  return (
    <section id="home" className="relative h-screen min-h-[700px] flex items-center text-white overflow-hidden">
      <video
        ref={videoRef}
        src={videoUrl}
        autoPlay
        loop
        muted
        playsInline
        className="absolute top-1/2 left-1/2 w-full h-full min-w-full min-h-full object-cover transform -translate-x-1/2 -translate-y-1/2 z-0 blur-sm"
      />
      <div className="absolute inset-0 bg-black/10 z-10" />
      <div className="relative z-20 container mx-auto px-6 w-full h-full flex flex-col justify-center">
        <div className="max-w-2xl text-left">
          <AnimateOnScroll>
            <h2 className="font-headline text-lg md:text-xl tracking-[0.3em] font-light uppercase text-white/80">
              CMFI Bilingual High School
            </h2>
          </AnimateOnScroll>
          <AnimateOnScroll delay={200}>
            <h1 className="font-headline text-5xl md:text-8xl font-bold tracking-tight mt-4 h-32 md:h-48">
              Be A <Typewriter phrases={typewriterPhrases} />
            </h1>
          </AnimateOnScroll>
          <AnimateOnScroll delay={400}>
            <p className="mt-6 max-w-xl text-base md:text-lg text-white/90">
              CMFI Bilingual High School is a private Nursery–Grade 12 institution where students grow in knowledge, character, and leadership — preparing for higher education and life with strong values and discipline.
            </p>
          </AnimateOnScroll>
          <AnimateOnScroll delay={600}>
            <div className="mt-10 flex flex-col sm:flex-row items-start gap-4">
              <Button asChild size="lg" className="w-full sm:w-auto bg-accent hover:bg-accent/90 text-accent-foreground">
                <Link href="/admissions">
                  Apply Now
                </Link>
              </Button>
              <Button asChild size="lg" variant="outline" className="w-full sm:w-auto text-white border-white hover:bg-white hover:text-primary">
                <Link href="/contact">
                  Inquire
                </Link>
              </Button>
            </div>
          </AnimateOnScroll>
        </div>
        <AnimateOnScroll delay={800} className="absolute bottom-10 left-1/2 -translate-x-1/2">
            <Link href="#about-preview" aria-label="Scroll to next section">
                <ChevronDown className="h-10 w-10 animate-bounce" />
            </Link>
        </AnimateOnScroll>
      </div>
    </section>
  );
};

export default HeroSection;
