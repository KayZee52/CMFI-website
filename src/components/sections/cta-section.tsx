import Link from 'next/link';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Button } from '../ui/button';
import Image from 'next/image';

const CtaSection = () => {
    return (
        <section className="relative bg-primary text-primary-foreground">
             <Image 
                src="https://picsum.photos/seed/cta-bg/1920/1080"
                layout="fill"
                objectFit="cover"
                alt="Graduation"
                data-ai-hint="graduation students"
                className="opacity-20"
            />
            <div className="absolute inset-0 bg-primary/80" />
            <div className="container mx-auto px-6 text-center relative z-10">
                <AnimateOnScroll>
                    <h2 className="font-headline text-3xl md:text-4xl font-bold">
                        Join CMFI Today
                    </h2>
                    <p className="mt-4 text-lg max-w-2xl mx-auto">
                        Empowering the next generation of leaders. Learn more about our admission process and become part of our community.
                    </p>
                    <Button asChild size="lg" variant="secondary" className="mt-8">
                        <Link href="/admissions">Learn About Admissions</Link>
                    </Button>
                </AnimateOnScroll>
            </div>
        </section>
    );
}

export default CtaSection;
