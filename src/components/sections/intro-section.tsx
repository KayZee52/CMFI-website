import { AnimateOnScroll } from "../animate-on-scroll";
import { Card, CardContent, CardHeader, CardTitle } from "../ui/card";
import { BookOpen, Globe, Users } from "lucide-react";

const IntroSection = () => {

  const highlights = [
    {
      icon: BookOpen,
      title: "Excellence in Learning",
      description: "We are committed to providing a rigorous academic environment that challenges students to achieve their full potential."
    },
    {
      icon: Globe,
      title: "Bilingual Education",
      description: "Our curriculum in English and French prepares students for success in a globalized world."
    },
    {
      icon: Users,
      title: "Community & Character",
      description: "We foster a supportive community that emphasizes discipline, integrity, and service to others."
    }
  ];

  return (
    <section id="about-preview" className="bg-card">
      <div className="container mx-auto px-6">
        <AnimateOnScroll className="text-center max-w-3xl mx-auto">
          <h2 className="font-headline text-3xl md:text-4xl font-bold">
            Building Future Leaders
          </h2>
          <p className="mt-4 text-lg text-muted-foreground">
            CMFI Bilingual High School is committed to building future leaders through bilingual education, discipline, and academic excellence.
          </p>
        </AnimateOnScroll>
        
        <div className="mt-16 grid md:grid-cols-3 gap-8">
          {highlights.map((highlight, index) => (
            <AnimateOnScroll key={highlight.title} delay={100 * (index + 1)}>
              <Card className="text-center h-full hover:shadow-lg transition-shadow">
                  <CardHeader className="items-center">
                      <div className="p-4 bg-primary/10 text-primary rounded-full mb-4">
                          <highlight.icon className="h-8 w-8" />
                      </div>
                      <CardTitle className="font-headline text-xl">{highlight.title}</CardTitle>
                  </CardHeader>
                  <CardContent>
                      <p className="text-muted-foreground">{highlight.description}</p>
                  </CardContent>
              </Card>
            </AnimateOnScroll>
          ))}
        </div>
      </div>
    </section>
  );
};

export default IntroSection;
