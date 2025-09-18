
'use client';

import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Form, FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { useToast } from '@/hooks/use-toast';
import { Check, Download, Loader2 } from 'lucide-react';
import Image from 'next/image';
import { RadioGroup, RadioGroupItem } from '../ui/radio-group';
import { Checkbox } from '../ui/checkbox';
import FileUpload from '../file-upload';
import { useState, useTransition } from 'react';
import { CMFILogo } from '../icons';
import { submitAdmissionForm } from '@/lib/admission';
import Link from 'next/link';

const fileSchema = typeof window === 'undefined' 
  ? z.any()
  : z.instanceof(File).optional().nullable();

const admissionFormSchema = z.object({
  academyYear: z.string().min(4, "Invalid year."),
  
  studentFullName: z.string().min(2, "Full name is required."),
  gender: z.enum(["Male", "Female"], { required_error: "Gender is required." }),
  dobMonth: z.string().min(1, "Month is required."),
  dobDate: z.string().min(1, "Date is required."),
  dobYear: z.string().min(4, "Year is required."),
  religion: z.string().min(2, "Religion is required."),
  studentContact: z.string().optional(),
  studentAddress: z.string().min(5, "Address is required."),

  guardianFullName: z.string().min(2, "Guardian's name is required."),
  guardianRelationship: z.string().min(2, "Relationship is required."),
  
  motherFullName: z.string().optional(),
  motherOccupation: z.string().optional(),
  motherAlive: z.enum(["Yes", "No"]).optional(),
  motherMobile: z.string().optional(),
  motherAddress: z.string().optional(),

  fatherFullName: z.string().optional(),
  fatherOccupation: z.string().optional(),
  fatherAlive: z.enum(["Yes", "No"]).optional(),
  fatherMobile: z.string().optional(),
  fatherAddress: z.string().optional(),
  
  prevSchoolName: z.string().optional(),
  prevSchoolLocation: z.string().optional(),
  documentsBrought: z.object({
    transcript: z.boolean().default(false),
    recommendation: z.boolean().default(false),
    reportCard: z.boolean().default(false),
  }).optional(),
  gradeLevel: z.string().optional(),
  principalName: z.string().optional(),
  prevSchoolContact: z.string().optional(),

  transcriptFile: fileSchema,
  recommendationFile: fileSchema,
  reportCardFile: fileSchema,
  birthCertificateFile: fileSchema,
});

type AdmissionFormValues = z.infer<typeof admissionFormSchema>;

