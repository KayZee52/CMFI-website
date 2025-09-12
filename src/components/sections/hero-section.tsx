import Link from 'next/link';
import { Button } from '@/components/ui/button';
import { AnimateOnScroll } from '../animate-on-scroll';

const HeroSection = () => {
  // TODO: Replace with the actual URL of your school's promotional video.
  const videoUrl = 'https://videos.pexels.com/video-files/853878/853878-hd_1920_1080_25fps.mp4';

  return (
    <section id="home" className="relative h-screen min-h-[700px] flex items-center justify-center text-center text-white overflow-hidden">
      <video
        src={videoUrl}
        autoPlay
        loop
        muted
        playsInline
        className="absolute top-1/2 left-1/2 w-full h-full min-w-full min-h-full object-cover transform -translate-x-1/2 -translate-y-1/2 z-0"
      />
      <div className="absolute inset-0 bg-black/60 z-10" />
      <div className="relative z-20 container mx-auto px-6">
        <AnimateOnScroll>
          <h2 className="font-headline text-lg md:text-xl tracking-[0.3em] font-light uppercase text-white/80">
            CMFI Bilingual High School
          </h2>
        </AnimateOnScroll>
        <AnimateOnScroll delay={200}>
           <h1 className="font-headline text-5xl md:text-8xl font-bold tracking-tight mt-4">
            Be A Leader
          </h1>
        </AnimateOnScroll>
        <AnimateOnScroll delay={400}>
          <p className="mt-6 max-w-3xl mx-auto text-base md:text-lg text-white/90">
            A private, co-educational, English & French college preparatory school for students in grades 7 through 12.
          </p>
        </AnimateOnScroll>
        <AnimateOnScroll delay={600}>
          <div className="mt-10 flex flex-col sm:flex-row justify-center items-center gap-4">
            <Button asChild size="lg" className="w-full sm:w-auto bg-accent hover:bg-accent/90 text-accent-foreground">
              <Link href="/admissions">
                Apply
              </Link>
            </Button>
            <Button asChild size="lg" variant="outline" className="w-full sm:w-auto text-white border-white hover:bg-white hover:text-primary">
              <Link href="/contact">
                Inquire
              </Link>
            </Button>
          </div>
        </AnimateOnScroll>
      </div>
    </section>
  );
};

export default HeroSection;
