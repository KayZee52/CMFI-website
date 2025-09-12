import { AnimateOnScroll } from '../animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { Target, BookOpen, Handshake, BrainCircuit, MessageSquareQuote } from 'lucide-react';
import TimelineSection from './timeline-section';

const AboutPageContent = () => {
  const values = [
    {
      icon: Target,
      title: 'Our Mission',
      description: 'To provide a holistic bilingual education that develops intellectual, moral, and spiritual growth in every student.',
    },
    {
      icon: BookOpen,
      title: 'Our Vision',
      description: 'To be a leading center of academic excellence and character formation, producing globally competitive leaders.',
    },
    {
      icon: Handshake,
      title: 'Core Values',
      description: 'Discipline, Integrity, Excellence, and Service.',
    },
  ];

  return (
    <>
    <section id="about" className="bg-card">
      <div className="container mx-auto px-6">
        <AnimateOnScroll className="text-center">
          <h1 className="font-headline text-4xl md:text-5xl font-bold">
            About CMFI Bilingual High School
          </h1>
          <p className="mt-4 max-w-3xl mx-auto text-lg text-muted-foreground">
            Building leaders for the future.
          </p>
        </AnimateOnScroll>
        
        <AnimateOnScroll delay={200} className="mt-16">
            <Card className="overflow-hidden md:flex">
                <div className="md:w-1/3">
                    <img src="https://picsum.photos/seed/principal/600/800" alt="Principal" data-ai-hint="portrait person" className="object-cover w-full h-full" />
                </div>
                <div className="md:w-2/3">
                    <CardHeader>
                        <CardTitle className="font-headline text-3xl">Principal's Welcome</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p className="text-muted-foreground mb-4">
                            "Welcome to CMFI Bilingual High School! We are a community dedicated to fostering academic excellence and nurturing well-rounded individuals. Our unique bilingual approach prepares students for a globalized world, while our commitment to strong moral values ensures they grow into responsible and compassionate leaders."
                        </p>
                        <p className="font-semibold text-foreground"> - Principal's Name</p>
                    </CardContent>
                </div>
            </Card>
        </AnimateOnScroll>

        <div className="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
          {values.map((feature, index) => (
            <AnimateOnScroll key={feature.title} delay={index * 100}>
              <Card className="text-center h-full hover:shadow-lg transition-shadow duration-300">
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
    
    <TimelineSection />
    </>
  );
};

export default AboutPageContent;
