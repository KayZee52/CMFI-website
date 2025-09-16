
'use client';

import { useState, useEffect } from 'react';
import Image from 'next/image';
import Link from 'next/link';
import { AnimateOnScroll } from '../animate-on-scroll';
import { ArrowRight } from 'lucide-react';
import { cn } from '@/lib/utils';

const EngagedLearningSection = () => {
    const images = [
        { src: '/images/engagedlearningpics/image1.jpeg', hint: 'students science lab' },
        { src: '/images/engagedlearningpics/image2.jpeg', hint: 'students debating' },
        { src: '/images/engagedlearningpics/image3.jpeg', hint: 'students library' },
        { src: '/images/engagedlearningpics/image4.jpeg', hint: 'student presentation' },
        { src: '/images/engagedlearningpics/image5.jpeg', hint: 'group project' },
        { src: '/images/engagedlearningpics/image6.jpeg', hint: 'art class' },
        { src: '/images/engagedlearningpics/image7.jpeg', hint: 'computer lab' },
        { src: '/images/engagedlearningpics/image8.jpeg', hint: 'music class' },
        { src: '/images/engagedlearningpics/image9.jpeg', hint: 'school assembly' },
    ];

    const [currentImageIndex, setCurrentImageIndex] = useState(0);

    useEffect(() => {
        const interval = setInterval(() => {
            setCurrentImageIndex((prevIndex) => (prevIndex + 1) % images.length);
        }, 5000); // Change image every 5 seconds

        return () => clearInterval(interval);
    }, [images.length]);

    const links = [
        { name: 'Explore Student Life', href: '/student-life' },
        { name: 'Visit Our Gallery', href: '/gallery' },
        { name: 'Get Admission Updates', href: '/admissions' },
        { name: 'Contact Our Team', href: '/contact' },
    ];

    return (
        <section className="bg-primary text-primary-foreground">
            <div className="container mx-auto px-6">
                <div className="grid md:grid-cols-2 gap-12 items-center">
                    <AnimateOnScroll
                        className="transition-all duration-700 ease-out"
                        style={{ transform: 'translateX(-5%)', opacity: 0 }}
                    >
                        <div className="relative aspect-[4/3] rounded-lg overflow-hidden shadow-2xl">
                             {images.map((image, index) => (
                                <Image
                                    key={image.src}
                                    src={image.src}
                                    alt="Students engaged in learning activities"
                                    data-ai-hint={image.hint}
                                    fill
                                    priority={index === 0}
                                    sizes="(max-width: 768px) 100vw, 50vw"
                                    className={cn(
                                        "object-cover transition-opacity duration-1000 ease-in-out",
                                        index === currentImageIndex ? "opacity-100" : "opacity-0"
                                    )}
                                />
                            ))}
                        </div>
                    </AnimateOnScroll>
                    <AnimateOnScroll
                        delay={200}
                        className="transition-all duration-700 ease-out"
                        style={{ transform: 'translateX(5%)', opacity: 0 }}
                    >
                        <h2 className="font-headline text-3xl font-bold">
                            Engaged Learning & Community
                        </h2>
                        <p className="mt-4 text-lg text-primary-foreground/80">
                            Our commitment to education extends beyond the classroom. We encourage students to explore their passions, engage with their peers, and grow as well-rounded individuals.
                        </p>
                        <ul className="mt-6 space-y-3">
                            {links.map((link) => (
                                <li key={link.name}>
                                    <Link href={link.href} className="inline-flex items-center gap-2 group text-accent hover:text-white transition-colors">
                                        <ArrowRight className="h-5 w-5 text-accent group-hover:text-white transition-colors" />
                                        <span className="font-semibold">{link.name}</span>
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </AnimateOnScroll>
                </div>
            </div>
        </section>
    );
}

export default EngagedLearningSection;
