
'use client';

import { AnimateOnScroll } from "@/components/animate-on-scroll";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { testimonials } from "@/lib/data";
import { MessageCircle, Handshake, Users, Calendar, Download, Phone } from "lucide-react";
import Image from "next/image";
import Link from "next/link";
import { Carousel, CarouselContent, CarouselItem } from '@/components/ui/carousel';
import Autoplay from "embla-carousel-autoplay";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";


const ParentsPage = () => {

    const involvement = [
        { icon: Users, title: 'Parent-Teacher Meetings', description: 'Regular updates on student progress and collaborative planning for their success.' },
        { icon: Calendar, title: 'School Events', description: 'Parents are warmly invited to graduations, competitions, and open day events.' },
        { icon: Handshake, title: 'Support & Feedback', description: "We value parents' input to continuously improve our programs and school environment." },
    ];

    const resources = [
        { icon: Download, title: 'Student Handbook (PDF)', description: 'Access the complete guide to our school policies, rules, and student expectations.' },
        { icon: Calendar, title: 'School Calendar', description: 'View key dates for the academic year, including holidays and exam periods.' },
        { icon: Phone, title: 'Communication Channels', description: 'Stay connected through newsletters, our parent portal, and direct office contact.' },
    ];

    const parentTestimonials = testimonials.filter(t => t.role === 'Parent');

    return (
        <>
             <section className="relative h-[400px] flex items-center justify-center text-center text-white">
                <Image
                    src="/images/heroimages/parentshero.jpeg"
                    alt="Parent and student smiling together"
                    fill
                    priority
                    sizes="100vw"
                    className="object-cover object-center"
                    data-ai-hint="family happy"
                />
                <div className="absolute inset-0 bg-black/60" />
                <div className="relative z-10 container mx-auto px-6">
                    <AnimateOnScroll>
                        <h1 className="font-headline text-4xl md:text-6xl font-bold tracking-tight">
                            For Our Parents
                        </h1>
                        <p className="mt-4 text-lg md:text-xl text-white/90">
                           Your partnership makes education stronger.
                        </p>
                    </AnimateOnScroll>
                </div>
            </section>

             <section className="bg-card">
                <div className="container mx-auto px-6 text-center">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl font-bold">A Message to Parents</h2>
                        <p className="mt-4 max-w-3xl mx-auto text-lg text-muted-foreground">
                             At CMFI Bilingual High School, we recognize that parents are our key partners in shaping the success of every student. This page provides resources, updates, and opportunities to stay connected with your child’s journey.
                        </p>
                    </AnimateOnScroll>
                </div>
            </section>

             <section id="involvement" className="bg-background">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                         <h2 className="font-headline text-3xl md:text-4xl font-bold">How Parents Stay Involved</h2>
                    </AnimateOnScroll>
                     <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                        {involvement.map((item, index) => (
                             <AnimateOnScroll key={item.title} delay={index * 100}>
                                <Card className="flex flex-col items-center p-6 text-center hover:shadow-lg transition-shadow h-full">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                                        <item.icon className="h-10 w-10" />
                                    </div>
                                    <h3 className="font-headline text-xl font-semibold mb-2">{item.title}</h3>
                                    <p className="text-muted-foreground">{item.description}</p>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                     </div>
                </div>
            </section>

            <section className="bg-card">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">Helpful Resources</h2>
                    </AnimateOnScroll>
                     <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                        {resources.map((resource, index) => (
                             <AnimateOnScroll key={resource.title} delay={index * 100}>
                                <Card className="p-6 text-center bg-primary/5 h-full">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4 inline-block">
                                        <resource.icon className="h-8 w-8" />
                                    </div>
                                    <h3 className="font-headline text-xl font-bold mb-2">{resource.title}</h3>
                                    <p className="text-muted-foreground">{resource.description}</p>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                    </div>
                     <div className="text-center mt-12">
                        <Button asChild>
                            <Link href="/contact">Download Resources</Link>
                        </Button>
                    </div>
                </div>
            </section>

            <section className="bg-background">
                <div className="container mx-auto px-6 text-center">
                    <AnimateOnScroll>
                         <h2 className="font-headline text-3xl md:text-4xl font-bold">What Our Parents Say</h2>
                    </AnimateOnScroll>
                    <AnimateOnScroll delay={200} className="mt-12 max-w-4xl mx-auto">
                        <Carousel 
                            opts={{ align: "start", loop: true }}
                            plugins={[Autoplay({ delay: 5000 })]}
                            className="w-full"
                        >
                            <CarouselContent>
                                {parentTestimonials.map((testimonial, index) => (
                                    <CarouselItem key={index}>
                                        <div className="p-4">
                                            <div className="flex flex-col items-center text-center">
                                                <Avatar className="w-20 h-20 mb-4">
                                                    <AvatarImage src={`https://picsum.photos/seed/parent-avatar${index}/100`} alt={testimonial.name} />
                                                    <AvatarFallback>{testimonial.name.charAt(0)}</AvatarFallback>
                                                </Avatar>
                                                <p className="text-lg text-muted-foreground mb-4 max-w-2xl">"{testimonial.quote}"</p>
                                                <p className="font-bold font-headline text-lg">{testimonial.name}</p>
                                                <p className="text-sm text-muted-foreground">{testimonial.role}</p>
                                            </div>
                                        </div>
                                    </CarouselItem>
                                ))}
                            </CarouselContent>
                        </Carousel>
                    </AnimateOnScroll>
                </div>
            </section>
            
            <section className="relative bg-primary text-primary-foreground">
                 <Image 
                    src="https://picsum.photos/seed/cta-parents/1920/1080"
                    fill
                    sizes="100vw"
                    className="object-cover opacity-20"
                    alt="Parents at a school event"
                    data-ai-hint="parents cheering"
                />
                <div className="absolute inset-0 bg-primary/80" />
                <div className="container mx-auto px-6 text-center relative z-10">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">
                           Together, we build leaders for tomorrow.
                        </h2>
                        <div className="mt-8 flex justify-center">
                            <Button asChild size="lg" variant="secondary">
                                <Link href="/contact">Contact the School</Link>
                            </Button>
                        </div>
                    </AnimateOnScroll>
                </div>
            </section>
        </>
    );
}

export default ParentsPage;
