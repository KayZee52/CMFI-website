
'use client';

import Image from 'next/image';
import { CMFILogo } from '../icons';
import { BookOpen, Users, Laptop } from 'lucide-react';
import { cn } from '@/lib/utils';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '../ui/carousel';
import Autoplay from "embla-carousel-autoplay"

const features = [
    {
        icon: BookOpen,
        title: 'Excellence in Learning',
        description: 'We are committed to providing a rigorous academic environment that challenges students to achieve their full potential.',
        imageUrl: 'https://picsum.photos/seed/learning-student/600/800',
        imageHint: 'student reading book',
        color: 'bg-primary'
    },
    {
        icon: Users,
        title: 'Respect & Discipline',
        description: 'We foster a supportive community that emphasizes discipline, integrity, and service to others.',
        imageUrl: 'https://picsum.photos/seed/respect-student/600/800',
        imageHint: 'students helping community',
        color: 'bg-primary'
    },
    {
        icon: Laptop,
        title: 'Modern Facilities',
        description: 'We integrate modern technology and facilities to prepare students for the digital age.',
        imageUrl: 'https://picsum.photos/seed/ict-student/600/800',
        imageHint: 'student using computer',
        color: 'bg-primary'
    },
];

const WhyChooseUsSection = () => {
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
                        opts={{ align: "start", loop: true }}
                        plugins={[
                            Autoplay({
                              delay: 5000,
                            }),
                        ]}
                        className="w-full max-w-sm mx-auto md:max-w-md"
                    >
                        <CarouselContent>
                            {features.map((feature, index) => (
                                <CarouselItem key={index} className="[perspective:1000px]">
                                    <div className="group relative h-[600px] w-full overflow-hidden rounded-lg shadow-xl text-white p-8 flex flex-col justify-between mx-auto transition-transform duration-500 transform-style-3d data-[in-view=false]:rotate-y-15">
                                        <Image 
                                            src={feature.imageUrl} 
                                            alt={feature.title} 
                                            data-ai-hint={feature.imageHint}
                                            fill 
                                            className="object-cover object-top" 
                                        />
                                        <div className="absolute inset-0 bg-primary/80" />

                                        <div className="relative z-10 flex flex-col h-full">
                                            <div className="flex justify-center">
                                                <div className="p-4 bg-white/20 rounded-full">
                                                  <feature.icon className="h-8 w-8 text-white" />
                                                </div>
                                            </div>

                                            <div className="flex-grow flex items-center justify-center -mt-12">
                                                <h3 className="font-headline text-4xl text-center font-semibold tracking-tight">{feature.title}</h3>
                                            </div>
                                            
                                            <div className="text-center">
                                                 <p className="text-white/90">{feature.description}</p>
                                            </div>
                                        </div>
                                    </div>
                                </CarouselItem>
                            ))}
                        </CarouselContent>
                        <CarouselPrevious className="hidden sm:flex left-[-50px]" />
                        <CarouselNext className="hidden sm:flex right-[-50px]" />
                    </Carousel>
                </div>
            </div>
        </section>
    );
}

export default WhyChooseUsSection;
