import { AnimateOnScroll } from '../animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { Target, Eye, Handshake } from 'lucide-react';
import Image from 'next/image';

const AboutPageContent = () => {
  const values = [
    {
      icon: Target,
      title: 'Our Mission',
      description: 'To provide a holistic bilingual education that develops intellectual, moral, and spiritual growth in every student, preparing them for a globally competitive world.',
    },
    {
      icon: Eye,
      title: 'Our Vision',
      description: 'To be a leading center of academic excellence and character formation, recognized for producing disciplined, innovative, and responsible leaders.',
    },
    {
      icon: Handshake,
      title: 'Core Values',
      description: 'We are guided by Excellence, Integrity, Respect, Service, and Community. These values shape our culture and our students\' character.',
    },
  ];

  return (
    <>
    <section className="relative h-[400px] flex items-center justify-center text-center text-white">
        <Image
            src="https://picsum.photos/seed/about-hero/1920/1080"
            alt="CMFI Campus"
            fill
            priority
            sizes="100vw"
            className="object-cover"
            data-ai-hint="school campus"
        />
        <div className="absolute inset-0 bg-black/60" />
        <div className="relative z-10 container mx-auto px-6">
            <AnimateOnScroll>
                <h1 className="font-headline text-4xl md:text-6xl font-bold tracking-tight">
                    About CMFI Bilingual High School
                </h1>
                <p className="mt-4 text-lg md:text-xl text-white/90">
                    Building leaders for the future since 2010.
                </p>
            </AnimateOnScroll>
        </div>
    </section>

    <section id="about" className="bg-card">
      <div className="container mx-auto px-6">
        <AnimateOnScroll className="mt-16">
            <Card className="overflow-hidden md:flex shadow-lg">
                <div className="md:w-1/3 relative min-h-[300px] md:min-h-0">
                    <Image src="/images/adminstrators/principal.jpeg" alt="Principal Simeon E. Ojong" data-ai-hint="portrait person" fill sizes="(max-width: 768px) 100vw, 33vw" className="object-cover" />
                </div>
                <div className="md:w-2/3">
                    <CardHeader>
                        <CardTitle className="font-headline text-3xl">Principal's Welcome</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p className="text-muted-foreground mb-4">
                            "Welcome to CMFI Bilingual High School! We are a community dedicated to fostering academic excellence and nurturing well-rounded individuals. Our unique bilingual approach prepares students for a globalized world, while our commitment to strong moral values ensures they grow into responsible and compassionate leaders of tomorrow."
                        </p>
                        <p className="font-semibold text-foreground">- Simeon E. Ojong, Principal</p>
                    </CardContent>
                </div>
            </Card>
        </AnimateOnScroll>

        <AnimateOnScroll delay={200} className="text-center mt-24">
            <h2 className="font-headline text-3xl md:text-4xl font-bold">Our Guiding Principles</h2>
        </AnimateOnScroll>

        <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
          {values.map((feature, index) => (
            <AnimateOnScroll key={feature.title} delay={index * 100}>
              <Card className="text-center h-full hover:shadow-xl transition-shadow duration-300">
                <CardHeader className="items-center">
                  <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                    <feature.icon className="h-8 w-8" />
                  </div>
                  <CardTitle className="font-headline text-xl">{feature.title}</CardTitle>
                </CardHeader>
                <CardContent>
                  <p className="text-muted-foreground">{feature.description}</p>
                </CardContent>
              </Card>
            </AnimateOnScroll>
          ))}
        </div>
      </div>
    </section>
    </>
  );
};

export default AboutPageContent;
