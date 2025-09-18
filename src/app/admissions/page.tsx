
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
            icon: ScrollText,
            title: 'Pick Up Form',
            description: 'Admission forms are available at the school office during working hours. Get yours to begin the journey.',
            imageUrl: 'https://picsum.photos/seed/pickup-form/800/600',
            imageHint: 'school office reception'
        },
        {
            icon: FileText,
            title: 'Submit Application',
            description: 'Complete and return the form with all required documents, including previous academic records, a birth certificate, and transcripts if available.',
            imageUrl: 'https://picsum.photos/seed/submit-app/800/600',
            imageHint: 'person filling form'
        },
        {
            icon: Award,
            title: 'Entrance Examination',
            description: 'Applicants must sit for the mandatory entrance exam covering core subjects to assess their academic readiness.',
            imageUrl: 'https://picsum.photos/seed/entrance-exam/800/600',
            imageHint: 'students writing exam'
        },
        {
            icon: UserCheck,
            title: 'Interview & Review',
            description: 'A friendly interview with our admissions team allows us to get to know the applicant and review their potential.',
            imageUrl: 'https://picsum.photos/seed/interview-review/800/600',
            imageHint: 'friendly interview'
        },
        {
            icon: BadgeCheck,
            title: 'Receive Confirmation',
            description: 'Successful applicants will receive an official admission letter and package with further instructions to complete enrollment.',
            imageUrl: 'https://picsum.photos/seed/confirmation/800/600',
            imageHint: 'happy student acceptance'
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

                     <div className="relative mt-24 space-y-24">
                        <div className="absolute left-1/2 top-0 bottom-0 w-1 bg-border -translate-x-1/2 hidden md:block" />
                        
                        {admissionSteps.map((step, index) => (
                            <AnimateOnScroll 
                                key={index} 
                                className={cn('relative flex flex-col md:grid md:grid-cols-2 md:items-center md:gap-12 w-full')}
                                delay={index * 100}
                            >
                                <div className="md:order-1 md:text-left text-center">
                                    <h3 className="font-headline text-2xl font-semibold mb-4 text-primary">Step {index + 1}: {step.title}</h3>
                                    <p className="text-muted-foreground max-w-md mx-auto md:mx-0">{step.description}</p>
                                </div>

                                <div className="absolute left-1/2 -translate-x-1/2 -translate-y-1/2 top-1/2 h-10 w-10 p-1 rounded-full bg-background flex items-center justify-center z-10 border-2 border-primary">
                                    <step.icon className="h-6 w-6 text-primary" />
                                </div>
                                
                                <div className="md:order-2 mt-8 md:mt-0">
                                    <div className="relative aspect-video w-full max-w-md mx-auto rounded-lg overflow-hidden shadow-lg">
                                        <Image
                                        src={step.imageUrl}
                                        alt={step.title}
                                        data-ai-hint={step.imageHint}
                                        fill
                                        sizes="(max-width: 768px) 100vw, 50vw"
                                        className="object-cover"
                                        />
                                    </div>
                                </div>
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
