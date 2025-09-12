import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import { Languages, SquareRoot, FlaskConical, Globe, Palette, Presentation, PersonStanding } from 'lucide-react';
import Image from 'next/image';

const AcademicsPage = () => {

    const departments = [
        { name: 'Languages', icon: Languages },
        { name: 'Mathematics', icon: SquareRoot },
        { name: 'Sciences', icon: FlaskConical },
        { name: 'ICT', icon: Presentation },
        { name: 'Business', icon: Globe },
        { name: 'Arts', icon: Palette },
        { name: 'Physical Education', icon: PersonStanding },
    ];

    return (
        <section className="bg-background">
            <div className="container mx-auto px-6 py-16">
                <AnimateOnScroll className="text-center">
                    <h1 className="font-headline text-4xl md:text-5xl font-bold">Academics</h1>
                    <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                        Fostering intellectual curiosity through a rich and rigorous bilingual curriculum.
                    </p>
                </AnimateOnScroll>

                <div className="mt-16 grid md:grid-cols-2 gap-12 items-center">
                    <AnimateOnScroll>
                         <div className="relative aspect-video rounded-lg overflow-hidden">
                            <Image src="https://picsum.photos/seed/academics-bilingual/800/600" layout="fill" objectFit="cover" alt="Bilingual education" data-ai-hint="books library"/>
                        </div>
                    </AnimateOnScroll>
                     <AnimateOnScroll delay={200}>
                        <h2 className="font-headline text-3xl font-bold mb-4">Our Bilingual Approach</h2>
                        <p className="text-muted-foreground">
                            At CMFI, we immerse our students in a bilingual environment, providing instruction in both English and French. This approach not only enhances cognitive abilities but also opens up a world of opportunities, preparing students to thrive in a globalized society.
                        </p>
                    </AnimateOnScroll>
                </div>

                <AnimateOnScroll delay={300} className="mt-24">
                     <h2 className="font-headline text-3xl md:text-4xl font-bold text-center mb-12">Academic Departments</h2>
                     <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {departments.map((dept) => (
                            <Card key={dept.name} className="flex flex-col items-center justify-center p-6 text-center hover:shadow-lg transition-shadow">
                                <dept.icon className="h-10 w-10 text-primary mb-3" />
                                <h3 className="font-headline text-lg font-semibold">{dept.name}</h3>
                            </Card>
                        ))}
                     </div>
                </AnimateOnScroll>
                
                <div className="mt-24 grid md:grid-cols-2 gap-12 items-start">
                    <AnimateOnScroll delay={400}>
                        <h2 className="font-headline text-3xl font-bold mb-6">Policies & Calendar</h2>
                        <Accordion type="single" collapsible className="w-full">
                          <AccordionItem value="item-1">
                            <AccordionTrigger>Academic Calendar</AccordionTrigger>
                            <AccordionContent>
                              Our academic year is divided into two semesters, with detailed schedules available at the school office.
                            </AccordionContent>
                          </AccordionItem>
                          <AccordionItem value="item-2">
                            <AccordionTrigger>Discipline & Attendance</AccordionTrigger>
                            <AccordionContent>
                              We uphold a strict policy on discipline and require regular attendance to ensure a conducive learning environment for all.
                            </AccordionContent>
                          </AccordionItem>
                          <AccordionItem value="item-3">
                            <AccordionTrigger>Assessments</AccordionTrigger>
                            <AccordionContent>
                              Continuous assessment and terminal examinations are key components of our evaluation system to track student progress.
                            </AccordionContent>
                          </AccordionItem>
                        </Accordion>
                    </AnimateOnScroll>
                    <AnimateOnScroll delay={500}>
                         <Card className="bg-primary/10 border-primary/30">
                            <CardHeader>
                                <CardTitle className="font-headline text-2xl text-primary flex items-center gap-3">
                                    <Award className="h-8 w-8" />
                                    <span>WAEC/WASSCE Excellence</span>
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <p className="text-muted-foreground">
                                    We provide specialized preparation for the WAEC/WASSCE examinations, including mock tests, intensive revision classes, and access to a wealth of ICT resources. Our goal is to equip every student to achieve outstanding results.
                                </p>
                            </CardContent>
                        </Card>
                    </AnimateOnScroll>
                </div>
            </div>
        </section>
    );
};

export default AcademicsPage;
