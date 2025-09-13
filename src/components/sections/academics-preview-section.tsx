import { AnimateOnScroll } from '../animate-on-scroll';
import { CMFILogo } from '../icons';
import { glanceStats } from '@/lib/data';
import { Arc } from '../arc';
import { Button } from '../ui/button';
import Link from 'next/link';
import { ArrowRight } from 'lucide-react';

const AcademicsPreview = () => {
    const numSegments = glanceStats.length;
    const angle = 360 / numSegments;
    const skew = 90 - angle;

    return (
        <section className="bg-background">
            <div className="container mx-auto px-6 text-center">
                 <AnimateOnScroll>
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">A World-Class Curriculum</h2>
                    <p className="mt-4 text-lg text-muted-foreground max-w-3xl mx-auto">
                        Our curriculum is a balanced ecosystem of disciplines, designed to foster intellectual curiosity and prepare students for global opportunities.
                    </p>
                </AnimateOnScroll>
                <div className="relative aspect-square max-w-2xl mx-auto mt-12">
                    <div className="absolute inset-0 animate-revolve">
                        {glanceStats.map((stat, index) => {
                            const rotate = angle * index;
                            return (
                                <Arc
                                    key={index}
                                    rotate={rotate}
                                    angle={angle}
                                    skew={skew}
                                    text={stat.label}
                                    value={stat.value}
                                    Icon={<stat.Icon />}
                                    color={index % 2 === 0 ? 'hsl(var(--primary))' : 'hsl(var(--primary) / 0.8)'}
                                    animationDelay={index * 100}
                                />
                            )
                        })}
                    </div>
                     <div className="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <AnimateOnScroll delay={500} className="text-center bg-background rounded-full w-[35%] h-[35%] flex flex-col items-center justify-center shadow-2xl p-4">
                            <CMFILogo className="h-16 w-16 mb-2" />
                            <h3 className="font-headline text-2xl font-bold">CMFI</h3>
                            <p className="text-muted-foreground text-sm">At a Glance</p>
                        </AnimateOnScroll>
                    </div>
                </div>
                 <AnimateOnScroll className="mt-12">
                    <Button asChild size="lg">
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
