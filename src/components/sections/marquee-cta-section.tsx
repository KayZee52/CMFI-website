import Link from 'next/link';
import { Button } from '../ui/button';
import { cn } from '@/lib/utils';
import { AnimateOnScroll } from '../animate-on-scroll';

const MarqueeText = ({ children, direction = 'left' }: { children: React.ReactNode, direction?: 'left' | 'right' }) => (
    <div className="flex-shrink-0 flex items-center gap-8 py-4">
        {Array(10).fill(0).map((_, i) => (
            <span key={i} className="text-4xl md:text-6xl font-bold tracking-tighter whitespace-nowrap text-primary-foreground/20">
                {children}
            </span>
        ))}
    </div>
);

const MarqueeCtaSection = () => {
    return (
        <section className="bg-primary text-primary-foreground relative overflow-hidden">
            <div className="absolute top-0 left-0 w-full opacity-50">
                 <div className="relative flex w-[200%] animate-marquee-left">
                    <MarqueeText direction="left">LEADING IN EDUCATION</MarqueeText>
                    <MarqueeText direction="left">LEADING IN EDUCATION</MarqueeText>
                </div>
            </div>
             <div className="absolute bottom-0 left-0 w-full opacity-50">
                 <div className="relative flex w-[200%] animate-marquee-right">
                    <MarqueeText direction="right">ONE OF THE BEST SCHOOLS IN LIBERIA</MarqueeText>
                    <MarqueeText direction="right">ONE OF THE BEST SCHOOLS IN LIBERIA</MarqueeText>
                </div>
            </div>

            <div className="container mx-auto px-6 text-center relative z-10">
                <AnimateOnScroll>
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">
                        Ready to become a part of CMFI?
                    </h2>
                    <Button asChild size="lg" variant="secondary" className="mt-8">
                        <Link href="/admissions">Apply Now</Link>
                    </Button>
                </AnimateOnScroll>
            </div>
        </section>
    );
}

export default MarqueeCtaSection;
