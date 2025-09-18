
'use client';

import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Medal, Trophy, BrainCircuit, GraduationCap, Users, HeartHandshake, School, ChevronRight, ChevronLeft } from 'lucide-react';
import Link from 'next/link';
import Image from 'next/image';
import { testimonials } from '@/lib/data';
import { Carousel, CarouselContent, CarouselItem } from '@/components/ui/carousel';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import Autoplay from "embla-carousel-autoplay"
import { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';

const StudentLifePage = () => {
    
    const sports = [
        { icon: Trophy, title: 'Football', description: 'Team spirit, training, and inter-school matches.', imageUrl: 'https://picsum.photos/seed/football/800/600', hint: 'students playing football' },
        { icon: Medal, title: 'Basketball', description: 'Encouraging discipline, teamwork, and fitness.', imageUrl: 'https://picsum.photos/seed/basketball/800/600', hint: 'students playing basketball' },
        { icon: Trophy, title: 'Kickball', description: 'Fun, energy, and school-wide participation.', imageUrl: 'https://picsum.photos/seed/kickball/800/600', hint: 'students playing kickball' },
    ];

    const events = [
        { icon: BrainCircuit, title: 'Quiz Competitions', description: 'Showcasing academic excellence and sharp minds.' },
        { icon: GraduationCap, title: 'Graduation & Recognition Day', description: 'Celebrating student milestones and achievements.' },
    ];
    
    const community = [
        { icon: Users, title: "Parents' Involvement" },
        { icon: School, title: "School-wide Activities" },
        { icon: HeartHandshake, title: "Community Service" },
    ];

    const merchandiseByColor = [
        {
            color: 'Blue',
            items: [
                { name: 'School T-Shirt', imageUrl: '/images/merchs/blueShirt.png', hint: 'blue school t-shirt' },
                { name: 'Backpack', imageUrl: '/images/merchs/blueBackpack.png', hint: 'blue school backpack' },
                { name: 'Water Bottle', imageUrl: '/images/merchs/blueBottle.png', hint: 'blue water bottle' },
            ]
        },
        {
            color: 'Brown',
            items: [
                { name: 'School T-Shirt', imageUrl: '/images/merchs/brownShirt.png', hint: 'brown school t-shirt' },
                { name: 'Backpack', imageUrl: '/images/merchs/brownBackpack.png', hint: 'brown school backpack' },
                { name: 'Water Bottle', imageUrl: '/images/merchs/brownBottle.png', hint: 'brown water bottle' },
            ]
        },
        {
            color: 'Pink',
            items: [
                { name: 'School T-Shirt', imageUrl: '/images/merchs/pinkShirt.png', hint: 'pink school t-shirt' },
                { name: 'Backpack', imageUrl: '/images/merchs/pinkBackpack.png', hint: 'pink school backpack' },
                { name: 'Water Bottle', imageUrl: '/images/merchs/pinkBottle.png', hint: 'pink water bottle' },
            ]
        }
    ];

    const [currentColorIndex, setCurrentColorIndex] = useState(0);

    useEffect(() => {
        const intervalId = setInterval(() => {
            setCurrentColorIndex(prevIndex => (prevIndex + 1) % merchandiseByColor.length);
        }, 5000); // Change color every 5 seconds

        return () => clearInterval(intervalId);
    }, [merchandiseByColor.length]);

    const studentTestimonials = testimonials.filter(t => t.role.includes('Student'));
    
    return (
        <>
            <section className="relative h-[400px] flex items-center justify-center text-center text-white">
                <Image
                    src="https://picsum.photos/seed/student-life-hero/1920/1080"
                    alt="Students smiling"
                    fill
                    priority
                    sizes="100vw"
                    className="object-cover object-center"
                    data-ai-hint="students smiling group"
                />
                <div className="absolute inset-0 bg-black/60" />
                <div className="relative z-10 container mx-auto px-6">
                    <AnimateOnScroll>
                        <h1 className="font-headline text-4xl md:text-6xl font-bold tracking-tight">
                            Student Life at CMFI
                        </h1>
                        <p className="mt-4 text-lg md:text-xl text-white/90">
                           More than academics — a place to grow, connect, and thrive.
                        </p>
                    </AnimateOnScroll>
                </div>
            </section>

            <section id="sports" className="bg-background">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">Sports & Athletics</h2>
                    </AnimateOnScroll>
                    <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                        {sports.map((sport, index) => (
                            <AnimateOnScroll key={sport.title} delay={index * 100}>
                                <Card className="overflow-hidden group hover:shadow-xl transition-shadow">
                                    <div className="relative aspect-video">
                                        <Image src={sport.imageUrl} fill sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" className="object-cover group-hover:scale-105 transition-transform duration-300" alt={sport.title} data-ai-hint={sport.hint} />
                                    </div>
                                    <CardHeader>
                                        <CardTitle className="font-headline flex items-center gap-3"><sport.icon className="h-6 w-6 text-primary"/>{sport.title}</CardTitle>
                                    </CardHeader>
                                    <CardContent>
                                        <p className="text-muted-foreground">{sport.description}</p>
                                    </CardContent>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                    </div>
                </div>
            </section>

            <section className="bg-card">
                 <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                         <h2 className="font-headline text-3xl md:text-4xl font-bold mb-12">Competitions & School Events</h2>
                    </AnimateOnScroll>
                    <div className="grid md:grid-cols-2 gap-8">
                        {events.map((event, index) => (
                             <AnimateOnScroll key={event.title} delay={index * 200}>
                                <Card className="p-6 text-center bg-primary/5 h-full">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4 inline-block">
                                        <event.icon className="h-8 w-8" />
                                    </div>
                                    <h3 className="font-headline text-xl font-bold mb-2">{event.title}</h3>
                                    <p className="text-muted-foreground">{event.description}</p>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                    </div>
                     <div className="text-center mt-12">
                        <Button asChild variant="outline">
                            <Link href="/contact">See Upcoming Events</Link>
                        </Button>
                    </div>
                 </div>
            </section>

            <section className="bg-background">
                <div className="container mx-auto px-6 text-center">
                    <AnimateOnScroll>
                         <h2 className="font-headline text-3xl md:text-4xl font-bold">What Our Students Say</h2>
                    </AnimateOnScroll>
                    <AnimateOnScroll delay={200} className="mt-12 max-w-4xl mx-auto">
                        <Carousel 
                            opts={{ align: "start", loop: true }}
                            plugins={[Autoplay({ delay: 5000 })]}
                            className="w-full"
                        >
                            <CarouselContent>
                                {studentTestimonials.map((testimonial, index) => (
                                    <CarouselItem key={index}>
                                        <div className="p-4">
                                            <div className="flex flex-col items-center text-center">
                                                <Avatar className="w-20 h-20 mb-4">
                                                    <AvatarImage src={testimonial.avatarUrl} alt={testimonial.name} className="object-cover" />
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

            <section className="bg-card">
                 <div className="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl font-bold mb-4">Our Alumni</h2>
                        <p className="text-muted-foreground mb-6">
                            CMFI alumni are leaders in their communities, continuing to live by the values of excellence and discipline. We are proud of our graduates who make a positive impact across various fields.
                        </p>
                        <Button asChild className="bg-accent hover:bg-accent/90">
                            <Link href="#" target="_blank">Join the Alumni Network</Link>
                        </Button>
                    </AnimateOnScroll>
                    <AnimateOnScroll delay={200}>
                        <div className="relative aspect-video rounded-lg overflow-hidden">
                            <Image src="https://picsum.photos/seed/alumni-life/800/600" fill sizes="(max-width: 768px) 100vw, 50vw" className="object-cover" alt="Alumni group photo" data-ai-hint="graduates group photo" />
                        </div>
                    </AnimateOnScroll>
                </div>
            </section>

            <section className="bg-background overflow-x-hidden">
                <div className="container mx-auto px-6 text-center">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">Show Your School Spirit</h2>
                        <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                            Official CMFI merchandise is available in various colors. Contact the administration office for details on how to get yours.
                        </p>
                    </AnimateOnScroll>
                     <div className="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-8">
                        {merchandiseByColor[0].items.map((item, index) => (
                            <Card key={`${item.name}-${index}`} className="overflow-hidden group">
                                <div className="relative aspect-square">
                                    <AnimatePresence initial={false}>
                                        <motion.div
                                            key={currentColorIndex}
                                            initial={{ opacity: 0, x: 100 }}
                                            animate={{ opacity: 1, x: 0 }}
                                            exit={{ opacity: 0, x: -100 }}
                                            transition={{ duration: 0.5, ease: 'easeInOut' }}
                                            className="absolute inset-0"
                                        >
                                            <Image 
                                                src={merchandiseByColor[currentColorIndex].items[index].imageUrl} 
                                                alt={merchandiseByColor[currentColorIndex].items[index].name} 
                                                data-ai-hint={merchandiseByColor[currentColorIndex].items[index].hint}
                                                fill 
                                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 33vw, 25vw" 
                                                className="object-cover group-hover:scale-105 transition-transform" 
                                            />
                                        </motion.div>
                                    </AnimatePresence>
                                </div>
                                <CardHeader>
                                    <CardTitle className="font-headline text-lg text-center">{item.name}</CardTitle>
                                </CardHeader>
                            </Card>
                        ))}
                    </div>
                     <div className="text-center mt-12">
                        <Button asChild size="lg">
                            <Link href="/contact">Contact Office for Merch</Link>
                        </Button>
                    </div>
                </div>
            </section>

            <section className="bg-card">
                <div className="container mx-auto px-6 text-center">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">Together Beyond the Classroom</h2>
                        <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                            We believe that a strong community is the foundation of a great school. CMFI actively involves parents, alumni, and the local community in our mission to foster well-rounded individuals.
                        </p>
                    </AnimateOnScroll>
                    <div className="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                        {community.map((item, index) => (
                            <AnimateOnScroll key={item.title} delay={index * 150}>
                                <Card className="p-6 hover:shadow-lg transition-shadow group">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4 inline-block group-hover:animate-bounce">
                                        <item.icon className="h-8 w-8" />
                                    </div>
                                    <h3 className="font-headline text-xl font-bold">{item.title}</h3>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                    </div>
                </div>
            </section>

            <section className="relative bg-primary text-primary-foreground">
                 <Image 
                    src="https://picsum.photos/seed/cta-student-life/1920/1080"
                    fill
                    sizes="100vw"
                    className="object-cover opacity-20"
                    alt="Students cheering"
                    data-ai-hint="students cheering"
                />
                <div className="absolute inset-0 bg-primary/80" />
                <div className="container mx-auto px-6 text-center relative z-10">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">
                           Life at CMFI is about more than school — it’s about building lasting memories.
                        </h2>
                        <div className="mt-8 flex justify-center">
                            <Button asChild size="lg" variant="secondary">
                                <Link href="/admissions">Apply to CMFI</Link>
                            </Button>
                        </div>
                    </AnimateOnScroll>
                </div>
            </section>
        </>
    );
};

export default StudentLifePage;
