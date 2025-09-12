import Link from 'next/link';
import Image from 'next/image';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Card, CardContent } from '../ui/card';
import { ArrowRight } from 'lucide-react';

const previewItems = [
    {
        title: "Academics",
        description: "Explore our rigorous bilingual curriculum and dedicated departments.",
        link: "/academics",
        imageSeed: "academics-preview",
        imageHint: "library books",
    },
    {
        title: "Student Life",
        description: "Discover our vibrant sports, clubs, and extracurricular activities.",
        link: "/student-life",
        imageSeed: "student-life-preview",
        imageHint: "students celebrating",
    },
    {
        title: "Admissions",
        description: "Learn about our admission process and how to join our community.",
        link: "/admissions",
        imageSeed: "admissions-preview",
        imageHint: "school entrance",
    }
];

const PreviewSection = () => {
    return (
        <section className="bg-background">
            <div className="container mx-auto px-6">
                <div className="grid md:grid-cols-3 gap-8">
                    {previewItems.map((item, index) => (
                        <AnimateOnScroll key={item.title} delay={index * 150}>
                             <Link href={item.link}>
                                <Card className="group overflow-hidden h-full">
                                    <div className="relative aspect-video">
                                        <Image src={`https://picsum.photos/seed/${item.imageSeed}/800/600`} layout="fill" objectFit="cover" alt={item.title} data-ai-hint={item.imageHint} className="group-hover:scale-105 transition-transform duration-300"/>
                                    </div>
                                    <CardContent className="p-6">
                                        <h3 className="font-headline text-xl font-bold mb-2">{item.title}</h3>
                                        <p className="text-muted-foreground mb-4">{item.description}</p>
                                        <div className="text-primary font-semibold flex items-center gap-2">
                                            Learn More <ArrowRight className="h-4 w-4 transform group-hover:translate-x-1 transition-transform" />
                                        </div>
                                    </CardContent>
                                </Card>
                            </Link>
                        </AnimateOnScroll>
                    ))}
                </div>
            </div>
        </section>
    );
}

export default PreviewSection;