const AdmissionForm = () => {
  const { toast } = useToast();
  const [isPending, startTransition] = useTransition();
  const [isSubmitted, setIsSubmitted] = useState(false);

  const form = useForm<AdmissionFormValues>({
    resolver: zodResolver(admissionFormSchema),
    defaultValues: {
      academyYear: new Date().getFullYear().toString(),
      studentFullName: '',
      gender: undefined,
      dobMonth: '',
      dobDate: '',
      dobYear: '',
      religion: '',
      studentContact: '',
      studentAddress: '',
      guardianFullName: '',
      guardianRelationship: '',
      motherFullName: '',
      motherOccupation: '',
      motherAlive: undefined,
      motherMobile: '',
      motherAddress: '',
      fatherFullName: '',
      fatherOccupation: '',
      fatherAlive: undefined,
      fatherMobile: '',
      fatherAddress: '',
      prevSchoolName: '',
      prevSchoolLocation: '',
      documentsBrought: {
        transcript: false,
        recommendation: false,
        reportCard: false,
      },
      gradeLevel: '',
      principalName: '',
      prevSchoolContact: '',
      transcriptFile: null,
      recommendationFile: null,
      reportCardFile: null,
      birthCertificateFile: null,
    },
  });

  const onSubmit = (values: AdmissionFormValues) => {
    startTransition(async () => {
      const formData = new FormData();
      Object.entries(values).forEach(([key, value]) => {
        if (value instanceof File) {
          formData.append(key, value);
        } else if (typeof value === 'object' && value !== null && !(value instanceof File)) {
          formData.append(key, JSON.stringify(value));
        } else if (value !== undefined && value !== null) {
          formData.append(key, String(value));
        }
      });
      
      const result = await submitAdmissionForm(undefined, formData);

      if (result.message === 'success') {
        toast({
            title: 'Application Submitted!',
            description: 'Your form has been successfully submitted and sent to the administration.',
        });
        setIsSubmitted(true);
      } else {
        toast({
            variant: 'destructive',
            title: 'Submission Failed',
            description: result.message,
        });
      }
    });
  };

  if (isSubmitted) {
    return (
        <section className="bg-background">
            <div className="container mx-auto px-6 text-center py-20 md:py-32">
                <AnimateOnScroll>
                    <div className="mx-auto w-fit bg-green-100 p-4 rounded-full">
                        <Check className="h-12 w-12 text-green-600" />
                    </div>
                    <h1 className="font-headline text-3xl md:text-4xl font-bold mt-8">Application Submitted!</h1>
                    <p className="mt-4 text-lg max-w-2xl mx-auto text-muted-foreground">
                        Thank you for your interest in CMFI Bilingual High School. Your application has been received and sent to our admissions team for review. You will be contacted shortly.
                    </p>
                    <div className="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                        <Button asChild size="lg" variant="outline">
                            <Link href="/">Return to Homepage</Link>
                        </Button>
                    </div>
                </AnimateOnScroll>
            </div>
        </section>
    );
  }
  
  return (
    <>
      <section className="relative h-[300px] flex items-center justify-center text-center text-white">
        <Image
            src="/images/heroimages/admissionhero.jpeg"
            alt="Admissions at CMFI"
            fill
            priority
            sizes="100vw"
            className="object-cover"
            data-ai-hint="students smiling"
        />
        <div className="absolute inset-0 bg-black/60" />
        <div className="relative z-10 container mx-auto px-6">
            <AnimateOnScroll>
                <h1 className="font-headline text-4xl md:text-6xl font-bold tracking-tight">
                    Online Admission Form
                </h1>
                <p className="mt-4 text-lg md:text-xl text-white/90">
                    Please fill out the form below to begin your application process.
                </p>
            </AnimateOnScroll>
        </div>
      </section>
      
      <section className="bg-background relative overflow-hidden">
        <div className="absolute top-0 left-0 -translate-x-1/4 -translate-y-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl" />
        <div className="absolute bottom-0 right-0 translate-x-1/4 translate-y-1/4 w-96 h-96 bg-accent/10 rounded-full blur-3xl" />

        <div className="container mx-auto px-6 max-w-4xl relative">
           <div className="absolute inset-0 flex items-center justify-center pointer-events-none">
                <CMFILogo className="h-96 w-96 text-primary/5 opacity-50" />
           </div>
           <Form {...form}>
            <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-12 relative z-10">

            <Card className="bg-card/80 backdrop-blur-sm">
                <CardHeader>
                    <CardTitle>Academy Year</CardTitle>
                </CardHeader>
                <CardContent>
                    <FormField
                        control={form.control}
                        name="academyYear"
                        render={({ field }) => (
                          <FormItem>
                            <FormLabel>Academy Year</FormLabel>
                            <FormControl>
                              <Input placeholder="e.g., 2024" {...field} />
                            </FormControl>
                            <FormMessage />
                          </FormItem>
                        )}
                      />
                </CardContent>
            </Card>
            
            <Card className="bg-card/80 backdrop-blur-sm">
                <CardHeader>
                    <CardTitle>Student Details</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                    <FormField control={form.control} name="studentFullName" render={({ field }) => (<FormItem><FormLabel>Full Name</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                    <div className="grid md:grid-cols-2 gap-6">
                        <FormField control={form.control} name="gender" render={({ field }) => (<FormItem><FormLabel>Gender</FormLabel><FormControl><RadioGroup onValueChange={field.onChange} defaultValue={field.value} className="flex gap-4 items-center"><FormItem className="flex items-center space-x-2"><FormControl><RadioGroupItem value="Male" /></FormControl><FormLabel className="font-normal">Male</FormLabel></FormItem><FormItem className="flex items-center space-x-2"><FormControl><RadioGroupItem value="Female" /></FormControl><FormLabel className="font-normal">Female</FormLabel></FormItem></RadioGroup></FormControl><FormMessage /></FormItem>)} />
                        <FormField control={form.control} name="religion" render={({ field }) => (<FormItem><FormLabel>Religion</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                    </div>
                     <FormItem>
                        <FormLabel>Date of Birth</FormLabel>
                        <div className="grid grid-cols-3 gap-4">
                            <FormField control={form.control} name="dobMonth" render={({ field }) => (<FormItem><FormLabel className="text-xs text-muted-foreground">Month</FormLabel><FormControl><Input placeholder="Month" {...field} /></FormControl><FormMessage /></FormItem>)} />
                            <FormField control={form.control} name="dobDate" render={({ field }) => (<FormItem><FormLabel className="text-xs text-muted-foreground">Date</FormLabel><FormControl><Input placeholder="Date" {...field} /></FormControl><FormMessage /></FormItem>)} />
                            <FormField control={form.control} name="dobYear" render={({ field }) => (<FormItem><FormLabel className="text-xs text-muted-foreground">Year</FormLabel><FormControl><Input placeholder="Year" {...field} /></FormControl><FormMessage /></FormItem>)} />
                        </div>
                    </FormItem>
                    <FormField control={form.control} name="studentContact" render={({ field }) => (<FormItem><FormLabel>Contact #</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                    <FormField control={form.control} name="studentAddress" render={({ field }) => (<FormItem><FormLabel>Address</FormLabel><FormControl><Textarea {...field} /></FormControl><FormMessage /></FormItem>)} />
                </CardContent>
            </Card>

            <Card className="bg-card/80 backdrop-blur-sm">
                <CardHeader>
                    <CardTitle>Guardian Details</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div className="grid md:grid-cols-2 gap-6">
                        <FormField control={form.control} name="guardianFullName" render={({ field }) => (<FormItem><FormLabel>Guardian Full Name</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                        <FormField control={form.control} name="guardianRelationship" render={({ field }) => (<FormItem><FormLabel>Relationship</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                    </div>
                </CardContent>
            </Card>
            
            <Card className="bg-card/80 backdrop-blur-sm">
                <CardHeader>
                    <CardTitle>Parents Detail</CardTitle>
                </CardHeader>
                <CardContent className="space-y-8">
                    <div>
                        <h3 className="font-medium mb-4">Mother's Information</h3>
                        <div className="space-y-6">
                            <div className="grid md:grid-cols-2 gap-6">
                                <FormField control={form.control} name="motherFullName" render={({ field }) => (<FormItem><FormLabel>Mother's Full Name</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                                <FormField control={form.control} name="motherOccupation" render={({ field }) => (<FormItem><FormLabel>Occupation</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                            </div>
                             <FormField control={form.control} name="motherAlive" render={({ field }) => (<FormItem><FormLabel>Alive?</FormLabel><FormControl><RadioGroup onValueChange={field.onChange} defaultValue={field.value} className="flex items-center gap-4"><FormItem className="flex items-center space-x-2"><FormControl><RadioGroupItem value="Yes" /></FormControl><FormLabel className="font-normal">Yes</FormLabel></FormItem><FormItem className="flex items-center space-x-2"><FormControl><RadioGroupItem value="No" /></FormControl><FormLabel className="font-normal">No</FormLabel></FormItem></RadioGroup></FormControl><FormMessage /></FormItem>)} />
                            <div className="grid md:grid-cols-2 gap-6">
                                <FormField control={form.control} name="motherMobile" render={({ field }) => (<FormItem><FormLabel>Mobile N°</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                                <FormField control={form.control} name="motherAddress" render={({ field }) => (<FormItem><FormLabel>Address</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                            </div>
                        </div>
                    </div>
                    <div className="border-t pt-8">
                        <h3 className="font-medium mb-4">Father's Information</h3>
                         <div className="space-y-6">
                            <div className="grid md:grid-cols-2 gap-6">
                                <FormField control={form.control} name="fatherFullName" render={({ field }) => (<FormItem><FormLabel>Father's Full Name</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                                <FormField control={form.control} name="fatherOccupation" render={({ field }) => (<FormItem><FormLabel>Occupation</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                            </div>
                             <FormField control={form.control} name="fatherAlive" render={({ field }) => (<FormItem><FormLabel>Alive?</FormLabel><FormControl><RadioGroup onValueChange={field.onChange} defaultValue={field.value} className="flex items-center gap-4"><FormItem className="flex items-center space-x-2"><FormControl><RadioGroupItem value="Yes" /></FormControl><FormLabel className="font-normal">Yes</FormLabel></FormItem><FormItem className="flex items-center space-x-2"><FormControl><RadioGroupItem value="No" /></FormControl><FormLabel className="font-normal">No</FormLabel></FormItem></RadioGroup></FormControl><FormMessage /></FormItem>)} />
                            <div className="grid md:grid-cols-2 gap-6">
                                <FormField control={form.control} name="fatherMobile" render={({ field }) => (<FormItem><FormLabel>Mobile N°</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                                <FormField control={form.control} name="fatherAddress" render={({ field }) => (<FormItem><FormLabel>Address</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>

             <Card className="bg-card/80 backdrop-blur-sm">
                <CardHeader>
                    <CardTitle>Previous School Details (for New Students Only)</CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div className="grid md:grid-cols-2 gap-6">
                        <FormField control={form.control} name="prevSchoolName" render={({ field }) => (<FormItem><FormLabel>School Name</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                        <FormField control={form.control} name="prevSchoolLocation" render={({ field }) => (<FormItem><FormLabel>Location</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                    </div>
                    <FormField control={form.control} name="documentsBrought" render={() => (
                        <FormItem>
                            <div className="mb-4"><FormLabel>Documents Brought In</FormLabel></div>
                            <div className="flex flex-col md:flex-row gap-4">
                                <FormField control={form.control} name="documentsBrought.transcript" render={({ field }) => (<FormItem className="flex flex-row items-start space-x-3 space-y-0"><FormControl><Checkbox checked={field.value} onCheckedChange={field.onChange} /></FormControl><div className="space-y-1 leading-none"><FormLabel>Transcript</FormLabel></div></FormItem>)} />
                                <FormField control={form.control} name="documentsBrought.recommendation" render={({ field }) => (<FormItem className="flex flex-row items-start space-x-3 space-y-0"><FormControl><Checkbox checked={field.value} onCheckedChange={field.onChange} /></FormControl><div className="space-y-1 leading-none"><FormLabel>Recommendation</FormLabel></div></FormItem>)} />
                                <FormField control={form.control} name="documentsBrought.reportCard" render={({ field }) => (<FormItem className="flex flex-row items-start space-x-3 space-y-0"><FormControl><Checkbox checked={field.value} onCheckedChange={field.onChange} /></FormControl><div className="space-y-1 leading-none"><FormLabel>Report Card</FormLabel></div></FormItem>)} />
                            </div>
                            <FormMessage />
                        </FormItem>
                    )} />
                    <div className="grid md:grid-cols-2 gap-6">
                        <FormField control={form.control} name="gradeLevel" render={({ field }) => (<FormItem><FormLabel>Grade Level Applied For</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                        <FormField control={form.control} name="principalName" render={({ field }) => (<FormItem><FormLabel>Principal Name</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                    </div>
                     <FormField control={form.control} name="prevSchoolContact" render={({ field }) => (<FormItem><FormLabel>Contact</FormLabel><FormControl><Input {...field} /></FormControl><FormMessage /></FormItem>)} />
                </CardContent>
            </Card>

            <Card className="bg-card/80 backdrop-blur-sm">
                <CardHeader>
                    <CardTitle>Document Uploads</CardTitle>
                    <CardDescription>Please upload the required documents. Images (JPEG, PNG) or PDF files are accepted.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                   <div className="grid md:grid-cols-2 gap-6">
                        <FormField
                            control={form.control}
                            name="birthCertificateFile"
                            render={({ field }) => (
                                <FileUpload 
                                    label="Birth Certificate"
                                    value={field.value || null}
                                    onChange={field.onChange}
                                />
                            )}
                        />
                        <FormField
                            control={form.control}
                            name="reportCardFile"
                            render={({ field }) => (
                                <FileUpload 
                                    label="Most Recent Report Card"
                                    value={field.value || null}
                                    onChange={field.onChange}
                                />
                            )}
                        />
                         <FormField
                            control={form.control}
                            name="transcriptFile"
                            render={({ field }) => (
                                <FileUpload 
                                    label="Transcript (if available)"
                                    value={field.value || null}
                                    onChange={field.onChange}
                                />
                            )}
                        />
                         <FormField
                            control={form.control}
                            name="recommendationFile"
                            render={({ field }) => (
                                <FileUpload 
                                    label="Recommendation Letter (if available)"
                                    value={field.value || null}
                                    onChange={field.onChange}
                                />
                            )}
                        />
                   </div>
                </CardContent>
            </Card>
            
            <Button type="submit" disabled={isPending} className="w-full text-lg" size="lg">
                {isPending ? <Loader2 className="mr-2 h-6 w-6 animate-spin" /> : null}
                Review and Submit Application
            </Button>
            </form>
           </Form>
        </div>
      </section>
    </>
  );
};

export default AdmissionForm;
