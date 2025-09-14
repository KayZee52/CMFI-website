'use client';

import { useState } from 'react';
import Image from 'next/image';
import { Baby, Sparkles, BookOpen, Users, GraduationCap } from 'lucide-react';
import { AnimateOnScroll } from '../animate-on-scroll';
import { cn } from '@/lib/utils';
import { Button } from '../ui/button';

const journeyLevels = [
  {
    name: 'Nursery',
    icon: Baby,
    description: 'A nurturing start where curiosity and social skills blossom through play-based learning in a safe, caring environment.',
    imageUrl: '/images/levelsfive/nursery.jpeg',
    imageHint: 'children playing blocks'
  },
  {
    name: 'Kindergarten',
    icon: Sparkles,
    description: 'Building foundational literacy and numeracy skills while fostering creativity, independence, and a love for learning.',
    imageUrl: '/images/levelsfive/kindergarten.jpeg',
    imageHint: 'child painting colorful'
  },
  {
    name: 'Elementary',
    icon: BookOpen,
    description: 'Developing core academic competencies in a structured curriculum that encourages critical thinking and collaboration.',
    imageUrl: '/images/levelsfive/elementary.jpeg',
    imageHint: 'students reading library'
  },
  {
    name: 'Junior High',
    icon: Users,
    description: 'Transitioning to more advanced subjects, students deepen their knowledge and begin exploring specialized interests.',
    imageUrl: '/images/levelsfive/juniorhigh.jpeg',
    imageHint: 'teenagers science class'
  },
  {
    name: 'Senior High',
    icon: GraduationCap,
    description: 'A rigorous program focused on academic excellence, leadership development, and preparation for university and beyond.',
    imageUrl: '/images/levelsfive/seniorhigh.jpeg',
    imageHint: 'students graduation caps'
  },
];

const EducationalJourneySection = () => {
  const [activeLevel, setActiveLevel] = useState(journeyLevels[2]); // Default to Elementary

  return (
    <section className="bg-primary text-primary-foreground relative overflow-hidden">
      <div className="absolute inset-0">
        <span className="absolute -bottom-1/4 -right-1/4 text-white/5 font-bold text-[40rem] leading-none select-none">
          5
        </span>
      </div>

      <div className="container mx-auto px-6 relative z-10">
        <AnimateOnScroll className="text-center">
          <h2 className="font-headline text-3xl md:text-4xl font-bold">The CMFI Journey</h2>
          <p className="mt-4 max-w-2xl mx-auto text-lg text-primary-foreground/80">
            An all-through education designed to build character and intellect from nursery to graduation.
          </p>
        </AnimateOnScroll>
        
        <div className="mt-16 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <AnimateOnScroll className="relative aspect-video rounded-lg overflow-hidden border-4 border-white/10 shadow-2xl">
                 {journeyLevels.map(level => (
                    <Image
                        key={level.name}
                        src={level.imageUrl}
                        alt={level.name}
                        data-ai-hint={level.imageHint}
                        fill
                        sizes="(max-width: 768px) 100vw, 50vw"
                        className={cn(
                            "object-cover transition-opacity duration-500",
                            activeLevel.name === level.name ? "opacity-100" : "opacity-0"
                        )}
                    />
                 ))}
            </AnimateOnScroll>

            <AnimateOnScroll delay={200} className="space-y-4">
                {journeyLevels.map(level => (
                    <div
                        key={level.name}
                        className={cn(
                            "p-4 rounded-lg cursor-pointer transition-all duration-300",
                            activeLevel.name === level.name 
                                ? 'bg-white/10' 
                                : 'bg-transparent hover:bg-white/5'
                        )}
                        onMouseEnter={() => setActiveLevel(level)}
                    >
                        <div className="flex items-center gap-4">
                            <div className={cn("p-2 rounded-full transition-colors", activeLevel.name === level.name ? 'bg-accent text-accent-foreground' : 'bg-white/10 text-white')}>
                                <level.icon className="h-6 w-6" />
                            </div>
                            <h3 className="font-headline text-xl font-semibold">{level.name}</h3>
                        </div>
                        {activeLevel.name === level.name && (
                             <p className="mt-2 text-primary-foreground/80 pl-12 animate-in fade-in duration-500">
                                {level.description}
                            </p>
                        )}
                    </div>
                ))}
            </AnimateOnScroll>
        </div>
      </div>
    </section>
  );
};

export default EducationalJourneySection;
