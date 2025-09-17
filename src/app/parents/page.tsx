

'use client';

import { AnimateOnScroll } from "@/components/animate-on-scroll";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { testimonials } from "@/lib/data";
import { Handshake, Users, Calendar, Download, Phone, MessageCircle } from "lucide-react";
import Image from "next/image";
import Link from "next/link";
import { Carousel, CarouselContent, CarouselItem } from '@/components/ui/carousel';
import Autoplay from "embla-carousel-autoplay";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Typewriter } from "@/components/typewriter";
import { useState } from "react";
import { cn } from "@/lib/utils";


const ParentsPage = () => {

    const involvement = [
        { 
            icon: Users, 
            title: 'Parent-Teacher Meetings', 
            description: 'Engage in regular, meaningful conversations about your child’s academic progress and well-being. We schedule dedicated conference days and are available by appointment to ensure we work together for their success.' 
        },
        { 
            icon: Calendar, 
            title: 'School Events & Volunteering', 
            description: 'Become part of our vibrant community by attending graduations, sports days, and cultural events. We also welcome parent volunteers to support various school activities.' 
        },
        { 
            icon: Handshake, 
            title: 'Support & Feedback Channels', 
            description: "Your perspective is invaluable. We actively encourage parents to share their feedback through our Parent-Teacher Association (PTA), suggestion boxes, and direct communication with the administration." 
        },
    ];

    const involvementImages = [
        { src: 'https://picsum.photos/seed/parent-meeting/800/600', hint: 'parent teacher meeting' },
        { src: 'https://picsum.photos/seed/parent-volunteer/800/600', hint: 'parent volunteering school' },
        { src: 'https://picsum.photos/seed/parent-event/800/600', hint: 'parents school event' },
    ];
    
    const [activeInvolvementImage, setActiveInvolvementImage] = useState(involvementImages[0]);


    const resources = [
        { icon: Download, title: 'Student Handbook (PDF)', description: 'Access the complete guide to our school policies, rules, and student expectations.' },
        { icon: Calendar, title: 'School Calendar', description: 'View key dates for the academic year, including holidays and exam periods.' },
        { icon: Phone, title: 'Communication Channels', description: 'Stay connected through newsletters, our parent portal, and direct office contact.' },
    ];

    const parentTestimonials = testimonials.filter(t => t.role === 'Parent');

    const typewriterPhrases = [
        "Guardians",
        "Heroes",
        "Role Models",
        "Protectors",
    ];

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
                            For Our <Typewriter phrases={typewriterPhrases} typingSpeed={150} deletingSpeed={100} />
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
                        <h2 className="font-headline text-3xl font-bold">Partners in Education</h2>
                        <p className="mt-4 max-w-3xl mx-auto text-lg text-muted-foreground">
                             Dear Parents and Guardians, we see you as our most important partners in nurturing the leaders of tomorrow. Your engagement, support, and feedback are the cornerstones of our community. This space is dedicated to providing you with the resources and information you need to stay connected and involved in your child’s educational journey at CMFI.
                        </p>
                    </AnimateOnScroll>
                </div>
            </section>

             <section id="involvement" className="bg-primary/5">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                         <h2 className="font-headline text-3xl md:text-4xl font-bold">A Partnership for Success</h2>
                    </AnimateOnScroll>
                     <div className="mt-16 grid md:grid-cols-2 gap-12 items-center">
                        <AnimateOnScroll className="relative aspect-[4/3] rounded-lg overflow-hidden border-4 border-white/10 shadow-xl">
                            {involvementImages.map((image, index) => (
                                <Image
                                    key={image.src}
                                    src={image.src}
                                    alt={image.hint}
                                    data-ai-hint={image.hint}
                                    fill
                                    sizes="(max-width: 768px) 100vw, 50vw"
                                    className={cn(
                                        "object-cover transition-opacity duration-1000",
                                        activeInvolvementImage.src === image.src ? "opacity-100" : "opacity-0"
                                    )}
                                />
                            ))}
                        </AnimateOnScroll>
                         <AnimateOnScroll className="space-y-6" delay={200}>
                            {involvement.map((item, index) => (
                                <div
                                    key={item.title}
                                    onMouseEnter={() => setActiveInvolvementImage(involvementImages[index])}
                                    className="p-6 rounded-lg bg-card hover:bg-primary/5 transition-colors duration-300"
                                >
                                    <div className="flex items-start gap-4">
                                        <div className="p-3 bg-primary/10 text-primary rounded-full mt-1">
                                            <item.icon className="h-6 w-6" />
                                        </div>
                                        <div>
                                            <h3 className="font-headline text-xl font-semibold mb-1">{item.title}</h3>
                                            <p className="text-muted-foreground">{item.description}</p>
                                        </div>
                                    </div>
                                </div>
                            ))}
                         </AnimateOnScroll>
                     </div>
                </div>
            </section>

            <section className="bg-background">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">Helpful Resources</h2>
                    </AnimateOnScroll>
                     <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                        {resources.map((resource, index) => (
                             <AnimateOnScroll key={resource.title} delay={index * 100}>
                                <Card className="p-6 text-center bg-primary/10 backdrop-blur-sm border border-primary/20 h-full transition-all duration-300 group hover:shadow-2xl hover:border-accent/80">
                                    <div className="p-4 bg-primary/10 rounded-full mb-4 inline-block transition-transform duration-300 group-hover:scale-110">
                                        <resource.icon className="h-8 w-8 text-primary" />
                                    </div>
                                    <h3 className="font-headline text-xl font-bold mb-2 text-foreground">{resource.title}</h3>
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

            <section className="bg-primary text-primary-foreground">
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
                                        <Card className="bg-card/10 border-card/20 text-primary-foreground">
                                            <CardContent className="p-8 flex flex-col items-center text-center">
                                                <Avatar className="w-20 h-20 mb-6 border-4 border-card/50">
                                                    <AvatarImage src={`https://picsum.photos/seed/parent-avatar${index}/100`} alt={testimonial.name} />
                                                    <AvatarFallback>{testimonial.name.charAt(0)}</AvatarFallback>
                                                </Avatar>
                                                <p className="text-lg text-primary-foreground/90 mb-6 max-w-2xl">"{testimonial.quote}"</p>
                                                <p className="font-bold font-headline text-accent">{testimonial.name}</p>
                                                <p className="text-sm text-primary-foreground/70">{testimonial.role}</p>
                                            </CardContent>
                                        </Card>
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
