import { AnimateOnScroll } from '@/components/animate-on-scroll';
import GallerySection from '@/components/sections/gallery-section';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Medal, Trophy, BrainCircuit, GraduationCap } from 'lucide-react';
import Link from 'next/link';

const StudentLifePage = () => {
    
    const activities = [
        { icon: Trophy, title: 'Sports', items: ['Football', 'Kickball', 'Basketball'] },
        { icon: BrainCircuit, title: 'Activities', items: ['Quiz Competitions', 'Debate Club'] },
        { icon: GraduationCap, title: 'Events', items: ['Graduation Ceremony', 'Cultural Day', 'School Programs'] },
        { icon: Medal, title: 'Achievements', items: ['WAEC/WASSCE High Scores', 'Inter-School Competition Wins'] },
    ];
    
    return (
        <>
            <section className="bg-background">
                <div className="container mx-auto px-6 py-16">
                    <AnimateOnScroll className="text-center">
                        <h1 className="font-headline text-4xl md:text-5xl font-bold">Student & Alumni Life</h1>
                        <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                            A vibrant community of learners, leaders, and lifelong friends.
                        </p>
                    </AnimateOnScroll>
                    
                    <div className="mt-16 grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                        {activities.map((activity, index) => (
                            <AnimateOnScroll key={activity.title} delay={index * 100}>
                                <Card className="h-full hover:shadow-lg transition-shadow">
                                    <CardHeader className="items-center text-center">
                                        <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                                            <activity.icon className="h-8 w-8" />
                                        </div>
                                        <CardTitle className="font-headline text-xl">{activity.title}</CardTitle>
                                    </CardHeader>
                                    <CardContent>
                                        <ul className="list-disc list-inside text-muted-foreground text-center">
                                            {activity.items.map(item => <li key={item}>{item}</li>)}
                                        </ul>
                                    </CardContent>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                    </div>

                    <AnimateOnScroll delay={400} className="mt-24">
                        <Card className="bg-primary/10 text-center">
                            <CardContent className="p-8">
                                <h2 className="font-headline text-2xl font-bold mb-4">Alumni Connections</h2>
                                <p className="text-muted-foreground mb-6 max-w-2xl mx-auto">
                                    Our alumni are a vital part of our community. Connect with fellow graduates, share success stories, and stay involved with the future of CMFI.
                                </p>
                                <Button asChild className="bg-accent hover:bg-accent/90">
                                    <Link href="#" target="_blank">Join Alumni WhatsApp Group</Link>
                                </Button>
                            </CardContent>
                        </Card>
                    </AnimateOnScroll>
                </div>
            </section>
            <GallerySection />
        </>
    );
};

export default StudentLifePage;
