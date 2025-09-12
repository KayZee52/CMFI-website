import Link from 'next/link';
import Image from 'next/image';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Button } from '../ui/button';
import { ArrowRight } from 'lucide-react';

const StudentLifePreview = () => {
    return (
        <section className="bg-card">
            <div className="container mx-auto px-6">
                <div className="grid md:grid-cols-2 gap-12 items-center">
                    <AnimateOnScroll>
                        <div className="grid grid-cols-2 gap-4">
                            <div className="relative aspect-square rounded-lg overflow-hidden shadow-lg group">
                                <Image src="https://picsum.photos/seed/student-life-1/600/600" layout="fill" objectFit="cover" alt="Students in sports" data-ai-hint="students playing sports" className="group-hover:scale-105 transition-transform duration-300" />
                            </div>
                            <div className="relative aspect-square rounded-lg overflow-hidden shadow-lg group mt-8">
                                <Image src="https://picsum.photos/seed/student-life-2/600/600" layout="fill" objectFit="cover" alt="Students in cultural event" data-ai-hint="students cultural event" className="group-hover:scale-105 transition-transform duration-300" />
                            </div>
                        </div>
                    </AnimateOnScroll>
                     <AnimateOnScroll delay={200}>
                        <h2 className="font-headline text-3xl md:text-4xl font-bold">
                            More Than Just a Classroom
                        </h2>
                        <p className="mt-4 text-lg text-muted-foreground">
                            Life at CMFI goes beyond academics. From competitive sports and engaging clubs to vibrant cultural events, our students learn, lead, and grow in a dynamic community.
                        </p>
                        <Button asChild size="lg" className="mt-6">
                            <Link href="/student-life">
                                Discover Student Life <ArrowRight className="ml-2 h-5 w-5" />
                            </Link>
                        </Button>
                    </AnimateOnScroll>
                </div>
            </div>
        </section>
    );
}

export default StudentLifePreview;
