
import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { FileText, Award, UserCheck, ScrollText, BadgeCheck, CalendarDays, FileSignature, BookCopy, Star, FileUp } from 'lucide-react';
import Image from 'next/image';
import Link from 'next/link';
import { Typewriter } from '@/components/typewriter';
import { cn } from '@/lib/utils';

const AdmissionsPage = () => {
    const admissionSteps = [
        {
            icon: Award,
            title: 'Entrance Examination',
            description: 'Applicants must first sit for the mandatory entrance exam covering core subjects to assess their academic readiness.',
        },
        {
            icon: ScrollText,
            title: 'Pick Up Form',
            description: 'After successfully passing the exam, admission forms are available at the school office during working hours.',
        },
        {
            icon: FileText,
            title: 'Submit Application',
            description: 'Complete and return the form with all required documents, including previous academic records and a birth certificate.',
        },
        {
            icon: UserCheck,
            title: 'Interview & Review',
            description: 'A friendly interview with our admissions team allows us to get to know the applicant and review their potential.',
        },
        {
            icon: BadgeCheck,
            title: 'Receive Confirmation',
            description: 'Successful applicants will receive an official admission letter and package with further instructions to complete enrollment.',
        }
    ];

    const requirements = [
        { icon: FileSignature, title: 'Completed Form', mandatory: true },
        { icon: ScrollText, title: 'Birth Certificate', mandatory: true },
        { icon: BookCopy, title: 'Previous Report Cards', mandatory: true },
        { icon: FileText, title: 'Transcript', mandatory: true },
        { icon: Star, title: 'Recommendation Letter', mandatory: true },
    ];
    
    const timeline = [
        { date: 'June 1st - July 31st', event: 'Application Period' },
        { date: 'August 5th', event: 'Entrance Exam' },
        { date: 'August 15th', event: 'Admission Decisions Released' },
        { date: 'August 25th', event: 'Enrollment Deadline' },
    ];
    
    const typewriterPhrases = [
        "Journey with Us Today.",
        "Learning with Us Today.",
        "Dreams with Us Today.",
        "Future with Us Today.",
        "Success with Us Today.",
    ];

    return (
        <>
            <section className="relative h-[400px] flex items-center justify-center text-center text-white">
                <Image
                    src="/images/heroimages/admissionhero.jpeg"
                    alt="Admissions at CMFI"
                    fill
                    priority
                    sizes="100vw"
                    className="object-cover"
                    data-ai-hint="students smiling"
                />
                <div className="absolute inset-0 bg-black/60" />
                <div className="relative z-10 container mx-auto px-6">
                    <AnimateOnScroll>
                        <h1 className="font-headline text-4xl md:text-6xl font-bold tracking-tight">
                            Admissions at CMFI
                        </h1>
                        <p className="mt-4 text-lg md:text-xl text-white/90 min-h-[56px] md:min-h-0">
                            Start your <Typewriter phrases={typewriterPhrases} />
                        </p>
                        <div className="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                            <Button asChild size="lg" variant="default" className="text-white border-white hover:bg-white hover:text-primary">
                                <Link href="#how-to-apply">How to Apply (In-Person)</Link>
                            </Button>
                        </div>
                    </AnimateOnScroll>
                </div>
            </section>

            <section id="how-to-apply" className="bg-background">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">How to Apply (In-Person)</h2>
                        <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                            Our in-person admission process is simple and transparent. Follow these steps to join our community.
                        </p>
                    </AnimateOnScroll>

                     <div className="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                        {admissionSteps.map((step, index) => (
                            <AnimateOnScroll key={index} delay={index * 100}>
                                <Card className="text-center h-full hover:shadow-xl transition-shadow p-6 bg-primary/5 border-primary/10">
                                    <CardHeader className="items-center">
                                        <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                                            <step.icon className="h-10 w-10" />
                                        </div>
                                        <CardTitle className="font-headline text-lg">Step {index + 1}: {step.title}</CardTitle>
                                    </CardHeader>
                                    <CardContent>
                                        <p className="text-muted-foreground text-sm">{step.description}</p>
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
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">What You'll Need</h2>
                    </AnimateOnScroll>
                    <div className="mt-16 grid grid-cols-2 lg:grid-cols-5 gap-8">
                        {requirements.map((req, index) => (
                            <AnimateOnScroll key={index} delay={index * 100}>
                                <Card className="text-center h-full hover:shadow-lg transition-shadow p-6">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4 inline-block">
                                        <req.icon className="h-8 w-8" />
                                    </div>
                                    <h3 className="font-headline text-lg font-semibold">{req.title}</h3>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                    </div>
                </div>
            </section>

             <section className="bg-background">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center mb-16">
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">Admissions Timeline</h2>
                        <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                            Stay on track with these important dates for the 2024/2025 admission cycle.
                        </p>
                    </AnimateOnScroll>
                     <div className="relative max-w-2xl mx-auto">
                        <div className="absolute left-1/2 -translate-x-1/2 md:left-5 h-full w-1 bg-border" />
                        {timeline.map((item, index) => (
                            <AnimateOnScroll key={index} delay={index * 150} className="mb-10 flex items-start gap-6">
                                <div className="relative z-10">
                                    <div className="h-10 w-10 rounded-full bg-background border-2 border-primary flex items-center justify-center">
                                        <CalendarDays className="h-5 w-5 text-primary" />
                                    </div>
                                </div>
                                <div className="pt-1.5">
                                    <p className="font-semibold text-muted-foreground">{item.date}</p>
                                    <h3 className="font-headline text-xl font-bold text-foreground">{item.event}</h3>
                                </div>
                            </AnimateOnScroll>
                        ))}
                    </div>
                </div>
            </section>
            
            <section className="bg-card">
                <div className="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
                    <AnimateOnScroll>
                        <Card className="bg-primary/10 border-primary/20 p-8">
                            <h3 className="font-headline text-2xl font-bold mb-4 flex items-center gap-3">
                                <Award className="h-8 w-8 text-primary" />
                                <span>Entrance Exams</span>
                            </h3>
                            <p className="text-muted-foreground">
                                Applicants are required to take an entrance exam as part of the admission process. This helps us place students at the right academic level and ensure they are prepared for our curriculum.
                            </p>
                        </Card>
                    </AnimateOnScroll>
                    <AnimateOnScroll delay={200}>
                         <Card className="bg-accent/10 border-accent/20 p-8 text-center">
                            <h3 className="font-headline text-2xl font-bold mb-4">School Fees</h3>
                            <p className="text-muted-foreground mb-6">
                                For detailed information on tuition and other fees, please visit our school's administration office.
                            </p>
                            <Button asChild className="bg-accent hover:bg-accent/90">
                                <Link href="/contact">Contact Office for Fees</Link>
                            </Button>
                        </Card>
                    </AnimateOnScroll>
                </div>
            </section>

             <section className="relative bg-primary text-primary-foreground">
                 <Image 
                    src="https://picsum.photos/seed/cta-admissions/1920/1080"
                    fill
                    sizes="100vw"
                    className="object-cover opacity-20"
                    alt="Students studying"
                    data-ai-hint="students studying"
                />
                <div className="absolute inset-0 bg-primary/80" />
                <div className="container mx-auto px-6 text-center relative z-10">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">
                            Ready to Begin Your Journey at CMFI?
                        </h2>
                        <div className="mt-8 flex flex-col sm:flex-row justify-center gap-4">
                            <Button asChild size="lg" variant="secondary" className="w-full sm:w-auto">
                                <Link href="/admissions">Apply Now</Link>
                            </Button>
                             <Button asChild size="lg" variant="outline" className="border-white text-white hover:bg-white hover:text-primary w-full sm:w-auto">
                                <Link href="/contact">Contact Us</Link>
                            </Button>
                        </div>
                    </AnimateOnScroll>
                </div>
            </section>
        </>
    );
};

export default AdmissionsPage;
