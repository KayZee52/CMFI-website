import Image from 'next/image';
import Link from 'next/link';
import { AnimateOnScroll } from '../animate-on-scroll';
import { ArrowRight } from 'lucide-react';
import { cn } from '@/lib/utils';

const EngagedLearningSection = () => {
    const links = [
        { name: 'Explore Student Life', href: '/student-life' },
        { name: 'Visit Our Gallery', href: '/gallery' },
        { name: 'Get Admission Updates', href: '/admissions' },
        { name: 'Contact Our Team', href: '/contact' },
    ];

    return (
        <section className="bg-primary text-primary-foreground">
            <div className="container mx-auto px-6">
                <div className="grid md:grid-cols-2 gap-12 items-center">
                    <AnimateOnScroll
                        className="transition-all duration-700 ease-out"
                        style={{ transform: 'translateX(-5%)', opacity: 0 }}
                    >
                        <div className="relative aspect-[4/3] rounded-lg overflow-hidden shadow-2xl">
                            <Image
                                src="https://picsum.photos/seed/engaged-learning/800/600"
                                alt="Students engaged in a classroom discussion"
                                data-ai-hint="students discussion classroom"
                                fill
                                sizes="(max-width: 768px) 100vw, 50vw"
                                className="object-cover"
                            />
                        </div>
                    </AnimateOnScroll>
                    <AnimateOnScroll
                        delay={200}
                        className="transition-all duration-700 ease-out"
                        style={{ transform: 'translateX(5%)', opacity: 0 }}
                    >
                        <h2 className="font-headline text-3xl font-bold">
                            Engaged Learning & Community
                        </h2>
                        <p className="mt-4 text-lg text-primary-foreground/80">
                            Our commitment to education extends beyond the classroom. We encourage students to explore their passions, engage with their peers, and grow as well-rounded individuals.
                        </p>
                        <ul className="mt-6 space-y-3">
                            {links.map((link) => (
                                <li key={link.name}>
                                    <Link href={link.href} className="inline-flex items-center gap-2 group text-accent hover:text-white transition-colors">
                                        <ArrowRight className="h-5 w-5 text-accent group-hover:text-white transition-colors" />
                                        <span className="font-semibold">{link.name}</span>
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </AnimateOnScroll>
                </div>
            </div>
        </section>
    );
}

export default EngagedLearningSection;
