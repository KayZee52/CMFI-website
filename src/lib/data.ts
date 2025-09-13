import { Briefcase, DollarSign, GraduationCap, Group, Heart, Lightbulb, Star, Trophy } from "@/components/icons";

export const timelineData = [
  {
    year: '2014',
    title: 'School Founded',
    description: 'CMFI Bilingual High School was founded to provide quality bilingual education in Paynesville.',
  },
  {
    year: '2016',
    title: 'First Junior High Classes',
    description: 'The school expanded to include its first cohort of junior high school students.',
  },
  {
    year: '2019',
    title: 'First Graduation & Campus Expansion',
    description: 'Celebrated its first graduation and inaugurated a new science and ICT block.',
  },
  {
    year: '2021',
    title: 'Full Senior High Program',
    description: 'The senior high school section was fully established, offering a complete secondary education.',
  },
  {
    year: '2023',
    title: 'Advanced ICT Program',
    description: 'Launched an advanced ICT program to equip students with modern digital skills.',
  },
  {
    year: '2024',
    title: 'Leading Bilingual Institution',
    description: 'Recognized as a leading bilingual institution in Paynesville for academic excellence.',
  }
];

export const galleryData = [
  { id: '1', event: 'Sports Day', hint: 'students running' },
  { id: '2', event: 'Sports Day', hint: 'team celebration' },
  { id: '3', event: 'Labs', hint: 'students experiment' },
  { id: '4', event: 'Labs', hint: 'robot project' },
  { id: '5', event: 'Cultural Events', hint: 'traditional dance' },
  { id: '6', event: 'Cultural Events', hint: 'colorful costumes' },
  { id: '7', event: 'Graduation', hint: 'students graduation' },
  { id: '8', event: 'Graduation', hint: 'happy graduates' },
];

export const newsData = [
  {
    date: '2024-07-15',
    title: 'CMFI Launches New Robotics Club',
    summary: 'The new club aims to foster innovation and practical skills in STEM among students, preparing them for future technology careers.'
  },
  {
    date: '2024-06-28',
    title: 'Annual Inter-House Sports Competition Concludes',
    summary: 'Blue House emerged as the overall winner in a thrilling competition that showcased incredible sportsmanship and talent.'
  },
  {
    date: '2024-05-20',
    title: 'Registration for 2024/2025 Academic Year Now Open',
    summary: 'Prospective parents and students are invited to apply for admission into JSS1 and SSS1 for the upcoming academic year.'
  },
];

export const testimonials = [
  {
    name: 'John Doe',
    role: 'Alumnus',
    quote: 'CMFI gave me the foundation for success. The discipline and values here shape true leaders.'
  },
  {
    name: 'Jane Smith',
    role: 'Parent',
    quote: 'The teachers are incredibly dedicated and the communication with parents is excellent. I always feel informed and involved in my child\'s education.'
  },
    {
    name: 'Grace Williams',
    role: 'Parent',
    quote: 'The discipline and values here shape true leaders. I trust CMFI with my child’s future because they balance academics and discipline.'
  },
  {
    name: 'Samuel Johnson',
    role: 'Student',
    quote: 'At CMFI, I feel inspired and motivated every day. The friendly competition and the wide range of activities available is great.'
  },
  {
    name: 'Fatu Kamara',
    role: 'Student',
    quote: 'At CMFI, I’ve grown both academically and socially. It feels like a family here, and the teachers really care about our success.'
  },
  {
    name: 'David Williams',
    role: 'Student',
    quote: 'The sports program gave me confidence and taught me the value of teamwork. It\'s a great balance to our challenging academic schedule.'
  },
];

export const stats = [
    { number: 10, suffix: '+', label: 'Years of Excellence' },
    { number: 500, suffix: '+', label: 'Students Enrolled' },
    { number: 100, suffix: '+', label: 'Graduates' },
];

export const glanceStats = [
  {
    value: "10+",
    label: "Years of Excellence",
    Icon: Star,
  },
  {
    value: "500+",
    label: "AP/Honors Courses",
    Icon: Lightbulb,
  },
  {
    value: "$1M+",
    label: "In College Scholarships",
    Icon: DollarSign,
  },
  {
    value: "1000+",
    label: "Graduates",
    Icon: GraduationCap,
  },
  {
    value: "5:1",
    label: "Student to Teacher Ratio",
    Icon: Group,
  },
  {
    value: "95%",
    label: "Graduation Rate",
    Icon: Trophy,
  },
  {
    value: "10K+",
    label: "Community Service Hours",
    Icon: Heart,
  },
  {
    value: "20+",
    label: "Student-Run Clubs and Activities",
    Icon: Briefcase,
  },
];

export const searchData = [
    {
        title: 'Home',
        href: '/',
        keywords: ['home', 'main', 'welcome', 'index'],
        summary: 'The main landing page of the CMFI Bilingual High School website, featuring highlights and navigation to all other sections.'
    },
    {
        title: 'About Us',
        href: '/about',
        keywords: ['about', 'mission', 'vision', 'principal', 'history', 'timeline'],
        summary: 'Learn about CMFI\'s history, our mission and vision, and read a welcome message from our principal. Discover our journey through the years.'
    },
    {
        title: 'Admissions',
        href: '/admissions',
        keywords: ['admissions', 'apply', 'enrollment', 'fees', 'requirements', 'application', 'process'],
        summary: 'Find out how to apply to CMFI. This page details the admission process, required documents, and important deadlines.'
    },
    {
        title: 'Academics',
        href: '/academics',
        keywords: ['academics', 'curriculum', 'departments', 'subjects', 'learning', 'science', 'math', 'languages', 'ict'],
        summary: 'Explore our rigorous bilingual curriculum, academic departments, and learning facilities designed for student success.'
    },
    {
        title: 'Student Life',
        href: '/student-life',
        keywords: ['student life', 'sports', 'clubs', 'events', 'activities', 'community', 'alumni'],
        summary: 'Discover life beyond the classroom, from athletics and clubs to community involvement and special school events.'
    },
    {
        title: 'Parents',
        href: '/parents',
        keywords: ['parents', 'resources', 'handbook', 'calendar', 'meetings', 'pta'],
        summary: 'A resource hub for parents, providing access to the student handbook, school calendar, and information on parent-teacher involvement.'
    },
    {
        title: 'Gallery',
        href: '/gallery',
        keywords: ['gallery', 'photos', 'images', 'events', 'sports day', 'graduation'],
        summary: 'View photos from our school events, including sports days, cultural celebrations, and graduation ceremonies.'
    },
    {
        title: 'Contact Us',
        href: '/contact',
        keywords: ['contact', 'address', 'phone', 'email', 'map', 'directions', 'news', 'updates'],
        summary: 'Find our contact details, location map, and operating hours. You can also send us a message directly through the contact form.'
    },
];
