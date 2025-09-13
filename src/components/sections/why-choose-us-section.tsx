'use client';

import { AnimateOnScroll } from '../animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { BookOpen, Users, Laptop } from 'lucide-react';

const WhyChooseUsSection = () => {
    const features = [
        {
            icon: BookOpen,
            title: 'Excellence in Learning',
            description: 'We are committed to providing a rigorous academic environment that challenges students to achieve their full potential.'
        },
        {
            icon: Users,
            title: 'Respect & Discipline',
            description: 'We foster a supportive community that emphasizes discipline, integrity, and service to others.'
        },
        {
            icon: Laptop,
            title: 'ICT & Modern Facilities',
            description: 'We integrate modern technology and facilities to prepare students for the digital age.'
        },
    ];

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
                            <Card className="text-center h-full hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                                <CardHeader className="items-center">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                                        <feature.icon className="h-8 w-8" />
                                    </div>
                                    <CardTitle className="font-headline text-xl">{feature.title}</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-muted-foreground">{feature.description}</p>
                                </CardContent>
                            </Card>
                        </AnimateOnScroll>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default WhyChooseUsSection;
