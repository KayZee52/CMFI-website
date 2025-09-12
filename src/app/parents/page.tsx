import { AnimateOnScroll } from "@/components/animate-on-scroll";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { testimonials } from "@/lib/data";
import { MessageCircle, Handshake, Users } from "lucide-react";
import Image from "next/image";
import Link from "next/link";

const ParentsPage = () => {

    const resources = [
        { icon: MessageCircle, title: 'Communication Channels', description: 'Stay connected through our official parent communication app and regular newsletters.' },
        { icon: Handshake, title: 'Involvement Opportunities', description: 'Participate in parent-teacher meetings, school events, and volunteer programs.' },
        { icon: Users, title: 'Parent Guidelines', description: 'Access our handbook for information on school policies, schedules, and student support.' },
    ];

    return (
        <section className="bg-background">
            <div className="container mx-auto px-6 py-16">
                <AnimateOnScroll className="text-center">
                    <h1 className="font-headline text-4xl md:text-5xl font-bold">For Our Parents</h1>
                    <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                        Partnering with you to ensure your child's success and well-being.
                    </p>
                </AnimateOnScroll>

                <div className="mt-16 grid md:grid-cols-2 gap-12 items-center">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl font-bold mb-4">A Welcome to Our Parent Community</h2>
                        <p className="text-muted-foreground mb-6">
                            We recognize that education is a partnership between the school and the home. At CMFI, we are committed to fostering a strong, collaborative relationship with our parents. Your involvement is crucial, and we provide numerous resources and channels to keep you informed and engaged in your child’s educational journey.
                        </p>
                        <Button asChild size="lg" className="bg-accent hover:bg-accent/90">
                            <Link href="#">Access Portal</Link>
                        </Button>
                    </AnimateOnScroll>
                    <AnimateOnScroll delay={200}>
                         <div className="relative aspect-video rounded-lg overflow-hidden">
                            <Image src="https://picsum.photos/seed/parents/800/600" layout="fill" objectFit="cover" alt="Parents and students" data-ai-hint="family happy" />
                        </div>
                    </AnimateOnScroll>
                </div>

                <AnimateOnScroll delay={300} className="mt-24">
                     <h2 className="font-headline text-3xl md:text-4xl font-bold text-center mb-12">Parent Resources</h2>
                    <div className="grid md:grid-cols-3 gap-8">
                        {resources.map((resource, index) => (
                            <Card key={index} className="text-center hover:shadow-lg transition-shadow p-6">
                                <div className="p-4 bg-primary/10 text-primary rounded-full mb-4 inline-block">
                                    <resource.icon className="h-8 w-8" />
                                </div>
                                <h3 className="font-headline text-xl font-bold mb-2">{resource.title}</h3>
                                <p className="text-muted-foreground">{resource.description}</p>
                            </Card>
                        ))}
                    </div>
                </AnimateOnScroll>

                <AnimateOnScroll delay={400} className="mt-24">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold text-center mb-12">What Parents Say</h2>
                    <div className="grid lg:grid-cols-3 gap-8">
                        {testimonials.filter(t => t.role === 'Parent').map((testimonial) => (
                             <Card key={testimonial.name} className="flex flex-col justify-center items-center text-center p-6">
                                 <CardContent className="pt-6">
                                    <p className="text-muted-foreground mb-4">"{testimonial.quote}"</p>
                                    <p className="font-bold font-headline">{testimonial.name}</p>
                                    <p className="text-sm text-muted-foreground">{testimonial.role}</p>
                                 </CardContent>
                            </Card>
                        ))}
                    </div>
                </AnimateOnScroll>

            </div>
        </section>
    );
}

export default ParentsPage;
