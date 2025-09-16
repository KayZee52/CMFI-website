

'use client';

import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { Card } from '@/components/ui/card';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import { Baby, GraduationCap, Users, Dna, School, BrainCircuit, FlaskConical, Languages, Calculator, Globe, Paintbrush, Medal, Building } from 'lucide-react';
import Image from 'next/image';
import { Button } from '@/components/ui/button';
import Link from 'next/link';
import { Typewriter } from '@/components/typewriter';
import { facultyData } from '@/lib/faculty-data';
import EngagedLearningSection from '@/components/sections/engaged-learning-section';
import MarqueeCtaSection from '@/components/sections/marquee-cta-section';

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
    
    const specialFeatures = [
        { icon: Dna, title: 'ICT & Science Labs', description: 'Our modern labs provide advanced, hands-on learning experiences to foster innovation and practical skills.' },
        { icon: Languages, title: 'Bilingual Program', description: 'Full immersion in English and French gives our students a competitive edge in a globalized world.' },
        { icon: BrainCircuit, title: 'Academic Competitions', description: 'We encourage students to excel through quiz bowls, science fairs, debates, and other intellectual contests.' },
        { icon: GraduationCap, title: 'College Preparation', description: 'Dedicated counseling and career guidance ensure students are well-prepared for university applications and future success.' },
    ];

    const faqs = [
        { q: "What are the school's operating hours?", a: "Our academic day runs from 8:00 AM to 3:00 PM, Monday through Friday. The administrative office is open until 4:00 PM for inquiries and other services." },
        { q: "What is the student-teacher ratio?", a: "We strive to maintain a low student-teacher ratio to ensure personalized attention. On average, our classes have approximately 25 students per teacher, allowing for more interactive and effective learning." },
        { q: "How does the school handle student discipline and safety?", a: "We have a clearly defined code of conduct that emphasizes respect, responsibility, and safety. Disciplinary measures are corrective rather than punitive, and our campus is monitored to ensure a safe and secure learning environment for all." },
    ];

    return (
        <>
            <section className="relative h-[450px] flex items-center justify-center text-center text-white">
                <Image
                    src="/images/heroimages/academicshero.jpeg"
                    alt="Students collaborating in a library"
                    fill
                    priority
                    sizes="100vw"
                    className="object-cover object-center blur-sm"
                    data-ai-hint="students library"
                />
                <div className="absolute inset-0 bg-primary/50" />
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
                                    <AnimateOnScroll delay={index * 100 + 100}>
                                        <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                                            <level.icon className="h-10 w-10" />
                                        </div>
                                    </AnimateOnScroll>
                                    <AnimateOnScroll delay={index * 100 + 200}>
                                        <h3 className="font-headline text-xl font-semibold mb-2">{level.title}</h3>
                                    </AnimateOnScroll>
                                    <AnimateOnScroll delay={index * 100 + 300}>
                                        <p className="text-muted-foreground">{level.description}</p>
                                    </AnimateOnScroll>
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
                    <div className="mt-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                        {facultyData.map((member, index) => (
                             <AnimateOnScroll key={index} delay={index * 100}>
                                <div>
                                    <div className="relative aspect-[4/5] w-full overflow-hidden mb-4 rounded-md shadow-lg">
                                        <Image src={member.imageUrl} fill sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 25vw" alt={member.name} data-ai-hint={member.hint} className="object-cover object-top" />
                                    </div>
                                    <h3 className="font-headline text-lg font-bold uppercase tracking-wide">{member.name}</h3>
                                    <p className="text-muted-foreground text-sm">{member.role}</p>
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
            
            <EngagedLearningSection />
            
            <MarqueeCtaSection />
        </>
    );
};

export default AcademicsPage;
