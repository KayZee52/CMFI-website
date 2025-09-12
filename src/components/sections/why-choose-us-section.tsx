import { AnimateOnScroll } from '../animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { Globe, GraduationCap, Users, Laptop } from 'lucide-react';

const WhyChooseUsSection = () => {
    const features = [
        {
            icon: Globe,
            title: 'Bilingual Advantage',
            description: 'Our English and French curriculum opens a world of opportunities, fostering global communication skills.'
        },
        {
            icon: Laptop,
            title: 'Modern Learning',
            description: 'We integrate ICT into our teaching, equipping students with essential digital literacy for the modern world.'
        },
        {
            icon: GraduationCap,
            title: 'Strong Academics',
            description: 'With a focus on WAEC/WASSCE excellence, our students consistently achieve outstanding results.'
        },
        {
            icon: Users,
            title: 'Community Spirit',
            description: 'We believe in a strong partnership between parents, teachers, and students to create a supportive learning environment.'
        }
    ];

    return (
        <section className="bg-card">
            <div className="container mx-auto px-6">
                <AnimateOnScroll className="text-center">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">What Makes Us Different?</h2>
                    <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                        Discover the unique advantages of a CMFI education.
                    </p>
                </AnimateOnScroll>
                <div className="mt-16 grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    {features.map((feature, index) => (
                        <AnimateOnScroll key={index} delay={index * 100}>
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
