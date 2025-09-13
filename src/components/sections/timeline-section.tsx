'use client';

import { timelineData } from '@/lib/data';
import { AnimateOnScroll } from '../animate-on-scroll';
import Image from 'next/image';
import { CMFILogo } from '../icons';
import { useState, useEffect, useRef } from 'react';
import { cn } from '@/lib/utils';

const TimelineSection = () => {
  const journey = timelineData.map((item, index) => ({
    ...item,
    imageUrl: `https://picsum.photos/seed/timeline${index}/800/800`,
    imageHint: item.title.toLowerCase().replace(/\s/g, ' '),
    align: index % 2 === 0 ? 'left' : 'right',
  }));

  const [iconTop, setIconTop] = useState(0);
  const timelineRef = useRef<HTMLDivElement>(null);
  const iconRef = useRef<HTMLDivElement>(null);
  
  useEffect(() => {
    const handleScroll = () => {
      if (!timelineRef.current || !iconRef.current) return;

      const timelineRect = timelineRef.current.getBoundingClientRect();
      const iconHeight = iconRef.current.offsetHeight;
      const timelineHeight = timelineRef.current.scrollHeight;
      
      const scrollYInTimeline = window.innerHeight - timelineRect.top;
      
      let progress = 0;
      if (timelineRect.top < window.innerHeight && timelineRect.bottom > 0) {
        progress = scrollYInTimeline / (timelineHeight + window.innerHeight * 0.5);
      }
      
      const newTop = Math.min(
        timelineHeight - iconHeight,
        Math.max(0, timelineHeight * progress - (timelineHeight * 0.1))
      );
      
      setIconTop(newTop);
    };

    window.addEventListener('scroll', handleScroll);
    handleScroll(); 

    return () => window.removeEventListener('scroll', handleScroll);
  }, []);


  return (
    <section id="timeline" className="bg-primary text-primary-foreground">
      <div ref={timelineRef} className="container mx-auto px-6">
        <AnimateOnScroll className="text-center">
          <h2 className="font-headline text-3xl md:text-4xl font-bold">Our Journey</h2>
          <p className="mt-4 max-w-2xl mx-auto text-lg text-primary-foreground/80">
            From our humble beginnings to becoming a beacon of education, discover the key milestones that have shaped CMFI.
          </p>
        </AnimateOnScroll>
        
        <div className="relative mt-24 space-y-24">
          <div className="absolute left-1/2 top-0 bottom-0 w-1 bg-primary-foreground/10 -translate-x-1/2 hidden md:block" />
          
          <div
            ref={iconRef}
            className="absolute left-1/2 -translate-x-1/2 h-10 w-10 p-1 rounded-full bg-background hidden md:flex items-center justify-center z-10 transition-all duration-100 ease-linear shadow-lg"
            style={{ top: `${iconTop}px` }}
          >
            <CMFILogo className="h-8 w-8" />
          </div>

          {journey.map((item, index) => (
            <AnimateOnScroll 
              key={item.year} 
              className={cn(`relative flex flex-col md:flex-row items-center gap-8 md:gap-12 w-full`)}
              delay={index * 100}
            >
              <div className={`w-full md:w-5/12 text-center md:text-left ${item.align === 'right' ? 'md:order-2' : ''}`}>
                <p className="font-headline text-5xl font-bold text-accent mb-2">{item.year}</p>
                <h3 className="font-headline text-2xl font-semibold mb-4">{item.title}</h3>
                <p className="text-primary-foreground/80">{item.description}</p>
              </div>

              <div className={`w-full md:w-5/12 ${item.align === 'right' ? 'md:order-1' : ''}`}>
                 <div className="relative aspect-square w-full max-w-md mx-auto">
                    <Image
                      src={item.imageUrl}
                      alt={item.title}
                      data-ai-hint={item.imageHint}
                      fill
                      className="object-cover"
                      style={{
                        clipPath: 'polygon(50% 0%, 90% 20%, 100% 60%, 75% 100%, 25% 100%, 0% 60%, 10% 20%)'
                      }}
                    />
                 </div>
              </div>
            </AnimateOnScroll>
          ))}
        </div>
      </div>
    </section>
  );
};

export default TimelineSection;
