'use client';

import { useRef, useEffect, useState, type ReactNode } from 'react';
import { cn } from '@/lib/utils';

type AnimateOnScrollProps = {
  children: ReactNode;
  className?: string;
  delay?: number;
  threshold?: number;
  style?: React.CSSProperties;
};

export function AnimateOnScroll({ children, className, delay = 0, threshold = 0.1, style: initialStyle }: AnimateOnScrollProps) {
  const [isVisible, setIsVisible] = useState(false);
  const ref = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setIsVisible(true);
          observer.unobserve(entry.target);
        }
      },
      { threshold }
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
  }, [threshold]);

  const style: React.CSSProperties = {
    transitionDelay: `${delay}ms`,
    ...initialStyle,
  };
  
  const visibleStyle: React.CSSProperties = {
      opacity: 1,
      transform: 'translateY(0) translateX(0)',
  };

  const defaultHiddenStyle: React.CSSProperties = {
      opacity: 0,
      transform: 'translateY(5px)',
  }

  return (
    <div
      ref={ref}
      className={cn(
        'transition-all duration-700 ease-out',
        className
      )}
      style={isVisible ? { ...style, ...visibleStyle } : { ...style, ...defaultHiddenStyle, ...initialStyle }}
    >
      {children}
    </div>
  );
}
