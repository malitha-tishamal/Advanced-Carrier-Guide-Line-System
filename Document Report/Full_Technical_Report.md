# 🚀 Technical Project Report: Advanced Career Guideline System (Eduwide)

## 📋 1. Project Overview
The **Advanced Career Guideline System** (Eduwide) is an intelligent, role-based platform designed to bridge the gap between academia and the professional industry. It connects **Admins, Lecturers, Students (Active & Former), and Companies** in a unified ecosystem focused on career development, talent discovery, and data-driven guidance.

### 🎯 Key Objectives
- **Centralized Talent Hub**: A comprehensive database of students and alumni with verified skills.
- **Intelligent Career Matching**: Automatically suggest the best candidates to companies using a powerful AI-based proprietary scoring algorithm.
- **Professional Growth Tracking**: Monitor student progress through education, projects, and certifications.
- **Strategic Insights**: Provide analytics to administrators and lecturers to improve academic outcomes.

---

## 🛠️ 2. System Architecture & Tech Stack

### 💻 Frontend
- **Structure**: HTML5, Semantic HTML.
- **Styling**: CSS3, Bootstrap 5 Framework, Custom Modern Aesthetics (Glassmorphism, Vibrant Gradients).
- **Interactivity**: JavaScript (ES6+), jQuery.
- **Data Visualization**: ApexCharts, ECharts, Chart.js (for analytics dashboards).
- **Iconography**: Bootstrap Icons, Boxicons, Remix Icons.

### ⚙️ Backend
- **Core Logic**: PHP (Procedural).
- **Session Management**: Native PHP Sessions for secure role-based access.
- **Database Interaction**: MySQLi (Prepared Statements) for security against SQL injection.

### 🗄️ Database
- **Engine**: MariaDB / MySQL.
- **Schema**: 20+ tables covering users, skills (2700+ entries), education, experiences, and projects.

---

## 👥 3. Modules & User Roles

### 👑 Admin Module
*The central control unit of the system.*
- **User Governance**: Approve/Reject and manage accounts for Lecturers, Students, and Companies.
- **Content Management**: Manage the massive skills database (13+ categories), courses, and batches.
- **System Monitoring**: Access global activity logs and audit trails.
- **Strategic Analytics**: High-level dashboards showing registration trends, skill distribution, and system performance.

### 🧑‍🏫 Lecturer Module
*Focused on academic and career mentorship.*
- **Profile Auditing**: Review and verify student/alumni professional profiles.
- **Guidance System**: Access student project history and achievements to provide personalized career advice.
- **Performance Evaluation**: Track student growth over time based on academic records and external certifications.

### 🎓 Active & Former Student Modules
*The profile showcase engine.*
- **Professional Timeline**: Dynamic interfaces for Education, Work Experience, and Project history.
- **Skill Management**: Tagging system integrated with the 2700+ skill database.
- **Portfolio Showcase**: Upload and display project photos, links (GitHub/LinkedIn), and descriptions.
- **Achievements & Certifications**: Dedicated sections for verified awards and professional certificates.

### 🏢 Company Module
*The talent discovery platform.*
- **AI Talent Search**: Advanced multi-filter system supporting up to 20 skill filters simultaneously.
- **Match Quality Indicators**: View "Excellent" (80%+), "Good", or "Average" matches at a glance.
- **Direct Recruitment**: Efficiently identify candidates by batch, course, and specific technical expertise.

---

## 🧠 4. Core Technical Features

### 🧠 Powerful AI-Based Suggestion Matching Algorithm
The system's "brain" is an advanced AI-powered `CandidateMatcher` engine. It utilizes a sophisticated, machine-learning inspired weighted scoring matrix (0-100) to evaluate and predict the best candidates:

| Category | Weight | Logic |
| :--- | :--- | :--- |
| **Education Match** | 20 pts | Favors recent graduates and higher degrees (Masters/PhD). |
| **Skills Match** | 30 pts | Weighted categories (IT/Eng = 1.2x). Diversity bonus for multiple categories. |
| **Experience Level** | 25 pts | Analyzes role complexity (Senior vs Junior) and company reputation. |
| **Profile Completeness** | 15 pts | Rewards profiles with photos, bios, and full project histories. |
| **Social Presence** | 10 pts | Verified professional links (LinkedIn, GitHub, Portfolios). |

### 🛠️ Professional Profile System
- **Responsive Card UI**: Modern card-based layouts for easy browsing.
- **Interactive Timelines**: Vertical timelines for education and work history.
- **Media Integration**: Support for project image galleries and external portfolio links.

### 📊 Dynamic Skill Database
- **Large Scale**: Over 2700+ skills pre-loaded.
- **Categorization**: Skills are grouped into IT, Engineering, Finance, Agriculture, Management, etc.
- **Auto-Suggest**: Real-time filtering during profile updates.

---

## 🗃️ 5. Database Design (Key Tables)

- **`users` / `admins` / `companies` / `lecturers`**: Core authentication and profile data.
- **`former_students` / `students`**: Role-specific student details (Batch, Reg ID).
- **`education`**: Linked to users, storing school, degree, and dates.
- **`experiences`**: Stores employment history, job roles, and locations.
- **`active_student_projects`**: Detailed project records with media links.
- **`[Category]_skills`**: Master tables for different skill taxonomies (e.g., `engineering_skills`, `it_student_skills`).
- **`student_skills`**: Mapping table connecting students to their expertise.

---

## 🎨 6. UI/UX Design Aesthetics
- **Color Palette**: Royal Blue (#0d6efd) primary with deep charcoal and clean white surfaces.
- **Typography**: Modern sans-serif (Inter/Open Sans) for high readability.
- **Visual Feedback**: Hover animations, smooth transitions, and dynamic progress bars for match scores.
- **Responsibility**: Fully mobile-responsive layout using Bootstrap Grid System.

---

## 🚀 7. Installation & Deployment
1. **Server Requirements**: Apache/Nginx with PHP 7.4+ and MySQL 5.7+.
2. **Setup**:
   - Clone the repository to `htdocs` (XAMPP) or `www` (WAMP).
   - Create a database named `eduwide`.
   - Import `Database/if0_38329700_eduwide.sql`.
   - Configure `includes/db-conn.php` with your database credentials.
3. **Login**: Use the credentials provided in the `README.md` for different role testing.

---
*Report generated for Eduwide Career Guideline System.*
