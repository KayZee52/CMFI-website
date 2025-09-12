import Link from 'next/link';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { Languages, Calculator, FlaskConical, Globe, Palette, Presentation, PersonStanding } from 'lucide-react';
import { Button } from '../ui/button';
import { ArrowRight } from 'lucide-react';

const departments = [
    { name: 'Languages', icon: Languages },
    { name: 'Mathematics', icon: Calculator },
    { name: 'Sciences', icon: FlaskConical },
    { name: 'ICT', icon: Presentation },
    { name: 'Business', icon: Globe },
    { name: 'Arts', icon: Palette },
];

const AcademicsPreview = () => {
    return (
        <section className="bg-background">
            <div className="container mx-auto px-6">
                <AnimateOnScroll className="text-center max-w-3xl mx-auto">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">A World-Class Curriculum</h2>
                    <p className="mt-4 text-lg text-muted-foreground">
                        Our rigorous bilingual curriculum is designed to foster intellectual curiosity and prepare students for global opportunities.
                    </p>
                </AnimateOnScroll>

                <div className="mt-16 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    {departments.map((dept, index) => (
                        <AnimateOnScroll key={dept.name} delay={index * 100}>
                            <Card className="flex flex-col items-center justify-center p-6 text-center hover:shadow-lg transition-shadow h-full">
                                <dept.icon className="h-10 w-10 text-primary mb-3" />
                                <h3 className="font-headline text-base font-semibold">{dept.name}</h3>
                            </Card>
                        </AnimateOnScroll>
                    ))}
                </div>

                <AnimateOnScroll className="text-center mt-12">
                    <Button asChild size="lg" variant="outline">
                        <Link href="/academics">
                            Explore Academics <ArrowRight className="ml-2 h-5 w-5" />
                        </Link>
                    </Button>
                </AnimateOnScroll>
            </div>
        </section>
    );
}

export default AcademicsPreview;
