'use client';

import { useState, useTransition } from 'react';
import { useForm } from 'react-hook-form';
import { submitTeacherApplication } from '@/lib/actions';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Progress } from '@/components/ui/progress';
import { useToast } from '@/hooks/use-toast';
import { Loader2, ArrowRight, ArrowLeft, CheckCircle2, User, BookOpen, Briefcase, GraduationCap, ClipboardList, CheckSquare, Users, Sparkles, Send } from 'lucide-react';
import Image from 'next/image';

const steps = [
  { id: 1, name: 'Personal', icon: User },
  { id: 2, name: 'Position', icon: Briefcase },
  { id: 3, name: 'Education', icon: GraduationCap },
  { id: 4, name: 'Experience', icon: BookOpen },
  { id: 5, name: 'Reapplication', icon: Sparkles, conditional: true },
  { id: 6, name: 'Skills & Conduct', icon: CheckSquare },
  { id: 7, name: 'References & Availability', icon: Users },
  { id: 8, name: 'Review', icon: ClipboardList },
];

export default function TeacherApplicationPage() {
  const { toast } = useToast();
  const [currentStep, setCurrentStep] = useState(1);
  const [isPending, startTransition] = useTransition();
  const [isSubmitted, setIsSubmitted] = useState(false);

  // Form State
  const [formDataState, setFormDataState] = useState<{ [key: string]: any }>({
    fullName: '', gender: '', dob: '', nationality: '', cityOfResidence: '',
    mobileNumber: '', whatsAppNumber: '', email: '', homeAddress: '',
    emergencyName: '', emergencyNumber: '',
    applicantType: '', positionApplyingFor: '', otherPosition: '', subjectsCanTeach: '', gradesPreferred: '',
    highestQualification: '', institution: '', graduationYear: '', major: '', certifications: '',
    yearsExperience: '', previousSchool: '', prevPosition: '', prevSubjects: '', prevPeriod: '',
    newAppEmployer1: '', newAppEmployer2: '',
    currentDept: '', yearsServed: '', achievements: '', challenges: '', whyContinue: '',
    classroomManagement: 'Intermediate', lessonPlanning: 'Intermediate', studentAssessment: 'Intermediate',
    computerSkills: 'Intermediate', msWord: 'Intermediate', msExcel: 'Intermediate',
    googleWorkspace: 'Intermediate', onlinePlatforms: 'Intermediate',
    dismissed: 'No', convicted: 'No', abidePolicies: 'Yes',
    ref1Name: '', ref1Position: '', ref1Org: '', ref1Phone: '', ref1Email: '',
    ref2Name: '', ref2Position: '', ref2Org: '', ref2Phone: '', ref2Email: '',
    startDate: '', commitmentType: 'Full-Time', otherCommitments: '',
    personalStatement: '', declarationSigned: false
  });

  // Track file inputs in state to handle validation & review
  const [uploadedFiles, setUploadedFiles] = useState<{ [key: string]: File | null }>({
    cv: null,
    academicCertificate: null,
    transcript: null,
    professionalCertificate: null,
    idCard: null,
    photo: null,
    policeClearance: null,
    recommendationLetter: null,
  });

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value, type } = e.target;
    if (type === 'checkbox') {
      const checked = (e.target as HTMLInputElement).checked;
      setFormDataState((prev) => ({ ...prev, [name]: checked }));
    } else {
      setFormDataState((prev) => ({ ...prev, [name]: value }));
    }
  };

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, files } = e.target;
    if (files && files[0]) {
      setUploadedFiles((prev) => ({ ...prev, [name]: files[0] }));
    }
  };

  // Determine active steps (filter out Step 5 if not reapplying)
  const isReapplying = formDataState.applicantType === 'Current Teacher (Reapplying)';
  const activeSteps = steps.filter(step => !step.conditional || isReapplying);

  // Stepper tracking helpers
  const getActiveStepIndex = (stepId: number) => activeSteps.findIndex(s => s.id === stepId) + 1;
  const totalActiveSteps = activeSteps.length;
  const progressPercent = (getActiveStepIndex(currentStep) / totalActiveSteps) * 100;

  // Step validation
  const validateCurrentStep = () => {
    if (currentStep === 1) {
      if (!formDataState.fullName || !formDataState.email || !formDataState.mobileNumber || !formDataState.cityOfResidence) {
        toast({ variant: 'destructive', title: 'Missing Information', description: 'Please complete all required fields.' });
        return false;
      }
    }
    if (currentStep === 2) {
      if (!formDataState.applicantType || !formDataState.positionApplyingFor) {
        toast({ variant: 'destructive', title: 'Missing Information', description: 'Please select applicant type and position.' });
        return false;
      }
    }
    if (currentStep === 3) {
      if (!formDataState.highestQualification || !formDataState.institution || !formDataState.graduationYear) {
        toast({ variant: 'destructive', title: 'Missing Information', description: 'Please fill in highest qualification details.' });
        return false;
      }
      if (!uploadedFiles.cv) {
        toast({ variant: 'destructive', title: 'Required Uploads', description: 'Please upload your CV/Resume.' });
        return false;
      }
    }
    if (currentStep === 4) {
      if (!formDataState.yearsExperience) {
        toast({ variant: 'destructive', title: 'Missing Information', description: 'Please fill in your years of teaching experience.' });
        return false;
      }
    }
    if (currentStep === 5 && isReapplying) {
      if (!formDataState.currentDept || !formDataState.yearsServed) {
        toast({ variant: 'destructive', title: 'Missing Information', description: 'Please fill in your reapplication details.' });
        return false;
      }
    }
    if (currentStep === 7) {
      if (!formDataState.ref1Name || !formDataState.ref1Phone || !formDataState.ref2Name || !formDataState.ref2Phone) {
        toast({ variant: 'destructive', title: 'Missing References', description: 'Please provide details for both references.' });
        return false;
      }
      if (!formDataState.startDate) {
        toast({ variant: 'destructive', title: 'Missing Start Date', description: 'Please specify your available start date.' });
        return false;
      }
    }
    if (currentStep === 8) {
      if (!formDataState.declarationSigned) {
        toast({ variant: 'destructive', title: 'Declaration Required', description: 'You must check the declaration box to submit.' });
        return false;
      }
    }
    return true;
  };

  const handleNext = () => {
    if (!validateCurrentStep()) return;
    
    const currentIndex = activeSteps.findIndex(s => s.id === currentStep);
    if (currentIndex < activeSteps.length - 1) {
      setCurrentStep(activeSteps[currentIndex + 1].id);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  };

  const handleBack = () => {
    const currentIndex = activeSteps.findIndex(s => s.id === currentStep);
    if (currentIndex > 0) {
      setCurrentStep(activeSteps[currentIndex - 1].id);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  };

  const handleSubmitForm = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!validateCurrentStep()) return;

    const submitData = new FormData();
    // Append text fields
    Object.entries(formDataState).forEach(([key, value]) => {
      submitData.append(key, String(value));
    });
    // Append files
    Object.entries(uploadedFiles).forEach(([key, file]) => {
      if (file) {
        submitData.append(key, file);
      }
    });

    startTransition(async () => {
      const result = await submitTeacherApplication(undefined, submitData);
      if (result.message === 'success') {
        setIsSubmitted(true);
        toast({
          title: 'Application Submitted!',
          description: 'Thank you for applying to CMFI. Check your email for further instructions.',
        });
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
      <div className="container mx-auto px-6 py-20 flex items-center justify-center min-h-[70vh]">
        <Card className="max-w-xl w-full text-center p-8 bg-card border-primary/20 shadow-2xl">
          <div className="flex justify-center mb-6">
            <CheckCircle2 className="h-20 w-20 text-emerald-500 animate-bounce" />
          </div>
          <CardHeader className="p-0">
            <CardTitle className="font-headline text-3xl font-bold text-primary">Application Received!</CardTitle>
            <CardDescription className="text-lg mt-2">
              Thank you, <span className="font-semibold">{formDataState.fullName}</span>, for applying for the 2026/2027 Academic Year.
            </CardDescription>
          </CardHeader>
          <CardContent className="mt-6 space-y-6">
            <p className="text-muted-foreground">
              A detailed confirmation email has been sent to <span className="font-semibold">{formDataState.email}</span>. Please check your inbox and spam folder.
            </p>
            <div className="bg-primary/5 border border-primary/10 rounded-lg p-6 text-left">
              <h4 className="font-bold text-lg text-primary flex items-center gap-2 mb-2">
                <span>Connect With Admissions Board</span>
              </h4>
              <p className="text-sm text-muted-foreground mb-4">
                To ask questions, fast-track your profile review, or connect directly with our hiring coordinators, please tap the WhatsApp button below.
              </p>
              <Button asChild className="w-full bg-[#25D366] hover:bg-[#20ba5a] text-white py-6 text-lg font-bold gap-2">
                <a href="https://wa.me/YOUR_PLACEHOLDER_NUMBER" target="_blank" rel="noopener noreferrer">
                  Chat on WhatsApp
                </a>
              </Button>
            </div>
            <Button variant="outline" className="w-full mt-4" onClick={() => window.location.href = '/'}>
              Return to Homepage
            </Button>
          </CardContent>
        </Card>
      </div>
    );
  }

  return (
    <>
      <section className="relative h-[250px] flex items-center justify-center text-center text-white">
        <Image
          src="/images/heroimages/admissionhero.jpeg"
          alt="Staff collaboration"
          fill
          priority
          sizes="100vw"
          className="object-cover object-top blur-[1px]"
        />
        <div className="absolute inset-0 bg-primary/60" />
        <div className="relative z-10 container mx-auto px-6">
          <h1 className="font-headline text-3xl md:text-5xl font-bold tracking-tight">
            Teacher Application & Reapplication
          </h1>
          <p className="mt-2 text-md md:text-lg text-white/90">
            Join the educational faculty of CMFI Bilingual High School - Academic Year 2026/2027
          </p>
        </div>
      </section>

      <section className="bg-background py-10 md:py-16">
        <div className="container mx-auto px-6 max-w-4xl">
          {/* Stepper Progress Bar */}
          <div className="mb-10">
            <div className="flex justify-between items-center mb-4">
              <span className="text-sm font-semibold text-primary">Step {getActiveStepIndex(currentStep)} of {totalActiveSteps}</span>
              <span className="text-sm text-muted-foreground">{steps.find(s => s.id === currentStep)?.name}</span>
            </div>
            <Progress value={progressPercent} className="h-2" />
            
            {/* Visual Stepper Icons */}
            <div className="hidden md:flex justify-between mt-8 relative">
              <div className="absolute top-1/2 left-0 right-0 h-[2px] bg-muted -translate-y-1/2 z-0" />
              {activeSteps.map((step) => {
                const StepIcon = step.icon;
                const isActive = step.id === currentStep;
                const isCompleted = getActiveStepIndex(step.id) < getActiveStepIndex(currentStep);
                return (
                  <div
                    key={step.id}
                    className="flex flex-col items-center z-10 relative bg-background px-2"
                  >
                    <div
                      className={`h-10 w-10 rounded-full flex items-center justify-center transition-all ${
                        isActive
                          ? 'bg-primary text-white scale-110 shadow-lg'
                          : isCompleted
                          ? 'bg-emerald-500 text-white'
                          : 'bg-muted text-muted-foreground'
                      }`}
                    >
                      <StepIcon className="h-5 w-5" />
                    </div>
                    <span className={`text-xs mt-2 font-medium ${isActive ? 'text-primary' : 'text-muted-foreground'}`}>
                      {step.name}
                    </span>
                  </div>
                );
              })}
            </div>
          </div>

          <form onSubmit={handleSubmitForm}>
            {/* Step 1: Personal Info */}
            {currentStep === 1 && (
              <Card>
                <CardHeader>
                  <CardTitle className="font-headline text-2xl">Section 1: Personal Information</CardTitle>
                  <CardDescription>Tell us about yourself and how to contact you.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Full Name <span className="text-red-500">*</span></label>
                      <Input name="fullName" value={formDataState.fullName} onChange={handleInputChange} placeholder="First, Middle, Last Name" required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Gender <span className="text-red-500">*</span></label>
                      <select name="gender" value={formDataState.gender} onChange={handleInputChange} className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Date of Birth <span className="text-red-500">*</span></label>
                      <Input type="date" name="dob" value={formDataState.dob} onChange={handleInputChange} required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Nationality <span className="text-red-500">*</span></label>
                      <Input name="nationality" value={formDataState.nationality} onChange={handleInputChange} placeholder="Liberian" required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">County/City of Residence <span className="text-red-500">*</span></label>
                      <Input name="cityOfResidence" value={formDataState.cityOfResidence} onChange={handleInputChange} placeholder="Paynesville, Montserrado" required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Mobile Number <span className="text-red-500">*</span></label>
                      <Input type="tel" name="mobileNumber" value={formDataState.mobileNumber} onChange={handleInputChange} placeholder="+231..." required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">WhatsApp Number</label>
                      <Input type="tel" name="whatsAppNumber" value={formDataState.whatsAppNumber} onChange={handleInputChange} placeholder="+231..." />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Email Address <span className="text-red-500">*</span></label>
                      <Input type="email" name="email" value={formDataState.email} onChange={handleInputChange} placeholder="example@mail.com" required />
                    </div>
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-semibold">Home Address <span className="text-red-500">*</span></label>
                    <Input name="homeAddress" value={formDataState.homeAddress} onChange={handleInputChange} placeholder="Neighborhood / Community Address" required />
                  </div>
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t">
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Emergency Contact Name <span className="text-red-500">*</span></label>
                      <Input name="emergencyName" value={formDataState.emergencyName} onChange={handleInputChange} placeholder="Contact Person's Name" required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Emergency Contact Number <span className="text-red-500">*</span></label>
                      <Input type="tel" name="emergencyNumber" value={formDataState.emergencyNumber} onChange={handleInputChange} placeholder="Phone Number" required />
                    </div>
                  </div>
                </CardContent>
              </Card>
            )}

            {/* Step 2: Position Information */}
            {currentStep === 2 && (
              <Card>
                <CardHeader>
                  <CardTitle className="font-headline text-2xl">Section 2: Position Information</CardTitle>
                  <CardDescription>Select the position and preferences for your teaching service.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Are you applying as: <span className="text-red-500">*</span></label>
                      <select name="applicantType" value={formDataState.applicantType} onChange={handleInputChange} className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                        <option value="">Choose Application Type</option>
                        <option value="New Applicant">New Applicant</option>
                        <option value="Current Teacher (Reapplying)">Current Teacher (Reapplying)</option>
                      </select>
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Position Applying For: <span className="text-red-500">*</span></label>
                      <select name="positionApplyingFor" value={formDataState.positionApplyingFor} onChange={handleInputChange} className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                        <option value="">Choose Position</option>
                        <option value="Nursery Teacher">Nursery Teacher</option>
                        <option value="Elementary Teacher">Elementary Teacher</option>
                        <option value="Junior High Teacher">Junior High Teacher</option>
                        <option value="Senior High Teacher">Senior High Teacher</option>
                        <option value="Subject Specialist">Subject Specialist</option>
                        <option value="Other">Other</option>
                      </select>
                    </div>
                  </div>
                  {formDataState.positionApplyingFor === 'Other' && (
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Please Specify Position:</label>
                      <Input name="otherPosition" value={formDataState.otherPosition} onChange={handleInputChange} placeholder="E.g. Vice Principal, Lab Assistant" />
                    </div>
                  )}
                  <div className="space-y-2">
                    <label className="text-sm font-semibold">Subject(s) You Can Teach</label>
                    <Input name="subjectsCanTeach" value={formDataState.subjectsCanTeach} onChange={handleInputChange} placeholder="E.g. Mathematics, French, Physics" />
                    <p className="text-xs text-muted-foreground">List subjects separated by commas.</p>
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-semibold">Grade Level(s) Preferred</label>
                    <Input name="gradesPreferred" value={formDataState.gradesPreferred} onChange={handleInputChange} placeholder="E.g. Grades 7-9, Nursery II" />
                  </div>
                </CardContent>
              </Card>
            )}

            {/* Step 3: Educational Background & Document Upload */}
            {currentStep === 3 && (
              <Card>
                <CardHeader>
                  <CardTitle className="font-headline text-2xl">Section 3: Education & Documents</CardTitle>
                  <CardDescription>Provide your educational credentials and upload supporting files.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Highest Qualification Obtained <span className="text-red-500">*</span></label>
                      <select name="highestQualification" value={formDataState.highestQualification} onChange={handleInputChange} className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                        <option value="">Choose Qualification</option>
                        <option value="High School Graduate">High School Graduate</option>
                        <option value="Associate Degree">Associate Degree</option>
                        <option value="Bachelor's Degree">Bachelor's Degree</option>
                        <option value="Master's Degree">Master's Degree</option>
                        <option value="Doctorate">Doctorate</option>
                      </select>
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Institution Attended <span className="text-red-500">*</span></label>
                      <Input name="institution" value={formDataState.institution} onChange={handleInputChange} placeholder="University / College Name" required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Graduation Year <span className="text-red-500">*</span></label>
                      <Input type="number" name="graduationYear" value={formDataState.graduationYear} onChange={handleInputChange} placeholder="YYYY" required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Major / Area of Study</label>
                      <Input name="major" value={formDataState.major} onChange={handleInputChange} placeholder="E.g. Chemistry, Primary Education" />
                    </div>
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-semibold">Professional Certifications</label>
                    <Input name="certifications" value={formDataState.certifications} onChange={handleInputChange} placeholder="E.g. WAEC Teacher Certificate" />
                  </div>

                  <div className="pt-6 border-t space-y-4">
                    <h3 className="font-headline text-lg font-bold">Document Uploads</h3>
                    <p className="text-xs text-muted-foreground mb-4">Please upload copies of the required documents. Max size: 2MB per file. Formats accepted: PDF, JPG, PNG.</p>
                    
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div className="space-y-2">
                        <label className="text-sm font-semibold block">CV / Resume <span className="text-red-500">*</span></label>
                        <Input type="file" name="cv" accept=".pdf,.doc,.docx" onChange={handleFileChange} required />
                        {uploadedFiles.cv && <span className="text-xs text-emerald-600 font-semibold">Attached: {uploadedFiles.cv.name}</span>}
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold block">Academic Certificates</label>
                        <Input type="file" name="academicCertificate" accept=".pdf,.jpg,.jpeg,.png" onChange={handleFileChange} />
                        {uploadedFiles.academicCertificate && <span className="text-xs text-emerald-600 font-semibold">Attached: {uploadedFiles.academicCertificate.name}</span>}
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold block">Transcripts</label>
                        <Input type="file" name="transcript" accept=".pdf,.jpg,.jpeg,.png" onChange={handleFileChange} />
                        {uploadedFiles.transcript && <span className="text-xs text-emerald-600 font-semibold">Attached: {uploadedFiles.transcript.name}</span>}
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold block">Professional Certifications</label>
                        <Input type="file" name="professionalCertificate" accept=".pdf,.jpg,.jpeg,.png" onChange={handleFileChange} />
                        {uploadedFiles.professionalCertificate && <span className="text-xs text-emerald-600 font-semibold">Attached: {uploadedFiles.professionalCertificate.name}</span>}
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold block">Identification Card (National ID/Passport)</label>
                        <Input type="file" name="idCard" accept=".pdf,.jpg,.jpeg,.png" onChange={handleFileChange} />
                        {uploadedFiles.idCard && <span className="text-xs text-emerald-600 font-semibold">Attached: {uploadedFiles.idCard.name}</span>}
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold block">Passport-size Photo</label>
                        <Input type="file" name="photo" accept=".jpg,.jpeg,.png" onChange={handleFileChange} />
                        {uploadedFiles.photo && <span className="text-xs text-emerald-600 font-semibold">Attached: {uploadedFiles.photo.name}</span>}
                      </div>
                    </div>
                  </div>
                </CardContent>
              </Card>
            )}

            {/* Step 4: Teaching Experience */}
            {currentStep === 4 && (
              <Card>
                <CardHeader>
                  <CardTitle className="font-headline text-2xl">Section 4: Teaching Experience</CardTitle>
                  <CardDescription>Tell us about your teaching history.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Total Years of Teaching Experience <span className="text-red-500">*</span></label>
                      <Input type="number" name="yearsExperience" value={formDataState.yearsExperience} onChange={handleInputChange} min="0" required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Current or Previous School</label>
                      <Input name="previousSchool" value={formDataState.previousSchool} onChange={handleInputChange} placeholder="Name of school" />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Position Held</label>
                      <Input name="prevPosition" value={formDataState.prevPosition} onChange={handleInputChange} placeholder="E.g. Elementary Teacher" />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Subjects Taught</label>
                      <Input name="prevSubjects" value={formDataState.prevSubjects} onChange={handleInputChange} placeholder="E.g. Social Studies, English" />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Employment Period</label>
                      <Input name="prevPeriod" value={formDataState.prevPeriod} onChange={handleInputChange} placeholder="E.g. Sept 2022 - June 2024" />
                    </div>
                  </div>

                  {formDataState.applicantType === 'New Applicant' && (
                    <div className="pt-6 border-t space-y-4">
                      <h3 className="font-headline text-lg font-bold">New Applicant: Prior School Details</h3>
                      <p className="text-xs text-muted-foreground mb-4">Please provide details of your last two employers.</p>
                      <div className="space-y-4">
                        <div className="space-y-2">
                          <label className="text-sm font-semibold">Prior Employer 1</label>
                          <Input name="newAppEmployer1" value={formDataState.newAppEmployer1} onChange={handleInputChange} placeholder="School Name, Position, Supervisor Contact" />
                        </div>
                        <div className="space-y-2">
                          <label className="text-sm font-semibold">Prior Employer 2</label>
                          <Input name="newAppEmployer2" value={formDataState.newAppEmployer2} onChange={handleInputChange} placeholder="School Name, Position, Supervisor Contact" />
                        </div>
                      </div>
                    </div>
                  )}
                </CardContent>
              </Card>
            )}

            {/* Step 5: Current Teacher Reapplication Info (Conditional) */}
            {currentStep === 5 && isReapplying && (
              <Card>
                <CardHeader>
                  <CardTitle className="font-headline text-2xl">Section 5: Reapplication Information</CardTitle>
                  <CardDescription>Tell us about your history and achievements at CMFI.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Department or Grade Currently Assigned <span className="text-red-500">*</span></label>
                      <Input name="currentDept" value={formDataState.currentDept} onChange={handleInputChange} placeholder="E.g. Elementary / Junior High Science" required />
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Years Served at CMFI School <span className="text-red-500">*</span></label>
                      <Input type="number" name="yearsServed" value={formDataState.yearsServed} onChange={handleInputChange} min="0" required />
                    </div>
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-semibold">Major Achievements During Your Service</label>
                    <Textarea name="achievements" value={formDataState.achievements} onChange={handleInputChange} placeholder="Describe any achievements or milestones..." />
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-semibold">Challenges Faced During the Previous Academic Year</label>
                    <Textarea name="challenges" value={formDataState.challenges} onChange={handleInputChange} placeholder="Describe any challenges faced..." />
                  </div>
                  <div className="space-y-2">
                    <label className="text-sm font-semibold">Why would you like to continue teaching at CMFI?</label>
                    <Textarea name="whyContinue" value={formDataState.whyContinue} onChange={handleInputChange} placeholder="Describe your motivations..." />
                  </div>
                </CardContent>
              </Card>
            )}

            {/* Step 6: Skills & Conduct */}
            {currentStep === 6 && (
              <Card>
                <CardHeader>
                  <CardTitle className="font-headline text-2xl">Section 6 & 7: Skills & Conduct</CardTitle>
                  <CardDescription>Indicate your proficiency levels and professional history.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="space-y-4">
                    <h3 className="font-headline text-lg font-bold">Skills Proficiency Check</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      {[
                        { name: 'classroomManagement', label: 'Classroom Management' },
                        { name: 'lessonPlanning', label: 'Lesson Planning' },
                        { name: 'studentAssessment', label: 'Student Assessment' },
                        { name: 'computerSkills', label: 'Computer Skills' },
                        { name: 'msWord', label: 'Microsoft Word' },
                        { name: 'msExcel', label: 'Microsoft Excel' },
                        { name: 'googleWorkspace', label: 'Google Workspace' },
                        { name: 'onlinePlatforms', label: 'Online Teaching Platforms' },
                      ].map((skill) => (
                        <div key={skill.name} className="space-y-2">
                          <label className="text-sm font-semibold">{skill.label}</label>
                          <select name={skill.name} value={formDataState[skill.name]} onChange={handleInputChange} className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                          </select>
                        </div>
                      ))}
                    </div>
                  </div>

                  <div className="pt-6 border-t space-y-6">
                    <h3 className="font-headline text-lg font-bold">Character & Conduct</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Have you ever been dismissed from a previous job? <span className="text-red-500">*</span></label>
                        <select name="dismissed" value={formDataState.dismissed} onChange={handleInputChange} className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                          <option value="No">No</option>
                          <option value="Yes">Yes</option>
                        </select>
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Have you ever been convicted of a criminal offense? <span className="text-red-500">*</span></label>
                        <select name="convicted" value={formDataState.convicted} onChange={handleInputChange} className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                          <option value="No">No</option>
                          <option value="Yes">Yes</option>
                        </select>
                      </div>
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Are you willing to abide by all school policies and regulations? <span className="text-red-500">*</span></label>
                      <select name="abidePolicies" value={formDataState.abidePolicies} onChange={handleInputChange} className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                        <option value="Yes">Yes, absolutely</option>
                        <option value="No">No</option>
                      </select>
                    </div>
                  </div>
                </CardContent>
              </Card>
            )}

            {/* Step 7: References & Availability */}
            {currentStep === 7 && (
              <Card>
                <CardHeader>
                  <CardTitle className="font-headline text-2xl">Section 8 & 9: References & Availability</CardTitle>
                  <CardDescription>Provide professional references and scheduling availability.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="space-y-4">
                    <h3 className="font-headline text-lg font-bold">Reference 1</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Full Name <span className="text-red-500">*</span></label>
                        <Input name="ref1Name" value={formDataState.ref1Name} onChange={handleInputChange} required />
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Position <span className="text-red-500">*</span></label>
                        <Input name="ref1Position" value={formDataState.ref1Position} onChange={handleInputChange} required />
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Organization <span className="text-red-500">*</span></label>
                        <Input name="ref1Org" value={formDataState.ref1Org} onChange={handleInputChange} required />
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Phone Number <span className="text-red-500">*</span></label>
                        <Input type="tel" name="ref1Phone" value={formDataState.ref1Phone} onChange={handleInputChange} required />
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Email Address</label>
                        <Input type="email" name="ref1Email" value={formDataState.ref1Email} onChange={handleInputChange} />
                      </div>
                    </div>
                  </div>

                  <div className="pt-6 border-t space-y-4">
                    <h3 className="font-headline text-lg font-bold">Reference 2</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Full Name <span className="text-red-500">*</span></label>
                        <Input name="ref2Name" value={formDataState.ref2Name} onChange={handleInputChange} required />
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Position <span className="text-red-500">*</span></label>
                        <Input name="ref2Position" value={formDataState.ref2Position} onChange={handleInputChange} required />
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Organization <span className="text-red-500">*</span></label>
                        <Input name="ref2Org" value={formDataState.ref2Org} onChange={handleInputChange} required />
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Phone Number <span className="text-red-500">*</span></label>
                        <Input type="tel" name="ref2Phone" value={formDataState.ref2Phone} onChange={handleInputChange} required />
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Email Address</label>
                        <Input type="email" name="ref2Email" value={formDataState.ref2Email} onChange={handleInputChange} />
                      </div>
                    </div>
                  </div>

                  <div className="pt-6 border-t space-y-4">
                    <h3 className="font-headline text-lg font-bold">Availability</h3>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Available to Start On <span className="text-red-500">*</span></label>
                        <Input type="date" name="startDate" value={formDataState.startDate} onChange={handleInputChange} required />
                      </div>
                      <div className="space-y-2">
                        <label className="text-sm font-semibold">Full-Time or Part-Time? <span className="text-red-500">*</span></label>
                        <select name="commitmentType" value={formDataState.commitmentType} onChange={handleInputChange} className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" required>
                          <option value="Full-Time">Full-Time</option>
                          <option value="Part-Time">Part-Time</option>
                        </select>
                      </div>
                    </div>
                    <div className="space-y-2">
                      <label className="text-sm font-semibold">Any other commitments that may affect your teaching schedule?</label>
                      <Input name="otherCommitments" value={formDataState.otherCommitments} onChange={handleInputChange} placeholder="E.g. university classes, other part-time jobs" />
                    </div>
                  </div>
                </CardContent>
              </Card>
            )}

            {/* Step 8: Review & Submit */}
            {currentStep === 8 && (
              <Card>
                <CardHeader>
                  <CardTitle className="font-headline text-2xl">Section 10 & 11: Review & Submit</CardTitle>
                  <CardDescription>Please write your personal statement, review your details, and declare truthfulness.</CardDescription>
                </CardHeader>
                <CardContent className="space-y-6">
                  <div className="space-y-2">
                    <label className="text-sm font-semibold">Personal Statement (200 - 500 words) <span className="text-red-500">*</span></label>
                    <Textarea
                      name="personalStatement"
                      value={formDataState.personalStatement}
                      onChange={handleInputChange}
                      placeholder="Explain: 1. Why you want to teach at CMFI. 2. What value you bring to students. 3. Your teaching philosophy."
                      className="min-h-[200px]"
                      required
                    />
                    <p className="text-xs text-muted-foreground">Word Count: {formDataState.personalStatement.trim() ? formDataState.personalStatement.trim().split(/\s+/).length : 0} words.</p>
                  </div>

                  <div className="p-4 bg-muted rounded-md space-y-4">
                    <h3 className="font-headline text-md font-bold">Review Critical Information</h3>
                    <div className="text-sm grid grid-cols-2 gap-y-2">
                      <span className="text-muted-foreground">Full Name:</span>
                      <span className="font-semibold">{formDataState.fullName}</span>
                      <span className="text-muted-foreground">Position Applied For:</span>
                      <span className="font-semibold">{formDataState.positionApplyingFor}</span>
                      <span className="text-muted-foreground">Email:</span>
                      <span className="font-semibold">{formDataState.email}</span>
                      <span className="text-muted-foreground">Mobile Phone:</span>
                      <span className="font-semibold">{formDataState.mobileNumber}</span>
                      <span className="text-muted-foreground">Highest Qualification:</span>
                      <span className="font-semibold">{formDataState.highestQualification}</span>
                      <span className="text-muted-foreground">CV / Resume:</span>
                      <span className="font-semibold text-emerald-600">{uploadedFiles.cv ? uploadedFiles.cv.name : 'Missing!'}</span>
                    </div>
                  </div>

                  <div className="pt-6 border-t space-y-4">
                    <h3 className="font-headline text-lg font-bold">Declaration</h3>
                    <p className="text-sm italic text-muted-foreground">
                      "I hereby certify that the information provided in this application is true and complete to the best of my knowledge. I understand that any false information may result in the rejection of my application or termination of employment."
                    </p>
                    <div className="flex items-start gap-3 mt-4">
                      <input
                        type="checkbox"
                        id="declarationSigned"
                        name="declarationSigned"
                        checked={formDataState.declarationSigned}
                        onChange={handleInputChange}
                        className="mt-1 h-5 w-5 rounded border-muted-foreground"
                        required
                      />
                      <label htmlFor="declarationSigned" className="text-sm font-semibold select-none cursor-pointer">
                        I agree to the declaration statement above. <span className="text-red-500">*</span>
                      </label>
                    </div>
                  </div>
                </CardContent>
              </Card>
            )}

            {/* Wizard Navigation Footer */}
            <div className="mt-8 flex justify-between gap-4">
              {currentStep > 1 && (
                <Button type="button" variant="outline" onClick={handleBack} className="px-6 py-6 text-md font-semibold gap-2">
                  <ArrowLeft className="h-5 w-5" /> Back
                </Button>
              )}
              {currentStep < activeSteps[activeSteps.length - 1].id ? (
                <Button type="button" onClick={handleNext} className="ml-auto px-6 py-6 text-md font-semibold gap-2">
                  Next <ArrowRight className="h-5 w-5" />
                </Button>
              ) : (
                <Button type="submit" disabled={isPending} className="ml-auto px-8 py-6 bg-accent hover:bg-accent/90 text-accent-foreground text-md font-semibold gap-2">
                  {isPending ? (
                    <>
                      <Loader2 className="h-5 w-5 animate-spin" /> Submitting...
                    </>
                  ) : (
                    <>
                      Submit Application <Send className="h-5 w-5" />
                    </>
                  )}
                </Button>
              )}
            </div>
          </form>
        </div>
      </section>
    </>
  );
}
