
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

const WhatsAppIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" className="h-7 w-7">
        <path d="M16.75 13.96c.25.13.41.2.46.3.05.1.03.48-.18.69a1.69 1.69 0 0 1-1.12.52c-.37.02-.74.02-1.12-.04-.51-.08-1.02-.3-1.5-.58-.81-.46-1.53-1.1-2.14-1.85-.59-.72-1.06-1.53-1.39-2.4-.21-.56-.25-1.09-.17-1.58.12-.6.38-1.08.83-1.4.14-.1.28-.2.43-.28.15-.08.3-.13.46-.13.23 0 .46.06.66.15.2.09.39.18.57.29.23.14.44.29.62.47.21.2.35.43.43.69.07.25.07.51.02.76-.05.25-.13.49-.24.71-.11.23-.24.44-.39.63l-.11.12c-.1.11-.18.22-.25.33-.07.11-.12.22-.12.33 0 .1.04.2.11.3.07.1.18.19.3.29s.25.18.4.26c.15.08.3.13.46.16.16.03.32.03.48 0 .12-.01.24-.04.36-.08.12-.04.23-.09.33-.15s.19-.11.27-.15.15-.07.21-.07.12 0 .19.01c.07.01.13.02.19.04.06.02.12.04.18.06.06.02.12.05.17.08s.1.06.14.1c.04.03.08.07.12.11l.07.07c.02.03.04.06.06.09.02.03.03.06.05.1s.03.05.04.08.02.06.02.09c0 .03-.01.06-.02.09s-.02.06-.04.08-.03.05-.05.07-.05.04-.08.05c-.03.02-.06.03-.1.04l-.06.02h-.02a1.44 1.44 0 0 1-.29.07c-.1.01-.19.02-.29.02-.12 0-.24-.01-.36-.04a1.8 1.8 0 0 1-.51-.21A3.4 3.4 0 0 1 15.09 15c-.42.33-.89.6-1.4.81-.5.21-1.02.35-1.57.43-.54.08-1.09.1-1.63.05-.6-.05-1.18-.2-1.7-.48a4.95 4.95 0 0 1-1.4-1.03c-.4-.4-.73-.85-1-1.34s-.46-1-.6-1.54c-.13-.56-.2-1.12-.18-1.68.02-.56.12-1.1.28-1.6.17-.5.4-.98.7-1.4.15-.2.32-.4.5-.58.35-.35.78-.6 1.28-.72.5-.12 1.01-.12 1.5.02.49.14.95.38 1.35.7.1.08.18.17.25.26a.5.5 0 0 1 .1.13c.03.05.06.1.08.16.02.06.04.12.05.18.01.06.02.12.02.19z" />
        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zM1.02 12a11 11 0 0 1 11-11 11 11 0 0 1 11 11 11 11 0 0 1-11 11A11 11 0 0 1 1.02 12z" />
    </svg>
);

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
    { icon: Phone, text: '+231770732334', href: 'tel:+231770732334' },
    { icon: Mail, text: 'info@cmfischool.online' },
    { icon: Clock, text: 'Mon-Fri, 8:00 AM - 4:00 PM' },
  ];

  const socialLinks = [
    { name: 'Facebook', icon: Facebook, href: 'https://www.facebook.com/cmfibilingualhighschool/' },
    { name: 'Instagram', icon: Instagram, href: 'https://www.instagram.com/cmfibilingualhigh/' },
    { name: 'WhatsApp', icon: WhatsAppIcon, href: 'https://wa.me/231770732334' },
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
                      target="_blank"
                      rel="noopener noreferrer"
                      aria-label={social.name}
                      className="text-muted-foreground hover:text-primary transition-colors"
                    >
                      <social.icon />
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
