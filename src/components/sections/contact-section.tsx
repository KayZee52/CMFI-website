
'use client';

import { useEffect, useId, useState, useTransition } from 'react';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { submitContactForm, type ContactFormState } from '@/lib/actions';
import { useToast } from '@/hooks/use-toast';
import { Loader2, Mail, Phone, MapPin, Clock, Facebook, Instagram, Twitter } from 'lucide-react';
import Image from 'next/image';
import Link from 'next/link';
import NewsSection from './news-section';

const contactFormSchema = z.object({
  name: z.string().min(2, { message: 'Name must be at least 2 characters.' }),
  email: z.string().email({ message: 'Please enter a valid email.' }),
  subject: z.string().min(5, { message: 'Subject must be at least 5 characters.' }),
  message: z.string().min(10, { message: 'Message must be at least 10 characters.' }),
});

type ContactFormValues = z.infer<typeof contactFormSchema>;

const ContactPageContent = () => {
  const { toast } = useToast();
  const [state, setState] = useState<ContactFormState>({ message: '' });
  const [isPending, startTransition] = useTransition();

  const form = useForm<ContactFormValues>({
    resolver: zodResolver(contactFormSchema),
    defaultValues: { name: '', email: '', subject: '', message: '' },
  });

  useEffect(() => {
    if (state.message === 'success') {
      toast({
        title: 'Message Sent!',
        description: 'Thank you for contacting us. We will get back to you shortly.',
      });
      form.reset();
      setState({ message: '' }); // Reset state after showing toast
    } else if (state.message && state.message !== '') {
      toast({
        variant: 'destructive',
        title: 'Uh oh! Something went wrong.',
        description: state.message,
      });
       setState({ message: '' }); // Reset state after showing toast
    }
  }, [state, toast, form]);

  const onSubmit = (values: ContactFormValues) => {
    const formData = new FormData();
    Object.entries(values).forEach(([key, value]) => {
        formData.append(key, value);
    });

    startTransition(async () => {
        const result = await submitContactForm(undefined, formData);
        setState(result);
    });
  };

  const googleMapsUrl = "https://www.google.com/maps/place/C+M+F+I+COMPUS/@6.2972144,-10.7048804,93m/data=!3m1!1e3!4m12!1m5!8m4!1e3!2s109661092954929372296!3m1!1e1!3m5!1s0xf09ff47e5c02a07:0x31b2da1a364f8544!8m2!3d6.2971472!4d-10.7048819!16s%2Fg%2F11rp0tf6_0?entry=ttu&g_ep=EgoyMDI1MDkwOS4wIKXMDSoASAFQAw%3D%3D";
  const embedMapsUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3227.331855121172!2d-10.707456826099728!3d6.297152525754518!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xf09ff47e5c02a07%3A0x31b2da1a364f8544!2sC%20M%20F%20I%20COMPUS!5e1!3m2!1sen!2sus!4v1757677670381!5m2!1sen!2sus";

  const contactDetails = [
    { icon: MapPin, text: 'CMFI Bilingual High School, 72nd, Paynesville, Liberia', href: googleMapsUrl },
    { icon: Phone, text: '+231 77 073 2334', href: 'tel:+231770732334' },
    { icon: Mail, text: 'info@cmfischool.online' },
    { icon: Clock, text: 'Mon-Fri, 8:00 AM - 4:00 PM' },
  ];

  const socialLinks = [
    { name: 'Facebook', icon: Facebook, href: '#' },
    { name: 'Twitter', icon: Twitter, href: '#' },
    { name: 'Instagram', icon: Instagram, href: '#' },
  ];
  
  const uniqueId = useId();

  return (
    <>
      <section className="relative h-[400px] flex items-center justify-center text-center text-white">
        <Image
            src="/images/heroimages/contacthero.jpeg"
            alt="CMFI School Campus"
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
                    Get in Touch
                </h1>
                <p className="mt-4 text-lg md:text-xl text-white/90">
                    Stay connected with CMFI Bilingual High School.
                </p>
            </AnimateOnScroll>
        </div>
      </section>

      <section id="contact" className="bg-background">
        <div className="container mx-auto px-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
            <AnimateOnScroll>
              <h2 className="font-headline text-3xl font-bold mb-6">Contact Information</h2>
              <div className="space-y-6">
                {contactDetails.map((detail, index) => {
                  const content = (
                    <div className="flex items-center gap-4 group">
                      <div className="p-3 bg-primary/10 rounded-full group-hover:bg-primary transition-colors">
                        <detail.icon className="h-6 w-6 text-primary group-hover:text-primary-foreground transition-colors" />
                      </div>
                      <span className="text-lg text-muted-foreground">{detail.text}</span>
                    </div>
                  );
                  if (detail.href) {
                    return <a key={`${uniqueId}-${index}`} href={detail.href} target="_blank" rel="noopener noreferrer" className="inline-block">{content}</a>
                  }
                  return <div key={`${uniqueId}-${index}`}>{content}</div>;
                })}
              </div>
               <div className="mt-8">
                 <h3 className="font-headline text-2xl font-bold mb-4">Find Us Here</h3>
                 <div className="rounded-lg overflow-hidden border">
                    <iframe 
                        src={embedMapsUrl}
                        width="100%" 
                        height="300" 
                        style={{ border: 0 }} 
                        allowFullScreen={true}
                        loading="lazy" 
                        referrerPolicy="no-referrer-when-downgrade"
                        title="Google Map of CMFI Campus"
                    ></iframe>
                 </div>
               </div>
            </AnimateOnScroll>

            <AnimateOnScroll delay={200}>
              <Card className="bg-card">
                 <CardHeader>
                    <CardTitle className="font-headline text-3xl">Send Us a Message</CardTitle>
                </CardHeader>
                <CardContent>
                  <Form {...form}>
                    <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-6">
                      <FormField
                        control={form.control}
                        name="name"
                        render={({ field }) => (
                          <FormItem>
                            <FormLabel>Full Name</FormLabel>
                            <FormControl>
                              <Input placeholder="John Doe" {...field} />
                            </FormControl>
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormField
                        control={form.control}
                        name="email"
                        render={({ field }) => (
                          <FormItem>
                            <FormLabel>Email Address</FormLabel>
                            <FormControl>
                              <Input placeholder="john.doe@example.com" {...field} />
                            </FormControl>
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormField
                        control={form.control}
                        name="subject"
                        render={({ field }) => (
                          <FormItem>
                            <FormLabel>Subject</FormLabel>
                            <FormControl>
                              <Input placeholder="Admission Inquiry" {...field} />
                            </FormControl>
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                      <FormField
                        control={form.control}
                        name="message"
                        render={({ field }) => (
                          <FormItem>
                            <FormLabel>Message</FormLabel>
                            <FormControl>
                              <Textarea placeholder="Your message..." {...field} rows={5} />
                            </FormControl>
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                       <Button type="submit" disabled={isPending} className="w-full bg-accent hover:bg-accent/90">
                            {isPending ? <Loader2 className="mr-2 h-4 w-4 animate-spin" /> : null}
                            Send Message
                        </Button>
                    </form>
                  </Form>
                </CardContent>
              </Card>
              
               <div className="mt-8">
                <h3 className="font-headline text-2xl font-bold mb-4">Stay Connected Online</h3>
                <div className="flex space-x-4">
                  {socialLinks.map((social) => (
                    <Link
                      key={social.name}
                      href={social.href}
                      aria-label={social.name}
                      className="text-muted-foreground hover:text-primary transition-colors"
                    >
                      <social.icon className="h-7 w-7" />
                    </Link>
                  ))}
                </div>
              </div>

            </AnimateOnScroll>
          </div>
        </div>
      </section>
      
      <NewsSection />
    </>
  );
};

export default ContactPageContent;
