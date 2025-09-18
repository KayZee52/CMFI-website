'use client';

import { testimonials } from '@/lib/data';
import { Card, CardContent } from '../ui/card';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '../ui/carousel';
import { Avatar, AvatarFallback, AvatarImage } from '../ui/avatar';
import { AnimateOnScroll } from '../animate-on-scroll';
import Autoplay from "embla-carousel-autoplay"

const TestimonialsSection = () => {
    return (
        <section className="bg-primary text-primary-foreground">
            <div className="container mx-auto px-6">
                <AnimateOnScroll className="text-center">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">
                        Voices of Our Community
                    </h2>
                    <p className="mt-4 max-w-2xl mx-auto text-lg text-primary-foreground/80">
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
                        className="w-full max-w-3xl mx-auto"
                    >
                        <CarouselContent>
                            {testimonials.map((testimonial, index) => (
                                <CarouselItem key={index}>
                                    <div className="p-4">
                                        <Card className="bg-card/10 border-card/20 text-primary-foreground h-full min-h-[300px]">
                                            <CardContent className="pt-8 flex flex-col items-center justify-center text-center h-full">
                                                <Avatar className="w-20 h-20 mb-6 border-4 border-card/50">
                                                    <AvatarImage src={testimonial.avatarUrl} alt={testimonial.name} />
                                                    <AvatarFallback>{testimonial.name.charAt(0)}</AvatarFallback>
                                                </Avatar>
                                                <p className="text-lg text-primary-foreground/90 mb-6 max-w-md">"{testimonial.quote}"</p>
                                                <p className="font-bold font-headline text-accent">{testimonial.name}</p>
                                                <p className="text-sm text-primary-foreground/70">{testimonial.role}</p>
                                            </CardContent>
                                        </Card>
                                    </div>
                                </CarouselItem>
                            ))}
                        </CarouselContent>
                        <CarouselPrevious className="hidden md:flex left-[-50px] bg-card/20 border-card/30 hover:bg-card/30 text-primary-foreground" />
                        <CarouselNext className="hidden md:flex right-[-50px] bg-card/20 border-card/30 hover:bg-card/30 text-primary-foreground"/>
                    </Carousel>
                </AnimateOnScroll>
            </div>
        </section>
    );
};

export default TestimonialsSection;
