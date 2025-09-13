'use client';

import { useState, useEffect, useCallback } from 'react';
import Image from 'next/image';
import { CMFILogo } from '../icons';
import { BookOpen, Users, Laptop } from 'lucide-react';
import { cn } from '@/lib/utils';
import { Carousel, CarouselContent, CarouselItem, type CarouselApi } from '../ui/carousel';
import Autoplay from "embla-carousel-autoplay"

const features = [
    {
        icon: BookOpen,
        title: 'Excellence in Learning',
        description: 'We are committed to providing a rigorous academic environment that challenges students to achieve their full potential.',
        imageUrl: '/images/excellence-inlearning.png',
        imageHint: 'student reading book',
    },
    {
        icon: Users,
        title: 'Respect & Discipline',
        description: 'We foster a supportive community that emphasizes discipline, integrity, and service to others.',
        imageUrl: '/images/respect-descipline.png',
        imageHint: 'students helping community',
    },
    {
        icon: Laptop,
        title: 'Modern Facilities',
        description: 'We integrate modern technology and facilities to prepare students for the digital age.',
        imageUrl: '/images/modern-facilities.png',
        imageHint: 'student using computer',
    },
];

const WhyChooseUsSection = () => {
    const [api, setApi] = useState<CarouselApi>()
    const [current, setCurrent] = useState(0)

    useEffect(() => {
        if (!api) {
            return
        }

        setCurrent(api.selectedScrollSnap())

        const onSelect = (api: CarouselApi) => {
            setCurrent(api.selectedScrollSnap())
        }

        api.on("select", onSelect)

        return () => {
            api.off("select", onSelect)
        }
    }, [api])


    return (
        <section id="why-choose-us" className="bg-card">
            <div className="container mx-auto px-6">
                <div className="text-center">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">Why Choose CMFI?</h2>
                    <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                        We are committed to building future leaders through excellence, discipline, and modern innovation.
                    </p>
                </div>
                <div className="mt-16">
                    <Carousel
                        setApi={setApi}
                        opts={{ align: "start", loop: true }}
                        plugins={[
                            Autoplay({
                              delay: 5000,
                            }),
                        ]}
                        className="w-full max-w-sm mx-auto md:max-w-md"
                    >
                        <CarouselContent>
                            {features.map((feature, index) => {
                                const isActive = index === current;
                                return (
                                <CarouselItem key={index}>
                                    <div className="group relative h-[600px] w-full overflow-hidden rounded-lg shadow-xl text-white p-8 flex flex-col justify-between mx-auto">
                                        <Image 
                                            src={feature.imageUrl} 
                                            alt={feature.title} 
                                            fill 
                                            className="object-cover object-top" 
                                        />
                                        <div className="absolute inset-0 bg-primary/80" />

                                        <div className="relative z-10 flex flex-col h-full items-center">
                                            <div className={cn("transition-all duration-700", isActive ? 'animate-flip-in-y' : 'opacity-0')}>
                                                <CMFILogo className="h-20 w-20 text-white/80" />
                                            </div>

                                            <div className="flex-grow flex items-center justify-center -mt-12 text-center">
                                                <h3 className="font-headline text-4xl font-semibold tracking-tight">
                                                    {feature.title.split(' ').map((word, i) => (
                                                         <span
                                                            key={i}
                                                            className={cn("inline-block transition-all duration-500", isActive ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4')}
                                                            style={{ transitionDelay: `${isActive ? 200 + i * 100 : 0}ms` }}
                                                        >
                                                            {word}&nbsp;
                                                        </span>
                                                    ))}
                                                </h3>
                                            </div>
                                            
                                            <div className="text-center">
                                                 <p 
                                                    className={cn("text-white/90 transition-all duration-500", isActive ? 'animate-slide-in-from-right' : 'opacity-0')}
                                                    style={{ animationDelay: `${isActive ? '600ms' : '0ms'}`}}
                                                >
                                                    {feature.description}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </CarouselItem>
                            )})}
                        </CarouselContent>
                    </Carousel>
                </div>
            </div>
        </section>
    );
}

export default WhyChooseUsSection;
