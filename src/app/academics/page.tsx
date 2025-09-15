
'use client';

import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import { Baby, BookOpen, GraduationCap, Users, Dna, School, BrainCircuit, FlaskConical, Languages, Calculator, Globe, Paintbrush, Medal, Lightbulb, Users2, Building } from 'lucide-react';
import Image from 'next/image';
import { Button } from '@/components/ui/button';
import Link from 'next/link';
import { Typewriter } from '@/components/typewriter';

const AcademicsPage = () => {

    const typewriterPhrases = [
        "Building Minds.",
        "Shaping Futures.",
        "Inspiring Excellence.",
    ];

    const academicDivisions = [
        { icon: Baby, title: 'Nursery & Early Childhood', description: 'A nurturing start where curiosity and social skills blossom. Our play-based, bilingual environment fosters a love for learning from day one.' },
        { icon: School, title: 'Elementary School', description: 'Building the pillars of knowledge. Students develop core skills in literacy, numeracy, and science, all guided by our commitment to strong moral values.' },
        { icon: Building, title: 'Junior High (Grades 7-9)', description: 'Bridging foundational learning with advanced academics. Students deepen their knowledge with a focus on ICT, critical thinking, and preparation for national examinations.' },
        { icon: GraduationCap, title: 'Senior High (Grades 10-12)', description: 'A rigorous college preparatory program designed to cultivate expertise. Students specialize in sciences or humanities, developing the leadership skills needed to excel in university and beyond.' },
    ];
    
    const departments = [
        { name: 'Sciences', icon: FlaskConical, subjects: 'Biology, Chemistry, Physics, ICT' },
        { name: 'Mathematics', icon: Calculator, subjects: 'General Math, Advanced Math' },
        { name: 'Languages', icon: Languages, subjects: 'English, French, Literature' },
        { name: 'Social Sciences', icon: Globe, subjects: 'History, Geography, Civic Education' },
        { name: 'Arts & Creativity', icon: Paintbrush, subjects: 'Music, Visual Arts, Drama' },
        { name: 'Physical Education', icon: Medal, subjects: 'Football, Basketball, Athletics' },
    ];
    
    const faculty = [
        { name: 'Mr. Simeon E. Ojong', role: 'Principal', imageUrl: '/images/adminstrators/principal.jpeg', hint: 'principal portrait' },
        { name: 'Mrs. Jane Doe', role: 'Head of Sciences', imageUrl: 'https://picsum.photos/seed/faculty1/400/400', hint: 'teacher portrait' },
        { name: 'Mr. John Smith', role: 'Head of Languages', imageUrl: 'https://picsum.photos/seed/faculty2/400/400', hint: 'teacher portrait' },
        { name: 'Ms. Fatu Kamara', role: 'ICT Coordinator', imageUrl: 'https://picsum.photos/seed/faculty3/400/400', hint: 'teacher portrait' },
    ];

    const specialFeatures = [
        { icon: Dna, title: 'ICT & Science Labs', description: 'Our modern labs provide advanced, hands-on learning experiences to foster innovation and practical skills.' },
        { icon: Languages, title: 'Bilingual Program', description: 'Full immersion in English and French gives our students a competitive edge in a globalized world.' },
        { icon: BrainCircuit, title: 'Academic Competitions', description: 'We encourage students to excel through quiz bowls, science fairs, debates, and other intellectual contests.' },
        { icon: GraduationCap, title: 'College Preparation', description: 'Dedicated counseling and career guidance ensure students are well-prepared for university applications and future success.' },
    ];

    const faqs = [
        { q: 'Do students choose subjects in Senior High?', a: 'Yes, students in the Senior High division choose a specialization in either the sciences or humanities, allowing them to focus their studies based on their career aspirations.' },
        { q: 'What bilingual support is available?', a: 'Our curriculum is fully bilingual. We offer language support classes and encourage students to practice both English and French in academic and social settings to achieve fluency.' },
        { q: 'Are ICT labs mandatory?', a: 'Yes, ICT is a core component of our curriculum. All students from elementary to senior high are required to take ICT classes to develop essential digital literacy skills for the modern world.' },
    ];

    return (
        <>
            <section className="relative h-[450px] flex items-center justify-center text-center text-white">
                <Image
                    src="https://picsum.photos/seed/academics-hero/1920/1080"
                    alt="Students collaborating in a library"
                    fill
                    priority
                    sizes="100vw"
                    className="object-cover object-center"
                    data-ai-hint="students library"
                />
                <div className="absolute inset-0 bg-black/60" />
                <div className="relative z-10 container mx-auto px-6">
                    <AnimateOnScroll>
                        <h1 className="font-headline text-4xl md:text-6xl font-bold tracking-tight min-h-[60px] md:min-h-[80px]">
                           <Typewriter phrases={typewriterPhrases} />
                        </h1>
                        <p className="mt-4 text-lg md:text-xl text-white/90 max-w-3xl mx-auto">
                           Discover CMFI’s holistic approach to learning, designed to foster intellectual growth and character development from Nursery through Grade 12.
                        </p>
                    </AnimateOnScroll>
                </div>
            </section>
        
            <section className="bg-background">
                 <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                         <h2 className="font-headline text-3xl md:text-4xl font-bold">Academic Divisions</h2>
                    </AnimateOnScroll>
                     <div className="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        {academicDivisions.map((level, index) => (
                             <AnimateOnScroll key={level.title} delay={index * 100}>
                                <Card className="flex flex-col items-center p-6 text-center bg-primary/5 hover:border-accent/50 transition-all hover:shadow-lg h-full border backdrop-blur-sm">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                                        <level.icon className="h-10 w-10" />
                                    </div>
                                    <h3 className="font-headline text-xl font-semibold mb-2">{level.title}</h3>
                                    <p className="text-muted-foreground">{level.description}</p>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                     </div>
                </div>
            </section>

            <section id="departments" className="bg-card">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                         <h2 className="font-headline text-3xl md:text-4xl font-bold">Departments & Subjects</h2>
                    </AnimateOnScroll>
                     <div className="mt-16 grid grid-cols-2 md:grid-cols-3 gap-8">
                        {departments.map((dept, index) => (
                             <AnimateOnScroll key={dept.name} delay={index * 100}>
                                <Card className="p-6 h-full hover:border-primary/50 transition-colors">
                                    <div className="flex items-center gap-4">
                                        <div className="p-3 bg-primary/10 text-primary rounded-lg">
                                            <dept.icon className="h-6 w-6" />
                                        </div>
                                        <div>
                                            <h3 className="font-headline text-xl font-semibold">{dept.name}</h3>
                                            <p className="text-sm text-muted-foreground">{dept.subjects}</p>
                                        </div>
                                    </div>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                     </div>
                </div>
            </section>
            
            <section className="bg-background">
                 <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                         <h2 className="font-headline text-3xl md:text-4xl font-bold">Meet Our Educators</h2>
                         <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                            Our teachers are more than instructors — they are mentors, role models, and guides who nurture every child to reach their full potential.
                        </p>
                    </AnimateOnScroll>
                    <div className="mt-16 grid grid-cols-2 lg:grid-cols-4 gap-8">
                        {faculty.map((member, index) => (
                             <AnimateOnScroll key={index} delay={index * 100}>
                                <div className="text-center">
                                    <div className="relative aspect-square w-40 h-40 mx-auto rounded-full overflow-hidden mb-4 shadow-lg border-4 border-background">
                                        <Image src={member.imageUrl} fill sizes="160px" alt={member.name} data-ai-hint={member.hint} className="object-cover object-top" />
                                    </div>
                                    <h3 className="font-headline text-lg font-bold">{member.name}</h3>
                                    <p className="text-primary font-medium">{member.role}</p>
                                </div>
                            </AnimateOnScroll>
                        ))}
                    </div>
                 </div>
            </section>
            
            <section className="bg-card">
                <div className="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-start">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl font-bold mb-6">Academic Calendar</h2>
                        <Accordion type="single" collapsible className="w-full" defaultValue="item-1">
                          <AccordionItem value="item-1">
                            <AccordionTrigger>1st Term: September – December</AccordionTrigger>
                            <AccordionContent>
                              The academic year kicks off with foundational topics, mid-term assessments, and co-curricular activities. Ends with first term examinations.
                            </AccordionContent>
                          </AccordionItem>
                          <AccordionItem value="item-2">
                            <AccordionTrigger>2nd Term: January – April</AccordionTrigger>
                            <AccordionContent>
                              Focus on syllabus advancement, practical labs, and preparation for mid-year mock examinations. Includes Parent-Teacher conferences.
                            </AccordionContent>
                          </AccordionItem>
                          <AccordionItem value="item-3">
                            <AccordionTrigger>3rd Term: May – July</AccordionTrigger>
                            <AccordionContent>
                              Intensive revision, final examinations for promotion, and end-of-year ceremonies including graduation for Grade 12.
                            </AccordionContent>
                          </AccordionItem>
                        </Accordion>
                    </AnimateOnScroll>
                    <AnimateOnScroll delay={200}>
                        <h2 className="font-headline text-3xl font-bold mb-6">Academic Policies</h2>
                        <Accordion type="single" collapsible className="w-full">
                          <AccordionItem value="item-1">
                            <AccordionTrigger>Discipline Policy</AccordionTrigger>
                            <AccordionContent>
                              We uphold a strict code of conduct emphasizing respect, integrity, and punctuality to create a conducive learning environment for all students.
                            </AccordionContent>
                          </AccordionItem>
                          <AccordionItem value="item-2">
                            <AccordionTrigger>Attendance Policy</AccordionTrigger>
                            <AccordionContent>
                             Regular class attendance and active participation are mandatory. Students must maintain a minimum attendance percentage to be eligible for final examinations.
                            </AccordionContent>
                          </AccordionItem>
                          <AccordionItem value="item-3">
                            <AccordionTrigger>Assessment & Grading Policy</AccordionTrigger>
                            <AccordionContent>
                             Student performance is evaluated through a combination of continuous assessments, projects, and terminal examinations to ensure a comprehensive measure of understanding.
                            </AccordionContent>
                          </AccordionItem>
                        </Accordion>
                    </AnimateOnScroll>
                </div>
            </section>

             <section className="bg-background">
                 <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                         <h2 className="font-headline text-3xl md:text-4xl font-bold mb-12">Special Academic Features</h2>
                    </AnimateOnScroll>
                    <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                        {specialFeatures.map((feature, index) => (
                             <AnimateOnScroll key={feature.title} delay={index * 100}>
                                <Card className="p-6 text-center bg-primary/5 h-full">
                                    <div className="p-4 bg-primary/10 text-primary rounded-full mb-4 inline-block">
                                        <feature.icon className="h-8 w-8" />
                                    </div>
                                    <h3 className="font-headline text-xl font-bold mb-2">{feature.title}</h3>
                                    <p className="text-muted-foreground">{feature.description}</p>
                                </Card>
                            </AnimateOnScroll>
                        ))}
                    </div>
                 </div>
            </section>

             <section className="bg-card">
                <div className="container mx-auto px-6">
                    <AnimateOnScroll className="text-center">
                        <h2 className="font-headline text-3xl font-bold mb-6">Frequently Asked Questions</h2>
                    </AnimateOnScroll>
                     <AnimateOnScroll className="max-w-2xl mx-auto" delay={200}>
                        <Accordion type="single" collapsible className="w-full">
                          {faqs.map((faq, index) => (
                            <AccordionItem key={index} value={`item-${index + 1}`}>
                                <AccordionTrigger className="text-left">{faq.q}</AccordionTrigger>
                                <AccordionContent>{faq.a}</AccordionContent>
                            </AccordionItem>
                          ))}
                        </Accordion>
                    </AnimateOnScroll>
                </div>
            </section>
            
             <section className="relative bg-primary text-primary-foreground">
                <div className="container mx-auto px-6 text-center relative z-10">
                    <AnimateOnScroll>
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">
                            "Excellence in Learning, Integrity in Character."
                        </h2>
                        <p className="mt-4 max-w-2xl mx-auto text-lg text-primary-foreground/80">
                            At CMFI, education goes beyond textbooks — it prepares leaders for tomorrow.
                        </p>
                        <div className="mt-8 flex justify-center gap-4">
                            <Button asChild size="lg" variant="secondary" className="animate-pulse-glow">
                                <Link href="/admissions">Explore Admissions</Link>
                            </Button>
                        </div>
                    </AnimateOnScroll>
                </div>
            </section>
        </>
    );
};

export default AcademicsPage;
