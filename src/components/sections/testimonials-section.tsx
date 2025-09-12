'use client';

import { testimonials } from '@/lib/data';
import { Card, CardContent } from '../ui/card';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '../ui/carousel';
import { Avatar, AvatarFallback, AvatarImage } from '../ui/avatar';
import { AnimateOnScroll } from '../animate-on-scroll';
import Autoplay from "embla-carousel-autoplay"

const TestimonialsSection = () => {
    return (
        <section className="bg-card">
            <div className="container mx-auto px-6">
                <AnimateOnScroll className="text-center">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">
                        From Our Community
                    </h2>
                    <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                        Hear what students, parents, and alumni have to say about their experience at CMFI.
                    </p>
                </AnimateOnScroll>
                
                <AnimateOnScroll delay={200} className="mt-16">
                    <Carousel 
                        opts={{ align: "start", loop: true }}
                        plugins={[
                            Autoplay({
                              delay: 5000,
                            }),
                        ]}
                        className="w-full"
                    >
                        <CarouselContent>
                            {testimonials.map((testimonial, index) => (
                                <CarouselItem key={index} className="md:basis-1/2 lg:basis-1/3">
                                    <div className="p-4">
                                        <Card className="h-full">
                                            <CardContent className="pt-6 flex flex-col items-center text-center">
                                                <Avatar className="w-16 h-16 mb-4">
                                                    <AvatarImage src={`https://picsum.photos/seed/avatar${index}/100`} alt={testimonial.name} />
                                                    <AvatarFallback>{testimonial.name.charAt(0)}</AvatarFallback>
                                                </Avatar>
                                                <p className="text-muted-foreground mb-4">"{testimonial.quote}"</p>
                                                <p className="font-bold font-headline">{testimonial.name}</p>
                                                <p className="text-sm text-muted-foreground">{testimonial.role}</p>
                                            </CardContent>
                                        </Card>
                                    </div>
                                </CarouselItem>
                            ))}
                        </CarouselContent>
                        <CarouselPrevious className="hidden md:flex" />
                        <CarouselNext className="hidden md:flex"/>
                    </Carousel>
                </AnimateOnScroll>
            </div>
        </section>
    );
};

export default TestimonialsSection;
