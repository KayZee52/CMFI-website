import { AnimateOnScroll } from '../animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { Target, BookOpen, Award } from 'lucide-react';

const AboutSection = () => {
  const features = [
    {
      icon: Target,
      title: 'Our Mission',
      description: 'To provide a holistic education that develops intellectual, moral, and spiritual growth in every student.',
    },
    {
      icon: BookOpen,
      title: 'Academic Excellence',
      description: 'A rigorous curriculum designed to challenge students and foster a lifelong love for learning and discovery.',
    },
    {
      icon: Award,
      title: 'WAEC/WASSCE Focus',
      description: 'Specialized preparation programs and continuous assessment to ensure our students excel in national examinations.',
    },
  ];

  return (
    <section id="about" className="bg-card">
      <div className="container mx-auto px-6">
        <AnimateOnScroll className="text-center">
          <h2 className="font-headline text-3xl md:text-4xl font-bold">
            Shaping Future Leaders
          </h2>
          <p className="mt-4 max-w-3xl mx-auto text-lg text-muted-foreground">
            At CMFI, we are dedicated to nurturing the next generation of leaders through academic excellence and strong character development. Our focused approach prepares students for success in the WAEC/WASSCE and beyond.
          </p>
        </AnimateOnScroll>

        <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
          {features.map((feature, index) => (
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
  );
};

export default AboutSection;
