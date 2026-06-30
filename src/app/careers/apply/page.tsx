'use client';

import { useState, useTransition } from 'react';
import { submitTeacherApplication } from '@/lib/actions';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import { Progress } from '@/components/ui/progress';
import { useToast } from '@/hooks/use-toast';
import { Loader2, ArrowRight, ArrowLeft, CheckCircle2, User, BookOpen, Briefcase, GraduationCap, ClipboardList, CheckSquare, Users, Sparkles, Send, Upload, FileText } from 'lucide-react';
import Link from 'next/link';
import { CMFILogo } from '@/components/icons';

const steps = [
  { id: 1, name: 'Personal Information', shortName: 'Personal', icon: User },
  { id: 2, name: 'Position & Preferences', shortName: 'Position', icon: Briefcase },
  { id: 3, name: 'Education & Credentials', shortName: 'Education', icon: GraduationCap },
  { id: 4, name: 'Teaching Experience', shortName: 'Experience', icon: BookOpen },
  { id: 5, name: 'CMFI Reapplication', shortName: 'Reapplication', icon: Sparkles, conditional: true },
  { id: 6, name: 'Skills & Conduct', shortName: 'Skills & Conduct', icon: CheckSquare },
  { id: 7, name: 'References & Availability', shortName: 'References', icon: Users },
  { id: 8, name: 'Review & Submit', shortName: 'Review', icon: ClipboardList },
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

  // Track file inputs in state
  const [uploadedFiles, setUploadedFiles] = useState<{ [key: string]: File | null }>({
    cv: null,
    academicCertificate: null,
    transcript: null,
    professionalCertificate: null,
    idCard: null,
    photo: null,
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
      const file = files[0];
      if (file.size > 2 * 1024 * 1024) {
        toast({ variant: 'destructive', title: 'File Too Large', description: 'Maximum file size is 2MB.' });
        return;
      }
      setUploadedFiles((prev) => ({ ...prev, [name]: file }));
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
      if (!formDataState.fullName || !formDataState.gender || !formDataState.dob || !formDataState.nationality || !formDataState.cityOfResidence || !formDataState.mobileNumber || !formDataState.email || !formDataState.homeAddress || !formDataState.emergencyName || !formDataState.emergencyNumber) {
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
        toast({ variant: 'destructive', title: 'Missing Information', description: 'Please fill in all required educational details.' });
        return false;
      }
      if (!uploadedFiles.cv) {
        toast({ variant: 'destructive', title: 'Required Uploads', description: 'Please upload your CV / Resume to continue.' });
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
      if (!formDataState.ref1Name || !formDataState.ref1Position || !formDataState.ref1Org || !formDataState.ref1Phone || !formDataState.ref2Name || !formDataState.ref2Position || !formDataState.ref2Org || !formDataState.ref2Phone) {
        toast({ variant: 'destructive', title: 'Missing References', description: 'Please provide complete details for both references.' });
        return false;
      }
      if (!formDataState.startDate) {
        toast({ variant: 'destructive', title: 'Missing Start Date', description: 'Please specify your available start date.' });
        return false;
      }
    }
    if (currentStep === 8) {
      if (!formDataState.personalStatement || formDataState.personalStatement.trim().split(/\s+/).length < 50) {
        toast({ variant: 'destructive', title: 'Personal Statement Short', description: 'Please provide a personal statement (minimum 50 words).' });
        return false;
      }
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

  const FileUploadField = ({ name, label, accept, required = false, file }: { name: string; label: string; accept: string; required?: boolean; file: File | null }) => (
    <div className="space-y-1">
      <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">
        {label} {required && <span className="text-red-500">*</span>}
      </label>
      <div className="relative border border-dashed border-slate-200 hover:border-slate-400 transition-colors rounded-lg bg-slate-50/55 p-4 flex flex-col items-center justify-center cursor-pointer group min-h-[90px]">
        <input
          type="file"
          name={name}
          accept={accept}
          onChange={handleFileChange}
          className="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
          required={required && !file}
        />
        <div className="text-center z-10 flex flex-col items-center">
          {file ? (
            <>
              <FileText className="h-5 w-5 text-emerald-500 mb-1" />
              <p className="text-xs font-semibold text-slate-700 truncate max-w-[220px]">{file.name}</p>
              <p className="text-[10px] text-slate-400">{(file.size / (1024 * 1024)).toFixed(2)} MB</p>
            </>
          ) : (
            <>
              <Upload className="h-5 w-5 text-slate-400 group-hover:text-slate-600 transition-colors mb-1" />
              <p className="text-xs font-medium text-slate-600 group-hover:text-slate-800 transition-colors">Choose file</p>
              <p className="text-[10px] text-slate-400">Max size 2MB (PDF/JPG/PNG)</p>
            </>
          )}
        </div>
      </div>
    </div>
  );

  const FormLabel = ({ children, required = false }: { children: React.ReactNode; required?: boolean }) => (
    <label className="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">
      {children} {required && <span className="text-red-500">*</span>}
    </label>
  );

  const inputClass = "w-full rounded-lg border border-slate-200 bg-slate-50/30 px-4 py-2.5 text-sm transition-all focus:bg-white focus:border-slate-800 focus:ring-0 focus-visible:ring-0 focus-visible:ring-offset-0 focus-visible:outline-none";

  if (isSubmitted) {
    return (
      <div className="min-h-screen bg-[#fafafa] flex flex-col justify-between font-body text-slate-800">
        <header className="w-full border-b border-slate-100 bg-white py-4">
          <div className="max-w-3xl mx-auto px-6 flex justify-between items-center">
            <Link href="/" className="flex items-center gap-2">
              <CMFILogo className="h-7 w-7 text-slate-900" />
              <span className="font-headline text-md font-bold tracking-tight text-slate-900">CMFI BHS</span>
            </Link>
          </div>
        </header>

        <main className="flex-1 py-16 px-6 flex items-center justify-center">
          <div className="max-w-md w-full text-center space-y-6 animate-fadeIn">
            <div className="flex justify-center">
              <CheckCircle2 className="h-16 w-16 text-emerald-500 stroke-[1.5]" />
            </div>
            <div className="space-y-2">
              <h1 className="font-headline text-2xl font-bold text-slate-900 tracking-tight">Application Received</h1>
              <p className="text-sm text-slate-500">
                Thank you, <span className="font-semibold text-slate-700">{formDataState.fullName}</span>. Your application for the 2026/2027 Academic Year has been successfully registered.
              </p>
            </div>
            
            <div className="bg-white border border-slate-100 rounded-xl p-6 shadow-sm text-left space-y-4">
              <p className="text-xs text-slate-500 leading-relaxed">
                A confirmation summary has been dispatched to <span className="font-semibold text-slate-700">{formDataState.email}</span>. Please review your inbox.
              </p>
              <div className="border-t border-slate-50 pt-4">
                <p className="text-xs text-slate-500 mb-3">
                  Need to ask questions or fast-track your application review? Click below to connect with our coordinator.
                </p>
                <Button asChild className="w-full bg-[#25D366] hover:bg-[#20ba5a] text-white py-5 text-sm font-semibold rounded-lg">
                  <a href="https://wa.me/231770732334" target="_blank" rel="noopener noreferrer">
                    Chat on WhatsApp
                  </a>
                </Button>
              </div>
            </div>
            
            <div>
              <Link href="/" className="text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                Return to Website
              </Link>
            </div>
          </div>
        </main>

        <footer className="w-full py-6 border-t border-slate-100 bg-white">
          <div className="max-w-3xl mx-auto px-6 text-center text-[10px] text-slate-400 tracking-wider">
            &copy; {new Date().getFullYear()} CMFI BILINGUAL HIGH SCHOOL. ALL RIGHTS RESERVED.
          </div>
        </footer>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-[#fafafa] flex flex-col justify-between font-body text-slate-800">
      {/* Header Top Bar */}
      <header className="w-full border-b border-slate-100 bg-white py-4">
        <div className="max-w-3xl mx-auto px-6 flex justify-between items-center">
          <Link href="/" className="flex items-center gap-2">
            <CMFILogo className="h-7 w-7 text-slate-900" />
            <span className="font-headline text-md font-bold tracking-tight text-slate-900">CMFI BHS</span>
          </Link>
          <Link href="/" className="text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1">
            <ArrowLeft className="h-3.5 w-3.5" /> Back to Website
          </Link>
        </div>
      </header>

      {/* Main Form Page Container */}
      <main className="flex-1 py-12 px-6 flex flex-col justify-center">
        <div className="max-w-2xl w-full mx-auto space-y-8">
          
          {/* Header Title Info */}
          <div className="text-center space-y-1">
            <h1 className="font-headline text-2xl font-bold tracking-tight text-slate-900">Teacher Application</h1>
            <p className="text-xs text-slate-500 font-medium">Apply to join the educational faculty of CMFI Bilingual High School for the 2026/2027 Academic Year</p>
          </div>

          {/* Stepper Progress Bar */}
          <div className="space-y-2">
            <div className="flex justify-between items-center text-xs">
              <span className="font-bold text-slate-400 uppercase tracking-widest text-[10px]">Step {getActiveStepIndex(currentStep)} of {totalActiveSteps}</span>
              <span className="font-semibold text-slate-800">{activeSteps.find(s => s.id === currentStep)?.name}</span>
            </div>
            <div className="w-full bg-slate-100 h-[3px] rounded-full overflow-hidden">
              <div className="bg-slate-900 h-full transition-all duration-300" style={{ width: `${progressPercent}%` }} />
            </div>
          </div>

          {/* Form Content Card */}
          <div className="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 sm:p-10">
            <form onSubmit={handleSubmitForm} className="space-y-6">
              
              {/* Step 1: Personal Info */}
              {currentStep === 1 && (
                <div className="space-y-6 animate-fadeIn">
                  <div className="border-b border-slate-100 pb-4">
                    <h2 className="text-lg font-bold text-slate-900 font-headline">Section 1: Personal Information</h2>
                    <p className="text-xs text-slate-400">Tell us about yourself and how we can reach you.</p>
                  </div>
                  
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel required>Full Name</FormLabel>
                      <Input name="fullName" value={formDataState.fullName} onChange={handleInputChange} placeholder="First, Middle, Last Name" className={inputClass} required />
                    </div>
                    
                    <div className="space-y-1">
                      <FormLabel required>Gender</FormLabel>
                      <select name="gender" value={formDataState.gender} onChange={handleInputChange} className={inputClass} required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>

                    <div className="space-y-1">
                      <FormLabel required>Date of Birth</FormLabel>
                      <Input type="date" name="dob" value={formDataState.dob} onChange={handleInputChange} className={inputClass} required />
                    </div>

                    <div className="space-y-1">
                      <FormLabel required>Nationality</FormLabel>
                      <Input name="nationality" value={formDataState.nationality} onChange={handleInputChange} placeholder="Liberian" className={inputClass} required />
                    </div>

                    <div className="space-y-1">
                      <FormLabel required>County/City of Residence</FormLabel>
                      <Input name="cityOfResidence" value={formDataState.cityOfResidence} onChange={handleInputChange} placeholder="Paynesville, Montserrado" className={inputClass} required />
                    </div>

                    <div className="space-y-1">
                      <FormLabel required>Mobile Number</FormLabel>
                      <Input type="tel" name="mobileNumber" value={formDataState.mobileNumber} onChange={handleInputChange} placeholder="+231..." className={inputClass} required />
                    </div>

                    <div className="space-y-1">
                      <FormLabel>WhatsApp Number</FormLabel>
                      <Input type="tel" name="whatsAppNumber" value={formDataState.whatsAppNumber} onChange={handleInputChange} placeholder="+231..." className={inputClass} />
                    </div>

                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel required>Email Address</FormLabel>
                      <Input type="email" name="email" value={formDataState.email} onChange={handleInputChange} placeholder="example@mail.com" className={inputClass} required />
                    </div>

                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel required>Home Address</FormLabel>
                      <Input name="homeAddress" value={formDataState.homeAddress} onChange={handleInputChange} placeholder="Neighborhood / Community Address" className={inputClass} required />
                    </div>
                  </div>

                  <div className="pt-4 border-t border-slate-100">
                    <p className="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-3 text-slate-700">Emergency Contact</p>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div className="space-y-1">
                        <FormLabel required>Contact Person Name</FormLabel>
                        <Input name="emergencyName" value={formDataState.emergencyName} onChange={handleInputChange} placeholder="Contact Person's Name" className={inputClass} required />
                      </div>
                      <div className="space-y-1">
                        <FormLabel required>Contact Person Number</FormLabel>
                        <Input type="tel" name="emergencyNumber" value={formDataState.emergencyNumber} onChange={handleInputChange} placeholder="Phone Number" className={inputClass} required />
                      </div>
                    </div>
                  </div>
                </div>
              )}

              {/* Step 2: Position Info */}
              {currentStep === 2 && (
                <div className="space-y-6 animate-fadeIn">
                  <div className="border-b border-slate-100 pb-4">
                    <h2 className="text-lg font-bold text-slate-900 font-headline">Section 2: Position Information</h2>
                    <p className="text-xs text-slate-400">Select the type of teaching position you are applying for.</p>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="space-y-1">
                      <FormLabel required>Are you applying as:</FormLabel>
                      <select name="applicantType" value={formDataState.applicantType} onChange={handleInputChange} className={inputClass} required>
                        <option value="">Choose Application Type</option>
                        <option value="New Applicant">New Applicant</option>
                        <option value="Current Teacher (Reapplying)">Current Teacher (Reapplying)</option>
                      </select>
                    </div>

                    <div className="space-y-1">
                      <FormLabel required>Position Applying For</FormLabel>
                      <select name="positionApplyingFor" value={formDataState.positionApplyingFor} onChange={handleInputChange} className={inputClass} required>
                        <option value="">Choose Position</option>
                        <option value="Nursery Teacher">Nursery Teacher</option>
                        <option value="Elementary Teacher">Elementary Teacher</option>
                        <option value="Junior High Teacher">Junior High Teacher</option>
                        <option value="Senior High Teacher">Senior High Teacher</option>
                        <option value="Subject Specialist">Subject Specialist</option>
                        <option value="Other">Other (Specify)</option>
                      </select>
                    </div>

                    {formDataState.positionApplyingFor === 'Other' && (
                      <div className="space-y-1 sm:col-span-2">
                        <FormLabel required>Please Specify Position</FormLabel>
                        <Input name="otherPosition" value={formDataState.otherPosition} onChange={handleInputChange} placeholder="E.g. Lab Assistant, Vice Principal" className={inputClass} required />
                      </div>
                    )}

                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel>Subject(s) You Can Teach</FormLabel>
                      <Input name="subjectsCanTeach" value={formDataState.subjectsCanTeach} onChange={handleInputChange} placeholder="E.g. Mathematics, French, Biology (separate with commas)" className={inputClass} />
                    </div>

                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel>Grade Level(s) Preferred</FormLabel>
                      <Input name="gradesPreferred" value={formDataState.gradesPreferred} onChange={handleInputChange} placeholder="E.g. Grades 7-9, Nursery II" className={inputClass} />
                    </div>
                  </div>
                </div>
              )}

              {/* Step 3: Education & Uploads */}
              {currentStep === 3 && (
                <div className="space-y-6 animate-fadeIn">
                  <div className="border-b border-slate-100 pb-4">
                    <h2 className="text-lg font-bold text-slate-900 font-headline">Section 3: Education & Documents</h2>
                    <p className="text-xs text-slate-400">List your qualifications and upload documents.</p>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="space-y-1">
                      <FormLabel required>Highest Qualification Obtained</FormLabel>
                      <select name="highestQualification" value={formDataState.highestQualification} onChange={handleInputChange} className={inputClass} required>
                        <option value="">Choose Qualification</option>
                        <option value="High School Graduate">High School Graduate</option>
                        <option value="Associate Degree">Associate Degree</option>
                        <option value="Bachelor's Degree">Bachelor's Degree</option>
                        <option value="Master's Degree">Master's Degree</option>
                        <option value="Doctorate">Doctorate</option>
                      </select>
                    </div>

                    <div className="space-y-1">
                      <FormLabel required>Institution Attended</FormLabel>
                      <Input name="institution" value={formDataState.institution} onChange={handleInputChange} placeholder="University / College Name" className={inputClass} required />
                    </div>

                    <div className="space-y-1">
                      <FormLabel required>Graduation Year</FormLabel>
                      <Input type="number" name="graduationYear" value={formDataState.graduationYear} onChange={handleInputChange} placeholder="YYYY" className={inputClass} required />
                    </div>

                    <div className="space-y-1">
                      <FormLabel>Major / Area of Study</FormLabel>
                      <Input name="major" value={formDataState.major} onChange={handleInputChange} placeholder="E.g. Primary Education, Chemistry" className={inputClass} />
                    </div>

                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel>Professional Certifications (if any)</FormLabel>
                      <Input name="certifications" value={formDataState.certifications} onChange={handleInputChange} placeholder="E.g. WAEC Teacher Certificate" className={inputClass} />
                    </div>
                  </div>

                  <div className="pt-4 border-t border-slate-100 space-y-4">
                    <div>
                      <p className="text-[11px] font-bold text-slate-500 uppercase tracking-wider text-slate-700">Document Uploads</p>
                      <p className="text-[10px] text-slate-400">Please upload copy of CV (required) and other supporting documents. Max 2MB per file.</p>
                    </div>
                    
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <FileUploadField name="cv" label="CV / Resume" accept=".pdf,.doc,.docx" required file={uploadedFiles.cv} />
                      <FileUploadField name="academicCertificate" label="Academic Certificates" accept=".pdf,.jpg,.jpeg,.png" file={uploadedFiles.academicCertificate} />
                      <FileUploadField name="transcript" label="Transcripts" accept=".pdf,.jpg,.jpeg,.png" file={uploadedFiles.transcript} />
                      <FileUploadField name="professionalCertificate" label="Professional Certificates" accept=".pdf,.jpg,.jpeg,.png" file={uploadedFiles.professionalCertificate} />
                      <FileUploadField name="idCard" label="Identification Card (ID/Passport)" accept=".pdf,.jpg,.jpeg,.png" file={uploadedFiles.idCard} />
                      <FileUploadField name="photo" label="Passport-size Photo" accept=".jpg,.jpeg,.png" file={uploadedFiles.photo} />
                    </div>
                  </div>
                </div>
              )}

              {/* Step 4: Teaching Experience */}
              {currentStep === 4 && (
                <div className="space-y-6 animate-fadeIn">
                  <div className="border-b border-slate-100 pb-4">
                    <h2 className="text-lg font-bold text-slate-900 font-headline">Section 4: Teaching Experience</h2>
                    <p className="text-xs text-slate-400">Provide details on your teaching experience.</p>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="space-y-1">
                      <FormLabel required>Total Years of Experience</FormLabel>
                      <Input type="number" name="yearsExperience" value={formDataState.yearsExperience} onChange={handleInputChange} min="0" className={inputClass} required />
                    </div>

                    <div className="space-y-1">
                      <FormLabel>Current or Previous School</FormLabel>
                      <Input name="previousSchool" value={formDataState.previousSchool} onChange={handleInputChange} placeholder="Name of school" className={inputClass} />
                    </div>

                    <div className="space-y-1">
                      <FormLabel>Position Held</FormLabel>
                      <Input name="prevPosition" value={formDataState.prevPosition} onChange={handleInputChange} placeholder="E.g. Junior High Teacher" className={inputClass} />
                    </div>

                    <div className="space-y-1">
                      <FormLabel>Subjects Taught</FormLabel>
                      <Input name="prevSubjects" value={formDataState.prevSubjects} onChange={handleInputChange} placeholder="E.g. English, General Science" className={inputClass} />
                    </div>

                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel>Employment Period</FormLabel>
                      <Input name="prevPeriod" value={formDataState.prevPeriod} onChange={handleInputChange} placeholder="E.g. Sept 2022 - June 2024" className={inputClass} />
                    </div>
                  </div>

                  {formDataState.applicantType === 'New Applicant' && (
                    <div className="pt-4 border-t border-slate-100 space-y-4">
                      <div>
                        <p className="text-[11px] font-bold text-slate-500 uppercase tracking-wider text-slate-700">Prior School Details</p>
                        <p className="text-[10px] text-slate-400">Specify details of your last two employers (School Name, Position, Supervisor Contact).</p>
                      </div>
                      <div className="space-y-3">
                        <div className="space-y-1">
                          <FormLabel>Prior Employer 1</FormLabel>
                          <Input name="newAppEmployer1" value={formDataState.newAppEmployer1} onChange={handleInputChange} placeholder="School Name, Position, Supervisor Contact Info" className={inputClass} />
                        </div>
                        <div className="space-y-1">
                          <FormLabel>Prior Employer 2</FormLabel>
                          <Input name="newAppEmployer2" value={formDataState.newAppEmployer2} onChange={handleInputChange} placeholder="School Name, Position, Supervisor Contact Info" className={inputClass} />
                        </div>
                      </div>
                    </div>
                  )}
                </div>
              )}

              {/* Step 5: Current Teacher Reapplication (Conditional) */}
              {currentStep === 5 && isReapplying && (
                <div className="space-y-6 animate-fadeIn">
                  <div className="border-b border-slate-100 pb-4">
                    <h2 className="text-lg font-bold text-slate-900 font-headline">Section 5: Reapplication Information</h2>
                    <p className="text-xs text-slate-400">For returning CMFI Bilingual High School faculty members.</p>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div className="space-y-1">
                      <FormLabel required>Department/Grade Currently Assigned</FormLabel>
                      <Input name="currentDept" value={formDataState.currentDept} onChange={handleInputChange} placeholder="E.g. Junior High, French Dept" className={inputClass} required />
                    </div>

                    <div className="space-y-1">
                      <FormLabel required>Years Served at CMFI School</FormLabel>
                      <Input type="number" name="yearsServed" value={formDataState.yearsServed} onChange={handleInputChange} min="0" className={inputClass} required />
                    </div>

                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel>Major Achievements During Your Service</FormLabel>
                      <Textarea name="achievements" value={formDataState.achievements} onChange={handleInputChange} placeholder="Describe any achievements or milestones..." className={inputClass} />
                    </div>

                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel>Challenges Faced & Recommendations</FormLabel>
                      <Textarea name="challenges" value={formDataState.challenges} onChange={handleInputChange} placeholder="Describe any challenges faced..." className={inputClass} />
                    </div>

                    <div className="space-y-1 sm:col-span-2">
                      <FormLabel>Why do you wish to continue serving at CMFI?</FormLabel>
                      <Textarea name="whyContinue" value={formDataState.whyContinue} onChange={handleInputChange} placeholder="Describe your motivations..." className={inputClass} />
                    </div>
                  </div>
                </div>
              )}

              {/* Step 6: Skills & Conduct */}
              {currentStep === 6 && (
                <div className="space-y-6 animate-fadeIn">
                  <div className="border-b border-slate-100 pb-4">
                    <h2 className="text-lg font-bold text-slate-900 font-headline">Section 6 & 7: Skills & Conduct</h2>
                    <p className="text-xs text-slate-400">Assess your competencies and verify conduct history.</p>
                  </div>

                  <div className="space-y-4">
                    <p className="text-[11px] font-bold text-slate-500 uppercase tracking-wider text-slate-700">Skills Proficiency Check</p>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                        <div key={skill.name} className="space-y-1">
                          <FormLabel>{skill.label}</FormLabel>
                          <select name={skill.name} value={formDataState[skill.name]} onChange={handleInputChange} className={inputClass}>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                          </select>
                        </div>
                      ))}
                    </div>
                  </div>

                  <div className="pt-4 border-t border-slate-100 space-y-4">
                    <p className="text-[11px] font-bold text-slate-500 uppercase tracking-wider text-slate-700">Character & Conduct</p>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div className="space-y-1">
                        <FormLabel required>Dismissed from a previous job?</FormLabel>
                        <select name="dismissed" value={formDataState.dismissed} onChange={handleInputChange} className={inputClass} required>
                          <option value="No">No</option>
                          <option value="Yes">Yes</option>
                        </select>
                      </div>

                      <div className="space-y-1">
                        <FormLabel required>Convicted of a criminal offense?</FormLabel>
                        <select name="convicted" value={formDataState.convicted} onChange={handleInputChange} className={inputClass} required>
                          <option value="No">No</option>
                          <option value="Yes">Yes</option>
                        </select>
                      </div>

                      <div className="space-y-1 sm:col-span-2">
                        <FormLabel required>Willing to abide by all school policies?</FormLabel>
                        <select name="abidePolicies" value={formDataState.abidePolicies} onChange={handleInputChange} className={inputClass} required>
                          <option value="Yes">Yes, absolutely</option>
                          <option value="No">No</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              )}

              {/* Step 7: References & Availability */}
              {currentStep === 7 && (
                <div className="space-y-6 animate-fadeIn">
                  <div className="border-b border-slate-100 pb-4">
                    <h2 className="text-lg font-bold text-slate-900 font-headline">Section 8 & 9: References & Availability</h2>
                    <p className="text-xs text-slate-400">Provide professional references and scheduling constraints.</p>
                  </div>

                  <div className="space-y-4">
                    <p className="text-[11px] font-bold text-slate-500 uppercase tracking-wider text-slate-700">Reference 1</p>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div className="space-y-1">
                        <FormLabel required>Full Name</FormLabel>
                        <Input name="ref1Name" value={formDataState.ref1Name} onChange={handleInputChange} className={inputClass} required />
                      </div>
                      <div className="space-y-1">
                        <FormLabel required>Position</FormLabel>
                        <Input name="ref1Position" value={formDataState.ref1Position} onChange={handleInputChange} className={inputClass} required />
                      </div>
                      <div className="space-y-1">
                        <FormLabel required>Organization</FormLabel>
                        <Input name="ref1Org" value={formDataState.ref1Org} onChange={handleInputChange} className={inputClass} required />
                      </div>
                      <div className="space-y-1">
                        <FormLabel required>Phone Number</FormLabel>
                        <Input type="tel" name="ref1Phone" value={formDataState.ref1Phone} onChange={handleInputChange} className={inputClass} required />
                      </div>
                      <div className="space-y-1 sm:col-span-2">
                        <FormLabel>Email Address</FormLabel>
                        <Input type="email" name="ref1Email" value={formDataState.ref1Email} onChange={handleInputChange} placeholder="example@mail.com" className={inputClass} />
                      </div>
                    </div>
                  </div>

                  <div className="pt-4 border-t border-slate-100 space-y-4">
                    <p className="text-[11px] font-bold text-slate-500 uppercase tracking-wider text-slate-700">Reference 2</p>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div className="space-y-1">
                        <FormLabel required>Full Name</FormLabel>
                        <Input name="ref2Name" value={formDataState.ref2Name} onChange={handleInputChange} className={inputClass} required />
                      </div>
                      <div className="space-y-1">
                        <FormLabel required>Position</FormLabel>
                        <Input name="ref2Position" value={formDataState.ref2Position} onChange={handleInputChange} className={inputClass} required />
                      </div>
                      <div className="space-y-1">
                        <FormLabel required>Organization</FormLabel>
                        <Input name="ref2Org" value={formDataState.ref2Org} onChange={handleInputChange} className={inputClass} required />
                      </div>
                      <div className="space-y-1">
                        <FormLabel required>Phone Number</FormLabel>
                        <Input type="tel" name="ref2Phone" value={formDataState.ref2Phone} onChange={handleInputChange} className={inputClass} required />
                      </div>
                      <div className="space-y-1 sm:col-span-2">
                        <FormLabel>Email Address</FormLabel>
                        <Input type="email" name="ref2Email" value={formDataState.ref2Email} onChange={handleInputChange} placeholder="example@mail.com" className={inputClass} />
                      </div>
                    </div>
                  </div>

                  <div className="pt-4 border-t border-slate-100 space-y-4">
                    <p className="text-[11px] font-bold text-slate-500 uppercase tracking-wider text-slate-700">Availability</p>
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div className="space-y-1">
                        <FormLabel required>Available Start Date</FormLabel>
                        <Input type="date" name="startDate" value={formDataState.startDate} onChange={handleInputChange} className={inputClass} required />
                      </div>

                      <div className="space-y-1">
                        <FormLabel required>Commitment Level</FormLabel>
                        <select name="commitmentType" value={formDataState.commitmentType} onChange={handleInputChange} className={inputClass} required>
                          <option value="Full-Time">Full-Time</option>
                          <option value="Part-Time">Part-Time</option>
                        </select>
                      </div>

                      <div className="space-y-1 sm:col-span-2">
                        <FormLabel>Other Scheduling Commitments</FormLabel>
                        <Input name="otherCommitments" value={formDataState.otherCommitments} onChange={handleInputChange} placeholder="E.g. university classes, other part-time jobs" className={inputClass} />
                      </div>
                    </div>
                  </div>
                </div>
              )}

              {/* Step 8: Review & Submit */}
              {currentStep === 8 && (
                <div className="space-y-6 animate-fadeIn">
                  <div className="border-b border-slate-100 pb-4">
                    <h2 className="text-lg font-bold text-slate-900 font-headline">Section 10 & 11: Review & Submit</h2>
                    <p className="text-xs text-slate-400">Complete your personal statement and verify your responses before final submission.</p>
                  </div>

                  <div className="space-y-1">
                    <FormLabel required>Personal Statement (Minimum 50 words)</FormLabel>
                    <Textarea
                      name="personalStatement"
                      value={formDataState.personalStatement}
                      onChange={handleInputChange}
                      placeholder="Share your teaching philosophy, why you want to teach at CMFI, and the value you bring to students..."
                      className="min-h-[160px] w-full rounded-lg border border-slate-200 bg-slate-50/30 px-4 py-3 text-sm transition-all focus:bg-white focus:border-slate-800 focus:ring-0 focus-visible:ring-0 focus-visible:ring-offset-0 focus-visible:outline-none"
                      required
                    />
                    <p className="text-[10px] text-slate-400">
                      Word Count: {formDataState.personalStatement.trim() ? formDataState.personalStatement.trim().split(/\s+/).length : 0} words
                    </p>
                  </div>

                  <div className="bg-slate-50 rounded-xl p-6 border border-slate-100 space-y-3">
                    <h3 className="text-xs font-bold text-slate-700 uppercase tracking-wider">Critical Details Summary</h3>
                    <div className="text-xs grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4 border-t border-slate-200/60 pt-3">
                      <div className="flex justify-between sm:justify-start gap-2">
                        <span className="text-slate-400">Full Name:</span>
                        <span className="font-semibold text-slate-700">{formDataState.fullName}</span>
                      </div>
                      <div className="flex justify-between sm:justify-start gap-2">
                        <span className="text-slate-400">Type:</span>
                        <span className="font-semibold text-slate-700">{formDataState.applicantType}</span>
                      </div>
                      <div className="flex justify-between sm:justify-start gap-2 col-span-1 sm:col-span-2">
                        <span className="text-slate-400">Applying For:</span>
                        <span className="font-semibold text-slate-700">{formDataState.positionApplyingFor}</span>
                      </div>
                      <div className="flex justify-between sm:justify-start gap-2">
                        <span className="text-slate-400">Email:</span>
                        <span className="font-semibold text-slate-700">{formDataState.email}</span>
                      </div>
                      <div className="flex justify-between sm:justify-start gap-2">
                        <span className="text-slate-400">Phone:</span>
                        <span className="font-semibold text-slate-700">{formDataState.mobileNumber}</span>
                      </div>
                      <div className="flex justify-between sm:justify-start gap-2 col-span-1 sm:col-span-2 border-t border-slate-200/40 pt-2 mt-1">
                        <span className="text-slate-400">CV Attached:</span>
                        <span className="font-semibold text-slate-700">{uploadedFiles.cv ? uploadedFiles.cv.name : 'Missing!'}</span>
                      </div>
                    </div>
                  </div>

                  <div className="pt-4 border-t border-slate-100 space-y-4">
                    <p className="text-[11px] font-bold text-slate-500 uppercase tracking-wider text-slate-700">Declaration Statement</p>
                    <p className="text-xs italic text-slate-400 leading-relaxed bg-slate-50/50 p-4 rounded-lg border border-slate-100">
                      "I hereby certify that the information provided in this application is true and complete to the best of my knowledge. I understand that any false information may result in the rejection of my application or termination of employment."
                    </p>
                    <div className="flex items-start gap-2.5 pt-2">
                      <input
                        type="checkbox"
                        id="declarationSigned"
                        name="declarationSigned"
                        checked={formDataState.declarationSigned}
                        onChange={handleInputChange}
                        className="mt-1 h-4.5 w-4.5 rounded border-slate-200 text-slate-900 focus:ring-slate-900"
                        required
                      />
                      <label htmlFor="declarationSigned" className="text-xs font-semibold text-slate-700 select-none cursor-pointer">
                        I agree to the declaration statement above. <span className="text-red-500">*</span>
                      </label>
                    </div>
                  </div>
                </div>
              )}

              {/* Wizard Navigation Footer */}
              <div className="mt-8 pt-4 border-t border-slate-100 flex justify-between gap-4">
                {currentStep > 1 ? (
                  <Button type="button" variant="outline" onClick={handleBack} className="border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-5 rounded-lg flex items-center gap-1.5 text-xs py-2.5 h-auto">
                    <ArrowLeft className="h-3.5 w-3.5" /> Back
                  </Button>
                ) : (
                  <div></div>
                )}
                {currentStep < activeSteps[activeSteps.length - 1].id ? (
                  <Button type="button" onClick={handleNext} className="bg-slate-900 hover:bg-slate-800 text-white font-semibold px-5 rounded-lg flex items-center gap-1.5 text-xs py-2.5 h-auto ml-auto">
                    Next <ArrowRight className="h-3.5 w-3.5" />
                  </Button>
                ) : (
                  <Button type="submit" disabled={isPending} className="bg-slate-900 hover:bg-slate-800 text-white font-bold px-6 rounded-lg flex items-center gap-1.5 text-xs py-3 h-auto ml-auto shadow-sm">
                    {isPending ? (
                      <>
                        <Loader2 className="h-3.5 w-3.5 animate-spin" /> Submitting...
                      </>
                    ) : (
                      <>
                        Submit Application <Send className="h-3.5 w-3.5" />
                      </>
                    )}
                  </Button>
                )}
              </div>
            </form>
          </div>
        </div>
      </main>

      {/* Page Footer */}
      <footer className="w-full py-6 border-t border-slate-100 bg-white">
        <div className="max-w-3xl mx-auto px-6 text-center text-[10px] text-slate-400 tracking-wider">
          &copy; {new Date().getFullYear()} CMFI BILINGUAL HIGH SCHOOL. ALL RIGHTS RESERVED.
        </div>
      </footer>
    </div>
  );
}
