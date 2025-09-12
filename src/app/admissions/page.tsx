import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { FileText, Award, UserCheck } from 'lucide-react';
import Image from 'next/image';
import Link from 'next/link';

const AdmissionsPage = () => {
    const admissionSteps = [
        {
            icon: FileText,
            title: 'Submit Application',
            description: 'Complete the application form available at our school office.'
        },
        {
            icon: Award,
            title: 'Entrance Examination',
            description: 'Sit for the mandatory entrance exam covering core subjects.'
        },
        {
            icon: UserCheck,
            title: 'Interview & Review',
            description: 'Attend an interview with our admissions team for final review.'
        }
    ];

    return (
        <section className="bg-background">
            <div className="container mx-auto px-6 py-16">
                <AnimateOnScroll className="text-center">
                    <h1 className="font-headline text-4xl md:text-5xl font-bold">Admissions</h1>
                    <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                        Join our community of future leaders. Discover our simple and transparent admission process.
                    </p>
                </AnimateOnScroll>
                
                <AnimateOnScroll delay={200} className="mt-16">
                     <div className="relative aspect-video rounded-lg overflow-hidden">
                        <Image src="https://picsum.photos/seed/admissions-video/1280/720" layout="fill" objectFit="cover" alt="Admissions video placeholder" data-ai-hint="classroom students" />
                         <div className="absolute inset-0 bg-black/50 flex items-center justify-center">
                            <Button size="lg" variant="outline" className="text-white border-white hover:bg-white hover:text-primary">Watch Video Intro</Button>
                        </div>
                    </div>
                </AnimateOnScroll>

                <AnimateOnScroll delay={300} className="mt-24">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold text-center mb-12">Our Admission Process</h2>
                    <div className="grid md:grid-cols-3 gap-8">
                        {admissionSteps.map((step, index) => (
                            <Card key={index} className="text-center hover:shadow-lg transition-shadow">
                                <CardHeader className="items-center">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                                        <step.icon className="h-8 w-8" />
                                    </div>
                                    <CardTitle className="font-headline text-xl">{step.title}</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-muted-foreground">{step.description}</p>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                </AnimateOnScroll>
                
                <AnimateOnScroll delay={400} className="mt-24 text-center">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold mb-4">Requirements & Fees</h2>
                    <p className="text-muted-foreground text-lg max-w-3xl mx-auto">
                        For detailed information on admission requirements, documents needed, and our fee structure, please visit our school's administration office. Our team is ready to assist you.
                    </p>
                     <Button asChild size="lg" className="mt-8 bg-accent hover:bg-accent/90">
                        <Link href="/contact">Join CMFI Today</Link>
                    </Button>
                </AnimateOnScroll>

            </div>
        </section>
    );
};

export default AdmissionsPage;
