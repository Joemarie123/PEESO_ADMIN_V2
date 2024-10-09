-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2024 at 02:52 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peeso`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblapplication`
--

CREATE TABLE `tblapplication` (
  `ID` int(11) NOT NULL,
  `Job_ID` int(11) NOT NULL,
  `Applicant_ID` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'APPLIED',
  `Date_applied` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblapplication`
--

INSERT INTO `tblapplication` (`ID`, `Job_ID`, `Applicant_ID`, `status`, `Date_applied`) VALUES
(132, 62, 7, 'ACCEPTED', '2024-09-18'),
(133, 62, 2, 'ACCEPTED', '2024-09-18'),
(134, 61, 2, 'ACCEPTED', '2024-09-25'),
(135, 60, 2, 'ACCEPTED', '2024-09-27'),
(136, 59, 2, 'ACCEPTED', '2024-10-02'),
(137, 55, 2, 'APPLIED', '2024-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `tblappointment`
--

CREATE TABLE `tblappointment` (
  `ID` int(11) NOT NULL,
  `Job_ID` int(11) NOT NULL,
  `Applicant_ID` int(11) NOT NULL,
  `Appointment_date` date NOT NULL,
  `Appointment_time` time NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'SCHEDULED',
  `Remarks` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblappointment`
--

INSERT INTO `tblappointment` (`ID`, `Job_ID`, `Applicant_ID`, `Appointment_date`, `Appointment_time`, `Status`, `Remarks`) VALUES
(105, 62, 7, '2024-09-18', '15:52:00', 'SCHEDULED', ''),
(106, 62, 2, '2024-10-05', '15:52:00', 'CONFIRM', ''),
(107, 60, 2, '2024-10-05', '21:51:00', 'SCHEDULED', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblappointmenthistory`
--

CREATE TABLE `tblappointmenthistory` (
  `ID` int(11) NOT NULL,
  `Appointment_ID` int(11) NOT NULL,
  `Appointment_date` date NOT NULL,
  `Appointment_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblappointmenthistory`
--

INSERT INTO `tblappointmenthistory` (`ID`, `Appointment_ID`, `Appointment_date`, `Appointment_time`) VALUES
(1, 67, '2024-09-17', '16:26:00'),
(2, 67, '2024-09-17', '16:26:00'),
(3, 67, '2024-09-17', '16:26:00'),
(4, 68, '2024-09-17', '16:29:00'),
(5, 79, '2024-09-18', '14:03:00'),
(6, 106, '2024-09-18', '15:52:00'),
(7, 106, '2024-09-18', '15:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcompany`
--

CREATE TABLE `tblcompany` (
  `ID` int(11) NOT NULL,
  `Company_name` varchar(255) NOT NULL,
  `Company_address` varchar(500) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) NOT NULL,
  `Suffix` varchar(4) NOT NULL,
  `ContactNo` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Company_Logo` varchar(50) NOT NULL,
  `LoginID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcompany`
--

INSERT INTO `tblcompany` (`ID`, `Company_name`, `Company_address`, `LastName`, `FirstName`, `MiddleName`, `Suffix`, `ContactNo`, `Email`, `Company_Logo`, `LoginID`) VALUES
(33, 'Company_Profile', 'Please Dont Delete', 'Please Dont Delete', 'Please Dont Delete', 'Please Dont Delete', '1', '1212121212', 'dontdelete@gmail.com', 'e5d3982a1f7a511f789d.jpg', 34),
(41, 'Joma internet Cafe', 'Tagum City', 'Rendon', 'Joemarie', 'Odtojan', '1', '09518110301', 'tccstfichannel@gmail.com', 'ad9621d91ff02154196d.ico', 42),
(42, 'Programming Company', 'Tagum Davao Del Norte', 'Mahusay', 'Jograd', 'mascariñas', '2', '094544554', 'jogz@gmail.com', '', 43),
(43, 'Jiren Coffee Shop', 'Asuncion Davao Del norte', 'Rendon', 'Jiren', 'Rullenas', 'Jr', '09515111555', 'jiren@gmail.com', '', 44),
(48, 'Milk Tea ni Go', 'Tagum City APokon', 'Curay', 'Honey Marjie', 'Vegonte', 'Jr', '094545454', 'sadfasdf@gmail.com', '00d3b788cb8aec442717.jpg', 58),
(49, 'Joma Internet Cafe', 'Tagum City', 'Rendon', 'Joemarie', 'Odtojan', 'N/A', '09518110301', 'joemarierdfdfendo1n@gmail.com', '', 59),
(50, 'DCN', 'Tagum City', 'Briones', 'Nichols', 'M.', '', '09154545454', 'nicholsph622@gmail.com', 'd4c8b684aa89f24fbf07.png', 60),
(52, 'Tech', 'Tagum City', 'Tanaid', 'Cathlyn', 'Andliab', '', '09108547562', 'cathlyntanaid@gmail.com', '64056b3448687cfc3650.jpg', 62),
(53, 'Company 1', 'Tagum City Davao Del norte', 'Harden', 'James', 'K.', 'Jr', '09454544545', 'rptasbtas@gmail.com', 'a44757a6645ea5d9938c.ico', 65),
(54, 'Company B', 'DOOR 4 NEIL BLDG., Bonifacio St., Tagum City, Davao del Norte, 8100', 'Roble', 'Neil Benjamin', 'Paña', 'N/A', '11234567890', 'neilroble125@gmail.com', '', 66),
(55, 'pscdo', 'visayan village', 'Martinez', 'Roy', 'V', 'N/A', '12345678901', 'rmartinez.pesotgmcity@gmail.com', '', 69),
(56, 'Internet Cafe ', 'tagum', 'tomol', 'hazel', 'sala', '', '09760444277', 'horanghaee13@gmail.com', 'a1a86dc6218b7fd20a29.jpg', 70),
(57, 'James Cafe', 'tagum', 'sf', 'james', 'dsf', 'Sr.', '030434343', 'joemarierendon@gmail.com', '4772cb5f43680f1cfb11.jpg', 72),
(58, 'Alex Company', 'Tgaum City', 'aniñon', 'Alex', 'P', '', '06265454654', 'alexaninon41@gmail.com', '24b85e1c11b7d96e8196.jpg', 73);

-- --------------------------------------------------------

--
-- Table structure for table `tbljobs`
--

CREATE TABLE `tbljobs` (
  `ID` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL,
  `Title` varchar(500) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `Salary` double NOT NULL,
  `DateFrom` date NOT NULL,
  `DateTo` date NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `NumHours` int(11) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `WorkPlace` varchar(500) NOT NULL,
  `VacantCount` int(11) NOT NULL,
  `EducationLevel` varchar(255) NOT NULL,
  `Course` varchar(200) NOT NULL,
  `WorkExperience` int(11) NOT NULL,
  `License` varchar(255) NOT NULL,
  `query` varchar(500) NOT NULL,
  `iscancelled` tinyint(1) NOT NULL DEFAULT 0,
  `STATUS` varchar(10) NOT NULL DEFAULT 'OPEN'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbljobs`
--

INSERT INTO `tbljobs` (`ID`, `Company_ID`, `Title`, `pic`, `Salary`, `DateFrom`, `DateTo`, `Description`, `NumHours`, `Type`, `WorkPlace`, `VacantCount`, `EducationLevel`, `Course`, `WorkExperience`, `License`, `query`, `iscancelled`, `STATUS`) VALUES
(29, 41, 'Web Developer', '11e1bd61fc0e33272c58.png', 30000, '2024-08-08', '2024-08-31', 'Must be Gwapo ug GwapaHumotBrightkugihandali rang ma sugo', 8, 'Permanent', 'Tagum City Davao Del norte', 15, 'College Graduate', 'BS IT or BS CS', 5, 'Drivers License', '', 0, 'OVERDUE'),
(30, 41, 'Truck Driver', 'b54017fd25dd67a26a80.png', 20000, '2024-08-07', '2024-08-31', 'Driver nga hawod mo DriveKabalo mo luotKabalo mo Drivekabalo manilhig', 2, 'Permanent', 'Tagum City Davao Del norte', 15, 'College Graduate', 'Bachelor Truck Driver Science', 5, 'Drivers Licene', '', 0, 'OVERDUE'),
(31, 52, 'Web Develop', '18ab399126e3707207dc.jpg', 30000, '2024-08-08', '2024-08-08', 'A web developer is a technical professional responsible for building applications and websites hosted on the internet, typically working in close collaboration with a graphic designer or product manager to translate programming logic and design ideas into web-compatible code.&nbsp;A web developer is an expert in designing and developing websites. They guarantee that websites satisfy users ’ expectations by ensuring they are aesthetically pleasing, operate without hiccups, and provide quick entry points with no loading difficulties or error messages.', 8, 'Full-time', 'Apokon, Tagum City', 2, 'College Degree', 'BSIT/BSCS/BSIS', 2, 'Driver&#39;s License', '', 0, 'OPEN'),
(32, 52, 'Data Analyst', '8e02899a974e219bef85.png', 40000, '2024-08-08', '2024-10-08', 'Key Responsibilities:Data Collection &amp; Management:Gather and interpret data from various sources, ensuring accuracy and completeness.Maintain and optimize data pipelines and databases.Data Analysis &amp; Interpretation:Conduct thorough data analysis using statistical methods to identify trends, patterns, and insights.Develop and apply models and algorithms to solve business problems.Reporting &amp; Visualization:Create clear and informative reports, dashboards, and visualizations to communicate findings to stakeholders.Present data insights and recommendations to both technical and non-technical audiences.Collaboration:Work with cross-functional teams to understand business needs and translate them into data-driven solutions.Assist in the design and implementation of new data analysis processes and tools.Continuous Improvement:Stay updated with the latest industry trends, technologies, and best practices in data analysis.Identify opportunities for process improvements and propose i', 8, 'Full Time', 'Davao City', 1, 'College Degree', 'Bachelor&#39;s degree in computer science, statistics, or information systems', 5, ' IBM Data Analyst Professional Certificate', '', 0, 'OPEN'),
(33, 52, 'Software Engineer', '90a9f95b102bf26c9421.jpg', 50000, '2024-08-08', '2024-10-15', 'Develops and maintains software applications, writes code, performs debugging, and collaborates with teams to deliver high-quality software solutions.', 8, 'Full-time, office or', 'Technology firms, startups, or remote', 5, 'Bachelor’s degree', 'Computer Science, Software Engineering', 5, 'None', '', 0, 'OPEN'),
(34, 52, 'Registered Nurse', '1470a523511e7e66e9d0.jpg', 20000, '2024-08-08', '2024-11-09', 'Registered Nurses (RNs) provide comprehensive patient care in various healthcare settings, including hospitals and clinics. You will assess patient conditions, administer medications, and perform diagnostic tests. Your responsibilities include monitoring vital signs, documenting patient progress, and collaborating with physicians and other healthcare professionals to develop and implement patient care plans. You will also educate patients and their families about health conditions, treatments, and preventative care strategies.', 8, 'Full-time, shift-bas', 'Tagum City', 15, 'Associate’s or Bachelor’s degree in Nursing', 'Nursing', 1, 'Registered Nurse (RN) license', '', 0, 'OPEN'),
(35, 52, 'Marketing Manager', '028b2eacafc7abb88aec.jpg', 25000, '2024-08-08', '2024-09-08', 'The Marketing Manager oversees the creation and implementation of marketing strategies to promote products or services and drive sales. You will develop comprehensive marketing plans, manage advertising campaigns, and analyze market trends to optimize performance. Your role involves coordinating with creative teams to design promotional materials, managing budgets, and evaluating the effectiveness of marketing activities. You will also work closely with sales teams and senior management to align marketing objectives with business goals.', 8, 'Full-time, office-ba', 'Tagum City', 10, 'Bachelor’s degree', 'Marketing, Business Administration', 5, 'None', '', 0, 'OPEN'),
(36, 52, 'Civil Engineer', '028b2eacafc7abb88aec.jpg', 30000, '2024-08-08', '2024-09-08', 'As a&nbsp;Site Engineer, you will monitor diversified aspects of construction project management. This will include planning, coordination, and supervision of on-site activities.Job Responsibilities:Oversee and manage construction activities at the site, ensuring adherence to project specifications, codes, and safety regulations.Conduct regular site inspections to monitor progress, identify potential issues and ensure compliance with engineering and design requirements.Collaborate closely with project managers, architects, and subcontractors to ensure timely project completion.Analyze and interpret engineering plans, aerial photography, blueprints, topographical &amp; geologic data, and technical drawings to plan and execute construction activities.Maintain accurate project documentation, including progress reports, site diaries, change orders, and quality control measuresJob Qualifications:A bachelor&#39;s degree in Civil EngineeringMust be a licensed civil engineerAt least 2 years of', 8, 'Full-time, site-base', 'Tagum city', 4, 'Bachelor’s degree', 'Civil Engineering', 2, 'Professional Engineer (PE) license', '', 0, 'OPEN'),
(37, 52, 'Data Scientist', 'a520f4611e7f0492ade3.jpg', 60000, '2024-08-08', '2024-09-08', 'Full job descriptionBACHELOR&#39;S DEGREE IN APPLIED ECONOMICS, APPLIED MATHEMATICS, MANAGEMENT OR RELATED SCIENCESEXPERIENCE IN PERFORMING INDUSTRY/ MARKET RESEARCH, DATA ANALYSIS AND FEASIBILITY STUDIESPROFICIENCY IN BUSINESS COMMUNICATIONS (VERBAL &amp; WRITTEN) AND USAGE OF ANALYTICAL TOOLS OR SOFTWAREJob Type: Full-timePay: Php16,000.00 - Php17,000.00 per monthBenefits:Additional leaveHealth insuranceLife insuranceSchedule:8 hour shiftOvertimeSupplemental Pay:13th month salaryBonus payOvertime payAbility to commute/relocate:Panabo, Davao del Norte: Reliably commute or planning to relocate before starting work (Preferred)Education:Bachelor&#39;s (Preferred)Experience:FEASIBILITY STUDIES: 1 year (Preferred)', 8, 'Full-time, office or', 'Tagum City', 8, 'Master’s degree or higher', ' Data Science, Statistics, Computer Science', 3, 'None', '', 0, 'OPEN'),
(38, 52, 'Human Resources Specialist', 'f9983c7b5f778320ae9c.png', 40000, '2024-08-08', '2024-09-08', 'Full job descriptionA. JOB SUMMARYThe HR &amp; Admin Specialist is responsible in handling all personnel issues within the organization, recruit and hire new talent, on board new employees, facilitate processing of compensation and benefits, training and ensure a healthy workplace.He/she shall also manage and ensure efficient and productive use of physical corporate assets to include building space, office furniture and equipment and utilities. Oversees right-sizing, selection and management of agency-hired security services for the company’s facilities and premises, reviews related reports and investigates and resolves any anomalies. Keeps abreast of the general and administrative needs of the company’s various functional units and accordingly plans for and justifies approval for necessary manpower assistance and/or logistical support.B. DUTIES &amp; RESPONSIBILITIESAssist the managers/ supervisors in manpower forecasting and request.Handles end to end Recruitment which includes refer', 8, 'Full-time, office-ba', 'HR Corp', 18, 'Bachelor’s degree', 'Human Resources, Business Administration', 2, 'SHRM-CP or PHR', '', 0, 'OPEN'),
(39, 52, 'Financial Analyst', '958854a061df310095b6.jpg', 30000, '2024-08-08', '2024-09-08', 'Full job descriptionA. Job SummaryUnder the&nbsp;general&nbsp;supervision of the Branch Operations Officer and is directly responsible in the accomplishment of the following key result areas in Branch Accounting Operationsa. KRA 1 Process Efficiency – Checking, Verification, Reconciliation of assigned financial transactionsb. KRA 2 Internal/External Customer Relations Mgt.c. KRA 3 Submission of Management Reports to Branch Operations Officer/Accountant III – SCG (Area_), and Records/Documents/Data Base Management (completeness, reliability, security of records/data base)Job Type: Full-timePay: Php17,000.00 - Php19,000.00 per monthBenefits:Company eventsHealth insuranceLife insuranceOpportunities for promotionPaid trainingPromotion to permanent employeeSchedule:8 hour shiftSupplemental Pay:13th month salaryOvertime payPerformance bonusQuarterly bonusYearly bonusApplication Question(s):Are you a Bachelors in Accounting graduate?Education:Bachelor&#39;s (Preferred)Experience:Accounting re', 8, 'Full-time, office or', 'Tagum City ', 14, 'Bachelor’s degree', 'Finance, Accounting, Economics', 2, 'CFA (optional but beneficial)', '', 0, 'OPEN'),
(40, 52, 'Graphic Designer', 'ffb8de495c721eed1478.png', 40000, '2024-08-08', '2024-09-08', 'Full job descriptionWe have streamlined our application process and it now takes under a minute to apply!AbroadWorks Inc. is a staffing and consulting agency, catering to many companies from various industries all across the United States and Canada, to whom we provide top-notch multi-national talent from across the globe.As a US-based company that specializes in HR Services, AbroadWorks focuses on sourcing talented foreign professionals, for either full-time, part-time, or project-based, remote work.We offer a wide variety of career opportunities for both young and experienced professionals from Virtual/Executive Assistance, to Technical and Creative Writing, and IT-based roles, among others.Apart from the promise of competitive compensation and benefits, our unique talent acquisition process offers a truly exciting opportunity for personal and professional growth, a productive learning experience, and the prospect of working in the safety and comfort of your own home.For this role, o', 8, 'Full-time, office-ba', 'Tagum City', 20, 'Bachelor’s degree', 'Graphic Design, Visual Arts', 2, 'None', '', 0, 'OPEN'),
(41, 41, 'Pediatric Nurse Practitioner', 'a47bc8e4c01463eeced4.webp', 30000, '2024-08-08', '2024-09-08', 'Full job descriptionCOMPANY DESCRIPTIONBrady Pharma Inc. is poised for vertical and horizontal growth since there are major plans for expansions into other therapeutic fields like Cardiology, Nephrology, Anticancer, Orthopedics, Pediatrics, and OB-GYN. Brady caters to more than 3,000 doctors specializing in Dermatology and Ophthalmology. The consumer team of Brady Pharma distributes products to consumers through the retail channels of Mercury, Watsons, SM stores, etc. We have a well-trained, disciplined field force to market the products and a very efficient distribution team to serve the demand generated.A responsible company, conscious of its duty towards various sections of society, Brady Pharma Inc., nurtures young talents, and molds them to suit the current marketing sales trends, so as to satisfy the customer needs and wants with a most stylish and professional approach.ROLE DESCRIPTIONA Professional Medical Representative is a sales Professional working for pharmaceutical or med', 8, 'Full-time, providing', 'Tagum City', 3, 'Master&#39;s Degree', 'Nursing (MSN) with a focus on Pediatrics', 3, 'Nurse Practitioner (NP) license, Pediatric Nursing Certification', '', 0, 'OVERDUE'),
(42, 41, 'Cybersecurity Analyst', '8a0e4e82a08a7afce9ad.png', 50000, '2024-08-08', '2024-09-08', 'Full job description*Permanent Work-from-home/Full-time*As a member of the Security Operations team, the Security Analyst supports our production environment, protecting it from the latest information security threats. The Security Analyst is responsible for developing, improving and executing documented cyber threat management processes. The Security Analyst will focus on real-time security events analysis to protect the organization&#39;s electronic assets. The candidate is experienced with researching the latest security threats and vulnerabilities, identifies weaknesses and exposures. Must be able to perform strong hands-on support and management for a wide range of security technologies including, but not limited to: SIEM, Endpoint Protection products, malware analysis and protection, data loss prevention and vulnerability scanners. The candidate has at least 2 to 3 years of experience in cyber security. Strong self-directed work habits, demonstrating initiative, drive, creativity', 8, 'Full-time, protectin', 'Davao City', 6, 'Bachelor&#39;s Degree', 'Cybersecurity, Information Technology, or related field', 2, 'Certified Information Systems Security Professional (CISSP)', '', 0, 'OVERDUE'),
(43, 41, 'Environmental Scientist', 'ffd2e9d5a4d668259987.jpg', 30000, '2024-08-08', '2024-09-17', 'Environmental Scientist Duties and ResponsibilitiesEnvironmental Scientists have many important duties that they must perform to excel at their job. Their responsibilities include:&nbsp;Collecting and scientifically analyzing soil, air and water samples to determine the level and cause of environmental contamination.Developing solutions to control, fix or prevent environmental problems.Conducting environmental research projects and preparing reports and presentations on their findings.Advising governmental organizations, businesses and the public on potential environmental hazards and health risks.', 8, 'Full-time, conductin', 'Davao City', 4, 'Bachelor&#39;s Degree', 'Environmental Science, Biology, or related field', 1, 'None', '', 0, 'OVERDUE'),
(44, 41, 'Mechanical Engineer', '070b7347c33f96e295ec.jpg', 50000, '2024-08-08', '2024-09-16', 'Full job descriptionEnsure good conditions of company assets such as trucks, service vehicles, truck marshaling, and motor pool facilities to avoid breakdowns that may affect operations.Coordinate and follow up on the allocation and maintenance of the sales fleet.Following up on the trucks reallocation across different branches and tracking their efficiencyResponsible for trucks inspection and check-up to make sure of the vehicles readiness.Planning and undertaking scheduled maintenanceQualifications:Licensed Mechanical/Electrical EngineerWith at least one year of actual work experience in a similar or related positionAbility to generate maintenance and technical reportsAble to provide technical evaluation and proposalsPreferred with driver&#39;s license restrictions 1 and 2Proficient in MS Office (Word, Excel, and PowerPoint)Job Type: Full-timeBenefits:Additional leaveCompany eventsHealth insuranceLife insuranceOpportunities for promotionPaid trainingStaff meals providedTransportation', 8, 'Full-time, designing', 'Tagum City', 6, 'Bachelor&#39;s Degree', 'Mechanical Engineering', 2, ' Professional Engineer (PE) license', '', 0, 'OVERDUE'),
(45, 41, 'High School Math Teacher', 'd0170295b5c7a7b1baad.jpg', 20000, '2024-08-08', '2024-09-16', 'Full job descriptionJob Description:Boost the reputation of the school as an institution dedicated to quality of higher educationIncorporate the School&#39;s mission and core values in relation to the teaching of their subject matters.They must also enhance the school&#39;s standing as an Institution that is devoted to quality education and higher learning.Assist during information campaign in career guidance and about the school in various high schools.Comply with the minimum academic requirements of CHED and the SchoolInculcate respect for duly constituted authority and promote understanding and generosity.Continue learning and observe continuing professional education and developmentObserve fairness, respect and professionalism in dealing with students, colleauge and others.Respect the opinions and ideas from colleauges.Observe discipline in applying and conveying their knowledge.Act as s chairperson or member of any school committee or program as assigned by the Dean or designate.A', 8, 'Full-time, teaching ', 'Tagum City', 7, 'Bachelor&#39;s Degree', 'Education with a focus on Mathematics', 1, 'Teaching Certification', '', 0, 'OVERDUE'),
(46, 41, 'Pharmaceutical Sales Representative', '99c2d6084876587e0738.jpg', 50000, '2024-08-08', '2024-09-17', 'Full job descriptionDuties and Responsibilities:Sell and promote all SAHPC products and services; analyze the territory and market’s potential, track sales and deliver status reports.Present, promote, sell products and services of SAHPC using solid arguments to existing and prospective customers.Handles the collection of accounts receivables.Create and execute effectively the sales and marketing plan.Qualifications:Graduate of any degree course, preferably science-related, business and or marketing.Previous pharmaceutical or healthcare sales and marketing experience in the same field is an advantage.Must be team-oriented, analytical, and highly organized.With excellent communication, problem-solving skills.Has the ability to manage Davao territory.Must know how to drive and with a valid driver&#39;s license.Benefits:Basic monthly salary starts at P18,000, negotiableMeal allowanceCompany car with gas allowanceMonday to Friday work scheduleCompetitive commission schemePerformance BonusJo', 8, 'Full-time, promoting', 'Tagum City', 8, 'Bachelor&#39;s Degree', 'Biology, Chemistry, or related field', 1, 'None', '', 0, 'OVERDUE'),
(47, 41, 'Veterinary Technician', '543eeacd6448650f4d3d.jpg', 30000, '2024-08-08', '2024-09-25', 'Full job descriptionKEY QUALIFICATIONSDegree in Doctor of Veterinary Medicine or Veterinary TechnologyPoultry and livestock practice work experience are an advantage;Fresh graduates are encouraged to apply;Disease diagnosis and medicine prescription and conducts municipal wide seminarsExperience in food animal production/sales/technical is an advantage;Special Skills: has good oral and written skills, computer literate driving skills.Willing to be assigned to:Job SummaryProvides technical support to IFMC clients1) Provides excellent veterinary technical services by giving full support in implementing programs set by the management to achieve better farm performance, management and customer service;2) Conducts regular visits to key direct farms, dealers/megadealers and distributors in the area;3) On time submission of weekly itinerary and complete weekly;4) Conducts municipal/private/semi private seminars to prospect clients in the area;5) Train Technicians to conduct seminars in Brgy l', 8, 'Full-time, assisting', 'Tagum City', 4, 'Associate Degree', 'Veterinary Technology', 1, 'Licensed Veterinary Technician (LVT)', '', 0, 'OVERDUE'),
(48, 41, 'UX/UI Designer', 'e427493ab03addde93fd.png', 30000, '2024-08-08', '2024-09-10', 'Full job descriptionWe are seeking a talented UI/UX Designer to join our creative team. The ideal candidate will have a passion for user-centered design and a keen eye for detail. You will collaborate closely with our product managers, developers, and other stakeholders to create engaging and intuitive user interfaces that enhance the overall user experience.blResponsibilities:Conduct user research and gather feedback to inform design decisions.Create wireframes, prototypes, and high-fidelity mockups to communicate design ideas.Develop and maintain design guidelines and standards to ensure consistency across products.Collaborate with cross-functional teams to define and implement innovative solutions for product direction, visuals, and experience.Iterate on designs based on user feedback and testing to continuously improve the user experience.Stay up-to-date with the latest UI/UX trends, techniques, and technologies.Requirements:Strong portfolio showcasing your design skills and projec', 8, 'Full-time, designing', 'Tagum City', 5, 'Bachelor&#39;s Degree', 'Graphic Design, Interaction Design, or related field', 2, 'None', '', 0, 'OVERDUE'),
(49, 41, 'Full Stock Developer ', '265eac1cbceed8cf0740.jpg', 12, '2024-08-20', '2024-08-28', 'adsfasdfasdfadsfasdf', 12, 'Permanent', 'Tagum City', 12, 'High School Graduate', 'BS COmputer Science', 5, 'Drivers License', '', 0, 'OVERDUE'),
(50, 41, 'IT STAFF  1', '218d31fef32c6a5bd3a6.jpg', 111111, '2024-08-27', '2024-08-31', 'Full job descriptionQuick Sidekick is a dynamic and growing company specializing in handyman services and exterior cleaning. We operate across Canada and the USA, providing top-quality services to residential and commercial clients. We are currently seeking a talented Web Developer with SEO expertise to join our team. This is a remote, home-based position with a vibrant team based largely in Davao, Philippines.1 111', 811, 'Permanent', 'Tagum City 11', 511, 'College Level', 'BS IT 11', 3111, 'None 11', '', 0, 'OVERDUE'),
(51, 53, 'IT TECH', '185ff2bbed0996a402c8.png', 30000, '2024-08-27', '2024-08-31', 'Full job descriptionQuick Sidekick is a dynamic and growing company specializing in handyman services and exterior cleaning. We operate across Canada and the USA, providing top-quality services to residential and commercial clients. We are currently seeking a talented Web Developer with SEO expertise to join our team. This is a remote, home-based position with a vibrant team based largely in Davao, Philippines.', 8, 'Permanent', 'Tagum City Davao Del norte', 10, 'College Level', 'BS IT', 3, 'None', '', 0, 'OPEN'),
(52, 54, 'Quality Assurance Specialist', '2349013195918dfa81f7.jpg', 40000, '2024-08-29', '2024-09-12', 'is in charge of inspecting products at different phases in their development to ensure they meet a set of consistent standards. Their duties include performing visual inspections, recording quality issues and planning processes to decrease the instance of defects in products.', 8, 'Permanent', 'Tagum City', 2, 'College Level', 'BS-IT', 1, 'none', '', 0, 'OPEN'),
(53, 54, 'Graphic Artist', 'ab41c25f46b385bb1ee7.jpg', 25000, '2024-08-29', '2024-09-07', 'The Graphic Designer job description includes the entire process of defining requirements, visualizing and creating graphics including illustrations, logos, layouts and photos. You’ll be the one to shape the visual aspects of websites, books, magazines, product packaging, exhibitions and more.Your graphics should capture the attention of those who see them and communicate the right message. For this, you need to have a creative flair and a strong ability to translate requirements into design. If you can communicate well and work methodically as part of a team, we’d like to meet you.The goal is to inspire and attract the target audience.Requirements and skillsProven graphic designing experienceA strong portfolio of illustrations or other graphicsFamiliarity with design software and technologies (such as InDesign, Illustrator, Dreamweaver, Photoshop)A keen eye for aesthetics and detailsExcellent communication skillsAbility to work methodically and meet deadlinesDegree in Design, Fine Art', 8, 'Permanent', 'Work from Home', 4, 'College Level', 'Any IT related Courses', 1, 'N/a', '', 0, 'OPEN'),
(54, 41, 'Trailer Driver', '2a10b69d64e1aa12da35.png', 30000, '2024-08-30', '2024-08-31', 'Full job descriptionElectroguard Monitoring Philippines is looking for 1-2 Full Time Full Stack Developers in-house. We are located in Araneta City, CubaoCompany Overview:&nbsp;Join our dynamic team as a Full Stack Developer! We are a forward-thinking company committed to innovation and excellence in software development. We provide a collaborative environment where creativity and technology thrive, offering you the opportunity to work on cutting-edge projects that make a real impact.Job Description:&nbsp;As a Full Stack Developer, you will be responsible for designing, developing, and maintaining both front-end and back-end components of our web applications. You will work closely with our product, design, and development teams to build scalable, robust, and high-performing solutions that enhance user experience and meet business objectives.Key Responsibilities:Front-End Development:&nbsp;Create responsive, user-friendly interfaces using modern web technologies (HTML, CSS, JavaScript,', 5, 'Permanent', 'Cebu Pacific ', 5, 'College Graduate', 'None', 5, 'Drivers License Code 8', '', 0, 'OVERDUE'),
(55, 41, 'Scientist ', '0c0874659bfe6e473fcf.png', 20000, '2024-08-30', '2024-08-31', 'Full job descriptionSenior Software EngineerFull TimeRemotePermanentAbout MVSI:Privately held, MVSI provides a broad range of Compliance Verification services to different industries globally. We&#39;re classified as a RegTech, as a FinTech, and as an Outsourcer. Each of our Brands represents the best of technology and human intelligence, designed to deliver turnkey solutions for compliance, productivity, and risk management.Our solutions combine Process, Technology, and People to deliver value, reach, and consistency that individual toolsets cannot. At MVSI, we are targeting global growth and aiming to lead the global market in our sector through our innovative SaaS technology platforms.Job DescriptionThe RoleAs a Senior Software Developer at MVSI, you play a crucial role in our Engineering Team. As a seasoned professional, A Senior Software Engineer is a fully autonomous professional, responsible for improving the technical alignment, health and engineering practices within a team.In', 5, 'Permanent', 'America', 5, 'College Graduate', 'BS Aesronotics', 5, 'Lisensay sa puso mo', '', 0, 'OVERDUE'),
(56, 5, 'asdfasd', '6f2eac7108171792ffc0.png', 0, '0000-00-00', '0000-00-00', 'asdf', 0, 'asdf', 'asdf', 0, 'asdf', 'asdf', 0, 'asdfasdf', '', 0, 'OPEN'),
(57, 55, 'Graphic Artist', '8b4fc0d5fe3e1a24ea14.jpg', 40000, '2024-08-30', '2024-10-05', 'Job briefWe are looking for a Graphic Designer to create engaging and on-brand graphics for a variety of media.What is the role of a Graphic Designer?The Graphic Designer job description includes the entire process of defining requirements, visualizing and creating graphics including illustrations, logos, layouts and photos. You’ll be the one to shape the visual aspects of websites, books, magazines, product packaging, exhibitions and more.Your graphics should capture the attention of those who see them and communicate the right message. For this, you need to have a creative flair and a strong ability to translate requirements into design. If you can communicate well and work methodically as part of a team, we’d like to meet you.The goal is to inspire and attract the target audience.ResponsibilitiesStudy design briefs and determine requirementsSchedule projects and define budget constraintsConceptualize visuals based on requirementsPrepare rough drafts and present ideasDevelop illustra', 8, 'Contractual', 'TAGUM CITY', 2, 'College Level', 'BS-IT', 1, 'N/A', '', 0, 'OPEN'),
(58, 5, 'asdfasd', '', 0, '0000-00-00', '0000-00-00', 'asdf', 0, 'asdf', 'asdf', 0, 'asdf', 'asdf', 0, 'asdfasdf', '', 0, 'OPEN'),
(59, 41, 'Bagger', '2c41d9bb5060261a93a2.jpg', 10000, '2024-09-10', '2024-09-14', 'asdfasdfasdfasdfasdfasdfasdf', 12, 'Contractual', 'Tagum City', 5, 'High School Graduate', 'High School lang bai', 5, 'None', '', 0, 'OVERDUE'),
(60, 41, 'Jeep Drivery', 'd4edd62162fc60b530c1.png', 10000, '2024-09-12', '2024-09-15', 'Driver responsibilities include&nbsp;arranging regular cleaning and maintenance services for the vehicle, planning each route based on road and traffic conditions&nbsp;...', 2, 'Permanent', 'Quiapo to Bansalan', 5, 'College Graduate', 'N/A', 5, 'Drivers License', '', 0, 'OVERDUE'),
(61, 41, 'Project Manager', 'eae02ce3b57c4da8ec47.png', 10000, '2024-09-12', '2024-09-15', 'What Are the Responsibilities of a Project Manager?Plan and Develop the Project Idea. Every project starts as an idea. ...Create and Lead Your Dream Team. ...Monitor Project Progress and Set Deadlines. ...Solve Issues That Arise. ...Manage the Money. ...Ensure Stakeholder Satisfaction. ...Evaluate Project Performance.', 2, 'Permanent', 'Tagum City Davao Manil', 5, 'College Graduate', 'BS Accounting', 5, 'None', '', 0, 'OVERDUE'),
(62, 41, 'Civil Enginner', 'f82a5d2a410cda9aa227.png', 50000, '2024-09-25', '2024-09-15', 'Analyzing survey reports, long-range plans, maps and other data to design new projectsConsidering budget, regulations and environmental hazards during risk-analysis stagePreparing material, equipment and labor cost estimates and confirming costs are within the budgetForecasting design and construction timelineCompleting and submitting all permit applications to the appropriate agencies and ensuring projects are compliant throughout the design and construction stagesOverseeing soil testing to establish soil strength and building feasibilityUsing design software to create project drawings and renderingsManaging repair and maintenance of infrastructure projects', 5, 'Permanent', 'Manila', 5, 'College Graduate', 'BS Engineering', 5, 'N/A', '', 0, 'OVERDUE');

-- --------------------------------------------------------

--
-- Table structure for table `tbllogin`
--

CREATE TABLE `tbllogin` (
  `ID` int(11) NOT NULL,
  `Login` varchar(255) NOT NULL,
  `Password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbllogin`
--

INSERT INTO `tbllogin` (`ID`, `Login`, `Password`) VALUES
(42, 'joemarie123', '$2y$10$tamO3rgtpTpWRc2vmpEjtuSL9MNoOO/ltL/A26QdvuoR.3Jmewz5i'),
(43, 'jogz123', '$2y$10$BdGgyB2TcVeTeU/Vcc40/u2EGt848lq24vj5pHkHZgF4ioWullFFq'),
(44, 'jiren123', '$2y$10$qPJW9CfoKwnSDxo1x990euVFEBeVaXkn1rzAT3aUpLSFgfZipU.bu'),
(51, 'cat', '$2y$10$7var/JokyCDjLX7GzO8yWerE1iOFXVJHrT0OpnqCd.LScJcvHSx4q'),
(57, 'honeyw', '$2y$10$iMfJP4C//iGscQs/gqgzFuqJrc4EW5k1IN740Ba5vN.3KbzFlwzqa'),
(58, 'go123', '$2y$10$.AieemuMKgsd4otMh9MQLOoJm.yP3VejeUkh/LuU8rlWS/ooTGdvC'),
(59, 'joemarie123', '$2y$10$x/LclByukuTgjXnx/aTm/e8eJ0fxcnn2HueLn1jvCT9AdapPTtzWG'),
(60, 'Nichols', '$2y$10$AshG3JaYtd6.TaW4Rzygue98OzeNbC5Itzp1JT13WPMIaMn9y2LK6'),
(61, 'james123', '$2y$10$qt5if8tF0bdetfcwIaUbPeH5y6qP6oaC841ZhloM6Xuf8r4U8uTAi'),
(62, 'pixie', '$2y$10$cRunckmpqGI51LvJSnA3tOgx8bIUe2pLIa4HdhAjZSN2beGaWqj/e'),
(63, 'gxdx', '$2y$10$n/wjSqyHAZkhtf6s8n1Qo.UKsLxRBB5lF8bxl4D2bgaHoQr5NsUKq'),
(64, 'pixiecath', '$2y$10$o865XPlux5ctUeLV/Shcb.vVViTm8Fkc0ccLaRuVEVLd1kufqN3Y2'),
(65, 'james112233', '$2y$10$X15YR.wDgbMNr4t3ORnbY.GDkwJPvruIRFI4zjiX2BPnKdFf2kvx6'),
(66, 'admin1', '$2y$10$.scflf6P44S0DucIA8ehk.6TZ/hsUvdGQh9vuSNtHNyHkQzizpWsO'),
(67, 'applicant1', '$2y$10$TgfsnGI.qbNUmzkal8qbQuL0.apm4qI0/2zuecSWyn2Kr0efaG6P.'),
(68, 'Jogz', '$2y$10$m5yZTITVLaNLGcUwmEPxyO.jmfMZzw47vvXZJ0Acy3zIukJ4jvpwu'),
(69, 'admin2', '$2y$10$.jJC/PJcU9M.iwZ/1cBwA.LI85S3aEIQet9wnFJ8IgsV7Entfngha'),
(70, 'hazel123', '$2y$10$JuN/onb848iLyoDAcx8TUOdUf4fBs4WIQjQDUwRsYSalX9MWoFE/e'),
(71, 'jiren', '$2y$10$hsSIQ87J0FAW408GHRF3Wei2Uc/8blFQPzUHgvNCx6mOqDXt.bg.e'),
(72, 'james123456', '$2y$10$oomuZ1l8iCD8hrJIJb.uaeOWZLQB.XqTdRE.NXNtzfXB/ulGLXy.S'),
(73, 'alex123', '$2y$10$aWcvNURPHEiu5bUyw.5RhubcE6C211.DBtx.L3.F1ONbvfg5ywJ72');

-- --------------------------------------------------------

--
-- Table structure for table `tblotp`
--

CREATE TABLE `tblotp` (
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblotp`
--

INSERT INTO `tblotp` (`email`, `pass`, `timestamp`) VALUES
('annjogz@gmail.com', '$2y$10$HrclksNbfQLuRcp8fHO.z.qoWmVLXwNNLlx7o5YaYcgMbQJZ3OK1C', '2024-07-04 08:40:18'),
('honeymarjey@gmail.com', '$2y$10$ZkmYSJQD/WdA7ekK4bYZ..gjUV9K.l2RUTcoHd1qMTKFI/ECTPtxW', '2024-07-04 12:58:43');

-- --------------------------------------------------------

--
-- Table structure for table `tblpersonal`
--

CREATE TABLE `tblpersonal` (
  `ControlNo` varchar(50) DEFAULT '',
  `Surname` varchar(50) DEFAULT '',
  `Firstname` varchar(50) DEFAULT '',
  `MIddlename` varchar(50) DEFAULT '',
  `Suffix` varchar(5) NOT NULL,
  `Sex` varchar(50) DEFAULT '',
  `CivilStatus` varchar(50) DEFAULT '',
  `MaidenName` varchar(50) DEFAULT '',
  `SpouseName` varchar(50) DEFAULT '',
  `Occupation` varchar(50) DEFAULT '',
  `TINNo` varchar(50) DEFAULT '',
  `GSISNo` varchar(50) DEFAULT '',
  `PAGIBIGNo` varchar(50) DEFAULT '',
  `SSSNo` varchar(50) DEFAULT '',
  `PHEALTHNo` varchar(50) DEFAULT '',
  `Citizenship` varchar(50) DEFAULT '',
  `Religion` varchar(50) DEFAULT '',
  `BirthDate` date DEFAULT curdate(),
  `BirthPlace` varchar(100) DEFAULT '',
  `Heights` float DEFAULT 0,
  `Weights` float DEFAULT 0,
  `BloodType` varchar(50) DEFAULT '',
  `Address` varchar(100) DEFAULT '',
  `TelNo` varchar(50) DEFAULT '',
  `FatherName` varchar(50) DEFAULT '',
  `FatherBirth` varchar(50) DEFAULT '',
  `MotherName` varchar(50) DEFAULT '',
  `MotherBirth` varchar(50) DEFAULT '',
  `Skills` varchar(250) DEFAULT '',
  `Qualifications` varchar(250) DEFAULT '',
  `Q1` varchar(50) DEFAULT '',
  `R11` varchar(250) DEFAULT '',
  `Q11` varchar(50) DEFAULT '',
  `R1` varchar(250) DEFAULT '',
  `Q2` varchar(50) DEFAULT '',
  `Q22` varchar(50) DEFAULT '',
  `R2` varchar(250) DEFAULT '',
  `Q3` varchar(50) DEFAULT '',
  `R3` varchar(250) DEFAULT '',
  `Q4` varchar(50) DEFAULT '',
  `R4` varchar(250) DEFAULT '',
  `Q5` varchar(50) DEFAULT '',
  `R5` varchar(250) DEFAULT '',
  `Q6` varchar(50) DEFAULT '',
  `R6` varchar(250) DEFAULT '',
  `Q7` varchar(50) DEFAULT '',
  `R7` varchar(250) DEFAULT '',
  `Tax` varchar(50) DEFAULT '',
  `DateRegistered` date DEFAULT curdate(),
  `Pics` varchar(500) DEFAULT '',
  `PMID` bigint(20) NOT NULL,
  `LoginID` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `ContactNo` varchar(50) NOT NULL,
  `EmailAdd` varchar(50) DEFAULT NULL,
  `CellphoneNo` varchar(50) DEFAULT NULL,
  `SpouseFirstname` varchar(50) DEFAULT NULL,
  `SpouseMiddlename` varchar(50) DEFAULT NULL,
  `SpouseEmployer` text DEFAULT NULL,
  `SpouseEmpAddress` text DEFAULT NULL,
  `SpouseEmpTel` varchar(50) DEFAULT NULL,
  `FatherFirstname` varchar(50) DEFAULT NULL,
  `FatherMiddlename` varchar(50) DEFAULT NULL,
  `MotherFirstname` varchar(50) DEFAULT NULL,
  `MotherMiddlename` varchar(50) DEFAULT NULL,
  `IP` varchar(50) DEFAULT NULL,
  `IPR` text DEFAULT NULL,
  `PWD` varchar(50) DEFAULT NULL,
  `PWDR` text DEFAULT NULL,
  `SoloP` varchar(50) DEFAULT NULL,
  `SoloPR` text DEFAULT NULL,
  `Rhouse` text DEFAULT NULL,
  `Rstreet` text DEFAULT NULL,
  `Rsubdivision` text DEFAULT NULL,
  `Rbarangay` text DEFAULT NULL,
  `Rcity` text DEFAULT NULL,
  `Rprovince` text DEFAULT NULL,
  `Rregion` varchar(50) DEFAULT NULL,
  `Rzip` varchar(50) DEFAULT NULL,
  `Pregion` varchar(50) DEFAULT NULL,
  `Phouse` text DEFAULT NULL,
  `Pstreet` text DEFAULT NULL,
  `Psubdivision` text DEFAULT NULL,
  `Pbarangay` text DEFAULT NULL,
  `Pcity` varchar(50) DEFAULT NULL,
  `Pprovince` varchar(50) DEFAULT NULL,
  `Pzip` varchar(50) DEFAULT NULL,
  `local` bit(1) DEFAULT NULL,
  `localdetails` text DEFAULT NULL,
  `country` bit(1) DEFAULT NULL,
  `countrydetails` varchar(50) DEFAULT NULL,
  `datefiled` varchar(50) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `citizenshipStatus` varchar(50) DEFAULT NULL,
  `birthcountry` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tblpersonal`
--

INSERT INTO `tblpersonal` (`ControlNo`, `Surname`, `Firstname`, `MIddlename`, `Suffix`, `Sex`, `CivilStatus`, `MaidenName`, `SpouseName`, `Occupation`, `TINNo`, `GSISNo`, `PAGIBIGNo`, `SSSNo`, `PHEALTHNo`, `Citizenship`, `Religion`, `BirthDate`, `BirthPlace`, `Heights`, `Weights`, `BloodType`, `Address`, `TelNo`, `FatherName`, `FatherBirth`, `MotherName`, `MotherBirth`, `Skills`, `Qualifications`, `Q1`, `R11`, `Q11`, `R1`, `Q2`, `Q22`, `R2`, `Q3`, `R3`, `Q4`, `R4`, `Q5`, `R5`, `Q6`, `R6`, `Q7`, `R7`, `Tax`, `DateRegistered`, `Pics`, `PMID`, `LoginID`, `Email`, `ContactNo`, `EmailAdd`, `CellphoneNo`, `SpouseFirstname`, `SpouseMiddlename`, `SpouseEmployer`, `SpouseEmpAddress`, `SpouseEmpTel`, `FatherFirstname`, `FatherMiddlename`, `MotherFirstname`, `MotherMiddlename`, `IP`, `IPR`, `PWD`, `PWDR`, `SoloP`, `SoloPR`, `Rhouse`, `Rstreet`, `Rsubdivision`, `Rbarangay`, `Rcity`, `Rprovince`, `Rregion`, `Rzip`, `Pregion`, `Phouse`, `Pstreet`, `Psubdivision`, `Pbarangay`, `Pcity`, `Pprovince`, `Pzip`, `local`, `localdetails`, `country`, `countrydetails`, `datefiled`, `gender`, `citizenshipStatus`, `birthcountry`) VALUES
('0000000001', NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '052a4955122c47dd41af.jpg', 0, 0, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0000000002', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 57, '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0000000003', 'Nazareno', 'Dennis', 'M.', '1', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-13', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-13', '', 3, 63, 'd.nazareno091002@gmail.com', '09614268007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0000000004', 'Tanaid', 'Cathlyn', 'Andilab', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-13', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-13', '', 4, 64, 'c.tanaid.129095.tc@umindanao.edu.ph', '09108585132', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0000000000', 'roble', 'neil benjamin', 'paña', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-29', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-29', '', 5, 67, 'neilroble125@gmail.com', '09053113438', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0000000000', 'Mahusay', 'Jograd', 'Mascariñas', '1', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-29', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-29', '', 6, 68, 'Rptasbtas@gmail.com', '09123456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('0000000000', 'Koy', 'Jiren', 'Bankoy', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-09-18', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-09-18', '', 7, 71, 'asdfasd@gmail.com', '0951514545', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Triggers `tblpersonal`
--
DELIMITER $$
CREATE TRIGGER `before_insert_tblpersonal` BEFORE INSERT ON `tblpersonal` FOR EACH ROW BEGIN
    SET NEW.ControlNo = LPAD(NEW.PMID, 10, '0');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblreschedule`
--

CREATE TABLE `tblreschedule` (
  `ID` int(11) NOT NULL,
  `Appointment_ID` int(11) NOT NULL,
  `Appointment_date` date NOT NULL,
  `Appointment_time` time NOT NULL,
  `Active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblreschedule`
--

INSERT INTO `tblreschedule` (`ID`, `Appointment_ID`, `Appointment_date`, `Appointment_time`, `Active`) VALUES
(4, 106, '2024-09-23', '15:14:00', 0),
(5, 106, '2024-09-30', '06:30:00', 0),
(6, 106, '2024-09-28', '17:52:00', 0),
(7, 106, '2024-09-27', '00:00:00', 0),
(8, 106, '2024-09-28', '17:52:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbltags`
--

CREATE TABLE `tbltags` (
  `ID` int(11) NOT NULL,
  `Job_ID` int(11) NOT NULL,
  `Tags` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbltags`
--

INSERT INTO `tbltags` (`ID`, `Job_ID`, `Tags`) VALUES
(6, 29, ''),
(7, 30, ''),
(8, 31, ''),
(9, 32, ''),
(10, 33, ''),
(11, 34, ''),
(12, 35, ''),
(13, 36, ''),
(14, 37, ''),
(15, 38, ''),
(16, 39, ''),
(17, 40, ''),
(18, 41, ''),
(19, 42, ''),
(20, 43, ''),
(21, 44, ''),
(22, 45, ''),
(23, 46, ''),
(24, 47, ''),
(25, 48, ''),
(40, 51, 'IT Staff'),
(41, 51, 'IT tech'),
(42, 52, 'QA'),
(43, 52, 'IT'),
(44, 52, 'COMPUTER SCIENCE'),
(45, 52, 'CALL CENTER'),
(46, 53, 'WFH'),
(47, 53, 'REMOTE'),
(48, 53, 'GRAPHIC ARTIST'),
(49, 53, 'EDITOR'),
(50, 53, 'VISUAL DESIGNER'),
(51, 53, 'LAYOUT ARTIST'),
(52, 53, 'ARTIST'),
(53, 54, 'trailer driver'),
(54, 54, 'driver'),
(55, 54, 'driver nga hawod mo luto'),
(56, 55, 'scietific method'),
(60, 57, 'IT'),
(61, 57, 'GRAPHIC ARTIST'),
(62, 57, 'LAYOUT ARTIST'),
(63, 57, 'EDITORS'),
(68, 49, 'java script'),
(69, 49, 'web developer'),
(70, 49, 'front end developer'),
(71, 49, 'back end developer'),
(72, 49, 'programmer'),
(80, 50, 'it staff'),
(81, 50, 'it tech'),
(82, 50, 'computer tech'),
(83, 50, 'fasasdfads'),
(84, 50, '1111'),
(85, 59, 'bagger'),
(86, 59, 'tig alsa'),
(87, 60, 'driver'),
(88, 60, 'sweet driver'),
(89, 61, 'manager'),
(90, 61, 'project'),
(91, 62, 'civil engineering'),
(92, 62, 'enginner');

-- --------------------------------------------------------

--
-- Table structure for table `xchildren`
--

CREATE TABLE `xchildren` (
  `ControlNo` varchar(50) DEFAULT '',
  `ChildName` varchar(100) DEFAULT '',
  `BirthDate` datetime DEFAULT NULL,
  `PMID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xchildren`
--

INSERT INTO `xchildren` (`ControlNo`, `ChildName`, `BirthDate`, `PMID`) VALUES
('0000000002', 'king kong', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xcivilservice`
--

CREATE TABLE `xcivilservice` (
  `ControlNo` varchar(50) DEFAULT '',
  `Codes` varchar(50) DEFAULT '',
  `CivilServe` varchar(150) DEFAULT '',
  `Dates` varchar(50) DEFAULT '',
  `Rates` float DEFAULT 0,
  `Place` varchar(200) DEFAULT '',
  `PMID` bigint(20) NOT NULL,
  `LNumber` varchar(50) DEFAULT '',
  `LDate` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xcivilservice`
--

INSERT INTO `xcivilservice` (`ControlNo`, `Codes`, `CivilServe`, `Dates`, `Rates`, `Place`, `PMID`, `LNumber`, `LDate`) VALUES
('0000000002', '102', 'LET', '2024-12-12', 88, 'Davao', 154, '657', '2024-12-12'),
('0000000002', '101', 'CS', '2024-12-12', 95, 'Tagum', 2154, '1245', '2024-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `xeducation`
--

CREATE TABLE `xeducation` (
  `Education` varchar(50) DEFAULT '',
  `School` varchar(200) DEFAULT '',
  `Codes` varchar(50) DEFAULT '',
  `Degree` varchar(200) DEFAULT '',
  `NumUnits` float DEFAULT NULL,
  `YearLevel` varchar(50) DEFAULT '',
  `DateAttend` varchar(50) DEFAULT '',
  `Honors` varchar(50) DEFAULT '',
  `Graduated` varchar(50) DEFAULT '',
  `Orders` int(11) DEFAULT NULL,
  `ControlNo` varchar(50) DEFAULT '',
  `PMID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xeducation`
--

INSERT INTO `xeducation` (`Education`, `School`, `Codes`, `Degree`, `NumUnits`, `YearLevel`, `DateAttend`, `Honors`, `Graduated`, `Orders`, `ControlNo`, `PMID`) VALUES
('College', 'Panabo School', '2', 'BS IT', 10, '2', '22', '', 'Yes', NULL, '0000000002', 1),
('Elementary', 'Manga Elementary School', '', '', NULL, '', '2010', '', 'Yes', NULL, '0000000002', 2),
('Junior High School', 'Tagum Trade School', '', '', NULL, '', '2012', '', 'Yes', NULL, '0000000002', 3),
('Senior High School', 'Tagum Trade School', '', '', NULL, '', '2013', '', 'Yes', NULL, '0000000002', 4);

-- --------------------------------------------------------

--
-- Table structure for table `xexperience`
--

CREATE TABLE `xexperience` (
  `ID` bigint(20) NOT NULL,
  `CONTROLNO` varchar(50) DEFAULT '',
  `WFrom` varchar(50) DEFAULT '',
  `WTo` varchar(50) DEFAULT '',
  `WPosition` varchar(200) DEFAULT '',
  `WCompany` varchar(200) DEFAULT '',
  `WSalary` float DEFAULT 0,
  `WGrade` varchar(50) DEFAULT '',
  `Status` varchar(50) DEFAULT '',
  `WGov` varchar(5) DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xexperience`
--

INSERT INTO `xexperience` (`ID`, `CONTROLNO`, `WFrom`, `WTo`, `WPosition`, `WCompany`, `WSalary`, `WGrade`, `Status`, `WGov`) VALUES
(1, '0000000002', '2022', '2024', 'Web Developer', 'City Hall of Tagum', 12000, 'N/A', 'Job Order', '2'),
(2, '0000000002', '2020', '2022', 'Back End Developer', 'Hexat Corporation', 16000, 'N/A', 'Permanent', 'NO'),
(3, '0000000002', '2000', '2005', 'Truck Driver', 'Tagum Motr Club', 15000, 'N/A', 'Regular', 'NO'),
(4, '0000000002', '2035', '2045', 'Programmer', 'American Company', 15000, 'N/A', 'Casual', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `xngo`
--

CREATE TABLE `xngo` (
  `ID` bigint(20) NOT NULL,
  `CONTROLNO` varchar(50) DEFAULT '',
  `OrgName` text DEFAULT '',
  `DateFrom` date DEFAULT NULL,
  `DateTo` date DEFAULT NULL,
  `NoHours` varchar(50) DEFAULT '',
  `OrgPosition` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `xnonacademic`
--

CREATE TABLE `xnonacademic` (
  `ID` bigint(20) NOT NULL,
  `ControlNo` varchar(50) DEFAULT '',
  `NonAcademic` varchar(500) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xnonacademic`
--

INSERT INTO `xnonacademic` (`ID`, `ControlNo`, `NonAcademic`) VALUES
(1, '0000000002', 'Kini daw'),
(2, '0000000002', 'wow bai');

-- --------------------------------------------------------

--
-- Table structure for table `xorganization`
--

CREATE TABLE `xorganization` (
  `ID` bigint(20) NOT NULL,
  `ControlNo` varchar(50) DEFAULT '',
  `Organization` varchar(150) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xorganization`
--

INSERT INTO `xorganization` (`ID`, `ControlNo`, `Organization`) VALUES
(1, '0000000002', 'pak genern'),
(2, '0000000002', 'wow kaayu bai');

-- --------------------------------------------------------

--
-- Table structure for table `xpwd`
--

CREATE TABLE `xpwd` (
  `ID` bigint(20) NOT NULL,
  `Controlno` varchar(50) DEFAULT NULL,
  `chronic` tinyint(1) DEFAULT NULL,
  `Psychosocial` tinyint(1) DEFAULT NULL,
  `Orthopedic` tinyint(1) DEFAULT NULL,
  `Communication` tinyint(1) DEFAULT NULL,
  `Learning` tinyint(1) DEFAULT NULL,
  `Mental` tinyint(1) DEFAULT NULL,
  `Visual` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `xreference`
--

CREATE TABLE `xreference` (
  `ControlNo` varchar(50) DEFAULT '',
  `Names` varchar(150) DEFAULT '',
  `Address` varchar(150) DEFAULT '',
  `TelNo` varchar(50) DEFAULT '',
  `PMID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xreference`
--

INSERT INTO `xreference` (`ControlNo`, `Names`, `Address`, `TelNo`, `PMID`) VALUES
('0000000002', 'Kim Jhong On', 'Tagum', '029390', 223),
('0000000002', 'Duterte', 'Davao', '30230', 4222);

-- --------------------------------------------------------

--
-- Table structure for table `xskills`
--

CREATE TABLE `xskills` (
  `ID` bigint(20) NOT NULL,
  `ControlNo` varchar(50) DEFAULT '',
  `Skills` varchar(150) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xskills`
--

INSERT INTO `xskills` (`ID`, `ControlNo`, `Skills`) VALUES
(1, '0000000002', 'PRogramming'),
(2, '0000000002', 'Editing');

-- --------------------------------------------------------

--
-- Table structure for table `xtrainings`
--

CREATE TABLE `xtrainings` (
  `ControlNo` varchar(50) DEFAULT '',
  `Training` text DEFAULT NULL,
  `Dates` varchar(50) DEFAULT '',
  `NumHours` float DEFAULT 0,
  `Conductor` varchar(200) DEFAULT '',
  `PMID` bigint(20) NOT NULL,
  `DateFrom` varchar(50) DEFAULT '',
  `DateTo` varchar(50) DEFAULT '',
  `type` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xtrainings`
--

INSERT INTO `xtrainings` (`ControlNo`, `Training`, `Dates`, `NumHours`, `Conductor`, `PMID`, `DateFrom`, `DateTo`, `type`) VALUES
('0000000002', 'basket ball', '2024-12-12', 4, 'wow', 2323, '2024-12-12', '2024-12-12', 'dfdf'),
('0000000002', 'volley bal', '2024-12-12', 24, 'we', 23234, '2024-12-12', '2024-12-12', 'adsf');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblapplication`
--
ALTER TABLE `tblapplication`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblappointment`
--
ALTER TABLE `tblappointment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblappointmenthistory`
--
ALTER TABLE `tblappointmenthistory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcompany`
--
ALTER TABLE `tblcompany`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbljobs`
--
ALTER TABLE `tbljobs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbllogin`
--
ALTER TABLE `tbllogin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblotp`
--
ALTER TABLE `tblotp`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `tblpersonal`
--
ALTER TABLE `tblpersonal`
  ADD PRIMARY KEY (`PMID`);

--
-- Indexes for table `tblreschedule`
--
ALTER TABLE `tblreschedule`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbltags`
--
ALTER TABLE `tbltags`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xchildren`
--
ALTER TABLE `xchildren`
  ADD PRIMARY KEY (`PMID`);

--
-- Indexes for table `xcivilservice`
--
ALTER TABLE `xcivilservice`
  ADD PRIMARY KEY (`PMID`);

--
-- Indexes for table `xeducation`
--
ALTER TABLE `xeducation`
  ADD PRIMARY KEY (`PMID`);

--
-- Indexes for table `xexperience`
--
ALTER TABLE `xexperience`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xngo`
--
ALTER TABLE `xngo`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xnonacademic`
--
ALTER TABLE `xnonacademic`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xorganization`
--
ALTER TABLE `xorganization`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xpwd`
--
ALTER TABLE `xpwd`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xreference`
--
ALTER TABLE `xreference`
  ADD PRIMARY KEY (`PMID`);

--
-- Indexes for table `xskills`
--
ALTER TABLE `xskills`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `xtrainings`
--
ALTER TABLE `xtrainings`
  ADD PRIMARY KEY (`PMID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblapplication`
--
ALTER TABLE `tblapplication`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `tblappointment`
--
ALTER TABLE `tblappointment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `tblappointmenthistory`
--
ALTER TABLE `tblappointmenthistory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblcompany`
--
ALTER TABLE `tblcompany`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tbljobs`
--
ALTER TABLE `tbljobs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tbllogin`
--
ALTER TABLE `tbllogin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tblpersonal`
--
ALTER TABLE `tblpersonal`
  MODIFY `PMID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblreschedule`
--
ALTER TABLE `tblreschedule`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbltags`
--
ALTER TABLE `tbltags`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `xchildren`
--
ALTER TABLE `xchildren`
  MODIFY `PMID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `xcivilservice`
--
ALTER TABLE `xcivilservice`
  MODIFY `PMID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2155;

--
-- AUTO_INCREMENT for table `xeducation`
--
ALTER TABLE `xeducation`
  MODIFY `PMID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `xexperience`
--
ALTER TABLE `xexperience`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `xngo`
--
ALTER TABLE `xngo`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xnonacademic`
--
ALTER TABLE `xnonacademic`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xorganization`
--
ALTER TABLE `xorganization`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xpwd`
--
ALTER TABLE `xpwd`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xreference`
--
ALTER TABLE `xreference`
  MODIFY `PMID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4223;

--
-- AUTO_INCREMENT for table `xskills`
--
ALTER TABLE `xskills`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `xtrainings`
--
ALTER TABLE `xtrainings`
  MODIFY `PMID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23235;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
