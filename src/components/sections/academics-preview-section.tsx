import Link from 'next/link';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Button } from '../ui/button';
import { ArrowRight } from 'lucide-react';
import { Languages, Calculator, FlaskConical, Globe, Palette, Presentation } from 'lucide-react';
import { CMFILogo } from '../icons';
import { cn } from '@/lib/utils';

const departments = [
    { name: 'Languages & Humanities', icon: Languages, position: 'top' },
    { name: 'Sciences', icon: FlaskConical, position: 'right' },
    { name: 'Mathematics', icon: Calculator, position: 'left' },
    { name: 'ICT & Digital Learning', icon: Presentation, position: 'top-left' },
    { name: 'Creative Arts', icon: Palette, position: 'bottom-right' },
    { name: 'Business & Social Studies', icon: Globe, position: 'bottom-left' },
];

const positionClasses = {
    'top': 'top-0 left-1/2 -translate-x-1/2 -translate-y-full',
    'right': 'top-1/2 right-0 translate-x-full -translate-y-1/2',
    'bottom': 'bottom-0 left-1/2 -translate-x-1/2 translate-y-full',
    'left': 'top-1/2 left-0 -translate-x-full -translate-y-1/2',
    'top-left': 'top-0 left-0 -translate-x-1/2 -translate-y-1/2',
    'bottom-right': 'bottom-0 right-0 translate-x-1/2 translate-y-1/2',
    'bottom-left': 'bottom-0 left-0 -translate-x-1/2 translate-y-1/2',
};

const lineClasses = {
    'top': 'h-1/2 bottom-1/2 left-1/2 -translate-x-1/2',
    'right': 'w-1/2 top-1/2 left-1/2',
    'bottom': 'h-1/2 top-1/2 left-1/2 -translate-x-1/2',
    'left': 'w-1/2 top-1/2 right-1/2',
    'top-left': 'h-[70.7%] bottom-[50%] left-[50%] -translate-x-full origin-bottom-right -rotate-45',
    'bottom-right': 'h-[70.7%] top-[50%] left-[50%] -translate-x-full origin-top-right rotate-45',
    'bottom-left': 'h-[70.7%] top-[50%] right-[50%] -translate-x-0 origin-top-left -rotate-45',
}

const AcademicsPreview = () => {
    return (
        <section className="bg-background">
            <div className="container mx-auto px-6">
                <AnimateOnScroll className="text-center max-w-3xl mx-auto">
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">A World-Class Curriculum</h2>
                    <p className="mt-4 text-lg text-muted-foreground">
                        Our curriculum is a balanced ecosystem of disciplines, designed to foster intellectual curiosity and prepare students for global opportunities.
                    </p>
                </AnimateOnScroll>

                {/* Desktop Radial Layout */}
                <AnimateOnScroll className="hidden md:block mt-32 mb-24">
                    <div className="relative w-48 h-48 mx-auto">
                        <div className="absolute inset-0 flex items-center justify-center">
                            <div className="w-48 h-48 bg-primary/10 rounded-full animate-pulse-glow" />
                        </div>
                        <div className="absolute inset-5 flex items-center justify-center">
                            <div className="w-36 h-36 bg-primary/20 rounded-full animate-pulse-glow [animation-delay:-2s]" />
                        </div>
                        <div className="absolute inset-10 flex items-center justify-center">
                             <CMFILogo className="h-24 w-24" />
                        </div>

                        {departments.map((dept, index) => (
                            <div key={dept.name}>
                                {/* Spokes */}
                                <div className={cn(
                                    "absolute w-px bg-border/80",
                                    lineClasses[dept.position as keyof typeof lineClasses]
                                )}/>
                                
                                {/* Department Nodes */}
                                <AnimateOnScroll 
                                    delay={index * 150}
                                    className={cn(
                                        "absolute flex flex-col items-center text-center w-40",
                                        positionClasses[dept.position as keyof typeof positionClasses]
                                    )}
                                >
                                    <div className="p-4 bg-background rounded-full border shadow-sm mb-2">
                                        <dept.icon className="h-10 w-10 text-primary" />
                                    </div>
                                    <h3 className="font-headline text-base font-semibold">{dept.name}</h3>
                                </AnimateOnScroll>
                            </div>
                        ))}
                    </div>
                </AnimateOnScroll>

                {/* Mobile List Layout */}
                <div className="mt-16 grid grid-cols-1 sm:grid-cols-2 md:hidden gap-6">
                    {departments.map((dept, index) => (
                        <AnimateOnScroll key={dept.name} delay={index * 100}>
                            <div className="flex items-center gap-4 p-4 border rounded-lg bg-card">
                                <div className="p-3 bg-primary/10 text-primary rounded-lg">
                                    <dept.icon className="h-8 w-8" />
                                </div>
                                <div>
                                    <h3 className="font-headline text-lg font-semibold">{dept.name}</h3>
                                </div>
                            </div>
                        </AnimateOnScroll>
                    ))}
                </div>


                <AnimateOnScroll className="text-center mt-16 md:mt-24">
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
