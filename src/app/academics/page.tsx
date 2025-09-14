import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import { Languages, Calculator, FlaskConical, Globe, Book, Users, Laptop, Check, Calendar, Download, Trophy } from 'lucide-react';
import Image from 'next/image';
import { Button } from '@/components/ui/button';
import Link from 'next/link';

const AcademicsPage = () => {

    const departments = [
        { name: 'Languages & Humanities', icon: Book, description: 'English, French, History, Literature.' },
        { name: 'Science & Mathematics', icon: FlaskConical, description: 'Physics, Chemistry, Biology, Mathematics.' },
        { name: 'ICT & Digital Learning', icon: Laptop, description: 'ICT, Computer Literacy, Coding basics.' },
        { name: 'Social & Moral Education', icon: Users, description: 'Civic Education, Discipline, Faith-based values.' },
    ];
    
    const facilities = [
        { icon: FlaskConical, title: 'Science Lab', description: 'Hands-on experiments and discovery.', imageUrl: 'https://picsum.photos/seed/science-lab/800/600', hint: 'science lab' },
        { icon: Laptop, title: 'ICT Lab', description: 'Equipping students with 21st-century digital skills.', imageUrl: 'https://picsum.photos/seed/ict-lab/800/600', hint: 'computer lab' },
    ];
    
    const policies = [
        { icon: Check, title: 'Discipline', description: 'Respectful, responsible behavior is expected from all students to maintain a conducive learning atmosphere.' },
        { icon: Calendar, title: 'Attendance', description: 'Students must attend at least 80% of classes to be eligible for terminal examinations.' },
        { icon: Trophy, title: 'Excellence', description: 'We encourage and celebrate high achievement in all academic and co-curricular activities.' },
    ];

    return (
        <>
            <section className="relative h-[400px] flex items-center justify-center text-center text-white">
                <Image
                    src="https://picsum.photos/seed/academics-hero/1920/1080"
                    alt="Students in a classroom"
                    fill
                    priority
                    sizes="100vw"
                    className="object-cover object-center"
                    data-ai-hint="students classroom"
                />
                <div className="absolute inset-0 bg-black/60" />
                <div className="relative z-10 container mx-auto px-6">
                    <AnimateOnScroll>
                        <h1 className="font-headline text-4xl md:text-6xl font-bold tracking-tight">
                            Academics at CMFI
                        </h1>
                        <p className="mt-4 text-lg md:text-xl text-white/90">
                           Shaping bright futures through excellence, discipline, and innovation.
                        </p>
                         <Button asChild size="lg" className="mt-8 bg-accent hover:bg-accent/90 text-accent-foreground">
                            <Link href="#departments">View Academic Departments</Link>
                        </Button>
                    </AnimateOnScroll>
                </div>
            </section>
        
            <section className="bg-card">
                 <div className="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
                     <AnimateOnScroll>
                        <h2 className="font-headline text-3xl font-bold mb-4">Our Academic Approach</h2>
                        <p className="text-muted-foreground text-lg">
                            At CMFI Bilingual High School, we provide holistic and bilingual education that blends intellectual growth, moral values, and practical skills. Our curriculum emphasizes discipline, critical thinking, and modern learning tools to prepare students for a successful future.
                        </p>
                    </AnimateOnScroll>
                    <AnimateOnScroll delay={200}>
                         <div className="relative aspect-video rounded-lg overflow-hidden">
                            <Image src="https://picsum.photos/seed/academics-bilingual/800/600" fill sizes="(max-width: 768px) 100vw, 50vw" className="object-cover" alt="Bilingual education" data-ai-hint="books library"/>
                        </div>
                    </AnimateOnScroll>
                </div>
            </section>

            <section id="departments" className="bg-background">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                         <h2 className="font-headline text-3xl md:text-4xl font-bold">Departments</h2>
                    </AnimateOnScroll>
                     <div className="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        {departments.map((dept, index) => (
                             <AnimateOnScroll key={dept.name} delay={index * 100}>
                                <Card className="flex flex-col items-center p-6 text-center hover:shadow-lg transition-shadow h-full">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                                        <dept.icon className="h-10 w-10" />
                                    </div>
                                    <h3 className="font-headline text-xl font-semibold mb-2">{dept.name}</h3>
                                    <p className="text-muted-foreground">{dept.description}</p>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                     </div>
                </div>
            </section>

            <section className="bg-card">
                 <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                         <h2 className="font-headline text-3xl md:text-4xl font-bold mb-12">Learning Facilities</h2>
                    </AnimateOnScroll>
                    <div className="grid md:grid-cols-2 gap-12 items-center">
                        {facilities.map((facility, index) => (
                            <AnimateOnScroll key={facility.title} delay={index * 200}>
                                <div className="relative aspect-video rounded-lg overflow-hidden mb-4">
                                    <Image src={facility.imageUrl} fill sizes="(max-width: 768px) 100vw, 50vw" className="object-cover" alt={facility.title} data-ai-hint={facility.hint} />
                                </div>
                                <h3 className="font-headline text-2xl font-bold flex items-center gap-3 mb-2"><facility.icon className="h-6 w-6 text-primary"/>{facility.title}</h3>
                                <p className="text-muted-foreground">{facility.description}</p>
                            </AnimateOnScroll>
                        ))}
                    </div>
                 </div>
            </section>
            
            <section className="bg-background">
                <div className="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-start">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl font-bold mb-6">Academic Calendar</h2>
                        <Accordion type="single" collapsible className="w-full" defaultValue="item-1">
                          <AccordionItem value="item-1">
                            <AccordionTrigger>First Term: September – December</AccordionTrigger>
                            <AccordionContent>
                              The academic year kicks off with foundational topics, mid-term assessments, and co-curricular activities.
                            </AccordionContent>
                          </AccordionItem>
                          <AccordionItem value="item-2">
                            <AccordionTrigger>Second Term: January – March</AccordionTrigger>
                            <AccordionContent>
                              Focus on syllabus advancement, practical labs, and preparation for mid-year mock examinations.
                            </AccordionContent>
                          </AccordionItem>
                          <AccordionItem value="item-3">
                            <AccordionTrigger>Third Term: April – July</AccordionTrigger>
                            <AccordionContent>
                              Intensive revision, final examinations, and end-of-year ceremonies including graduation.
                            </AccordionContent>
                          </AccordionItem>
                        </Accordion>
                        <Button className="mt-6" variant="outline">
                            <Download className="mr-2 h-5 w-5" />
                            Download Full Calendar (PDF)
                        </Button>
                    </AnimateOnScroll>
                    <AnimateOnScroll delay={200}>
                        <h2 className="font-headline text-3xl font-bold mb-6">Policies for Academic Excellence</h2>
                        <div className="space-y-6">
                            {policies.map((policy, index) => (
                                <Card key={index} className="bg-primary/5">
                                    <CardHeader className="flex flex-row items-center gap-4">
                                        <div className="p-3 bg-primary/10 rounded-full">
                                            <policy.icon className="h-6 w-6 text-primary"/>
                                        </div>
                                        <div>
                                            <CardTitle className="font-headline text-xl">{policy.title}</CardTitle>
                                            <p className="text-muted-foreground">{policy.description}</p>
                                        </div>
                                    </CardHeader>
                                </Card>
                            ))}
                        </div>
                    </AnimateOnScroll>
                </div>
            </section>
            
             <section className="relative bg-primary text-primary-foreground">
                 <Image 
                    src="https://picsum.photos/seed/cta-academics/1920/1080"
                    fill
                    sizes="100vw"
                    className="object-cover opacity-20"
                    alt="Students collaborating"
                    data-ai-hint="students collaborating"
                />
                <div className="absolute inset-0 bg-primary/80" />
                <div className="container mx-auto px-6 text-center relative z-10">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">
                            Education is the key to success. At CMFI, we build the leaders of tomorrow.
                        </h2>
                        <div className="mt-8 flex justify-center gap-4">
                            <Button asChild size="lg" variant="secondary">
                                <Link href="/student-life">Explore Student Life</Link>
                            </Button>
                        </div>
                    </AnimateOnScroll>
                </div>
            </section>
        </>
    );
};

export default AcademicsPage;
