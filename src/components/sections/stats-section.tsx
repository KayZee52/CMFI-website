'use client';

import { useEffect, useRef, useState } from 'react';
import { AnimateOnScroll } from '../animate-on-scroll';
import { stats } from '@/lib/data';

const Counter = ({ number, suffix }: { number: number; suffix: string }) => {
  const [count, setCount] = useState(0);
  const ref = useRef<HTMLSpanElement>(null);
  const [isInView, setIsInView] = useState(false);

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setIsInView(true);
        }
      },
      { threshold: 0.1 }
    );

    const currentRef = ref.current;
    if (currentRef) {
      observer.observe(currentRef);
    }

    return () => {
      if (currentRef) {
        observer.unobserve(currentRef);
      }
    };
  }, []);

  useEffect(() => {
    if (isInView) {
      let start = 0;
      const end = number;
      if (start === end) return;

      const duration = 2000;
      const incrementTime = (duration / end);

      const timer = setInterval(() => {
        start += 1;
        setCount(start);
        if (start === end) {
          clearInterval(timer);
        }
      }, incrementTime);

      return () => clearInterval(timer);
    }
  }, [isInView, number]);

  return (
    <span ref={ref} className="font-headline text-5xl md:text-6xl font-bold text-accent">
      {count}{suffix}
    </span>
  );
};


const StatsSection = () => {
  return (
    <section className="bg-primary/5">
      <div className="container mx-auto px-6">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          {stats.map((stat) => (
            <AnimateOnScroll key={stat.label}>
              <div className="flex flex-col items-center justify-center">
                <Counter number={stat.number} suffix={stat.suffix} />
                <p className="mt-2 text-muted-foreground font-medium">{stat.label}</p>
              </div>
            </AnimateOnScroll>
          ))}
        </div>
      </div>
    </section>
  );
};

export default StatsSection;
