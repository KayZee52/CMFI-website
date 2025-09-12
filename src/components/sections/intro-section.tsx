import { AnimateOnScroll } from "../animate-on-scroll";
import { Button } from "../ui/button";
import Link from "next/link";
import Image from "next/image";

const IntroSection = () => {
  return (
    <section className="bg-card">
      <div className="container mx-auto px-6">
        <div className="grid md:grid-cols-2 gap-12 items-center">
            <AnimateOnScroll>
                <h2 className="font-headline text-3xl md:text-4xl font-bold">
                    Welcome to CMFI Bilingual High School
                </h2>
                <p className="mt-4 text-lg text-muted-foreground">
                    At CMFI, we are dedicated to nurturing the next generation of leaders through academic excellence and strong character development. Our unique bilingual curriculum prepares students for a globalized world, rooted in our motto: "Building leaders for the future."
                </p>
                <Button asChild size="lg" className="mt-6">
                    <Link href="/about">Learn More About Us</Link>
                </Button>
            </AnimateOnScroll>
            <AnimateOnScroll delay={200}>
                <div className="relative aspect-video rounded-lg overflow-hidden shadow-lg">
                     <Image src="https://picsum.photos/seed/intro-image/800/600" layout="fill" objectFit="cover" alt="Students in a classroom" data-ai-hint="students classroom"/>
                </div>
            </AnimateOnScroll>
        </div>
      </div>
    </section>
  );
};

export default IntroSection;
