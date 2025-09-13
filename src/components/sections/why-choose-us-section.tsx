
'use client';

import Image from 'next/image';
import { AnimateOnScroll } from '../animate-on-scroll';
import { CMFILogo } from '../icons';
import { BookOpen, Users, Laptop, Info } from 'lucide-react';
import { cn } from '@/lib/utils';

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
                <AnimateOnScroll className="text-center">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">Why Choose CMFI?</h2>
                    <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                        We are committed to building future leaders through excellence, discipline, and modern innovation.
                    </p>
                </AnimateOnScroll>
                <div className="mt-16 grid md:grid-cols-3 gap-8">
                    {features.map((feature, index) => (
                        <AnimateOnScroll key={index} delay={index * 150}>
                            <div className={cn("group relative h-[600px] w-full overflow-hidden rounded-lg shadow-xl text-white p-8 flex flex-col justify-between", feature.color)}>
                                <div className="absolute inset-0 h-full w-full">
                                    <Image 
                                        src={feature.imageUrl} 
                                        alt={feature.title} 
                                        data-ai-hint={feature.imageHint}
                                        fill 
                                        className="object-cover object-top opacity-0 group-hover:opacity-20 transition-opacity duration-500" 
                                    />
                                </div>

                                <div className="relative z-10 flex flex-col h-full">
                                    <div className="flex justify-center">
                                        <CMFILogo className="h-12 w-12 text-white/80" />
                                    </div>

                                    <div className="flex-grow flex items-center justify-center -mt-12">
                                        <h3 className="font-headline text-4xl text-center font-semibold tracking-tight">{feature.title}</h3>
                                    </div>
                                    
                                    <div className="absolute bottom-8 left-8 right-8 text-center transition-all duration-500 opacity-0 group-hover:opacity-100 transform group-hover:translate-y-0 translate-y-10">
                                         <p className="text-white/90">{feature.description}</p>
                                    </div>
                                    
                                    <div className="flex justify-center mb-4 transition-opacity duration-300 opacity-100 group-hover:opacity-0">
                                        <div className="bg-white/30 rounded-full p-2">
                                            <Info className="h-5 w-5 text-white" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </AnimateOnScroll>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default WhyChooseUsSection;
