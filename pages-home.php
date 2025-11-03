<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EDUWIDE | Career Guidance System</title>
  <link rel="icon"  href="assets\images\logos/favicon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4361ee;
      --primary-dark: #3a56d4;
      --secondary: #7209b7;
      --accent: #4cc9f0;
      --accent-light: #7bdff2;
      --dark: #1a1a2e;
      --light: #f8f9fa;
      --gray: #6c757d;
      --success: #4bb543;
      --shadow: 0 10px 30px rgba(0,0,0,0.08);
      --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f5f7ff 0%, #eef1f9 100%);
      color: var(--dark);
      line-height: 1.6;
      min-height: 100vh;
      overflow-x: hidden;
    }

    .container { max-width: 1400px; margin: 0 auto; padding: 0 20px; }

    /* Header */
    header {
      padding: 20px 0;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      transition: var(--transition);
      background: rgba(255,255,255,0.9);
      backdrop-filter: blur(10px);
      box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header.scrolled { padding: 15px 0; box-shadow: 0 5px 20px rgba(0,0,0,0.1); }

    .logo-container { display: flex; align-items: center; }
    .logo {
      width: 50px; height: 50px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      margin-right: 15px;
      box-shadow: 0 8px 20px rgba(67,97,238,0.3);
      animation: float 6s ease-in-out infinite;
    }
    .logo i { font-size: 24px; color: white; }
    .brand { display: flex; flex-direction: column; }
    .brand-name { font-size: 24px; font-weight: 700; color: var(--dark); letter-spacing: -0.5px; }
    .brand-tagline { font-size: 12px; color: var(--gray); font-weight: 500; }

    nav ul { display: flex; list-style: none; }
    nav li { margin-left: 30px; }
    nav a {
      text-decoration: none; color: var(--dark); font-weight: 500; font-size: 16px;
      position: relative; transition: var(--transition);
    }
    nav a:hover { color: var(--primary); }
    nav a::after {
      content: '';
      position: absolute; bottom: -5px; left: 0; width: 0; height: 2px;
      background: var(--primary); transition: var(--transition);
    }
    nav a:hover::after { width: 100%; }

    .auth-buttons { display: flex; gap: 15px; }
    .btn-outline {
      padding: 10px 20px; border-radius: 50px; font-weight: 600; font-size: 14px;
      cursor: pointer; transition: var(--transition); text-decoration: none;
      display: inline-flex; align-items: center; justify-content: center;
      border: 2px solid var(--primary); color: var(--primary); background: transparent;
    }
    .btn-outline:hover { background: var(--primary); color: white; }

    .mobile-menu-btn {
      display: none;
      font-size: 24px;
      cursor: pointer;
      color: var(--dark);
    }
    nav ul.mobile-active { display: flex; flex-direction: column; position: absolute; top: 70px; right: 20px; background: white; padding: 20px; border-radius: 12px; box-shadow: var(--shadow); }

    /* Hero Section */
    .hero { min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; padding: 100px 0 50px; flex-wrap: wrap; }
    .hero-content { max-width: 600px; z-index: 10; position: relative; }
    .hero h1 { font-size: 56px; font-weight: 800; line-height: 1.1; margin-bottom: 20px; color: var(--dark); }
    .hero p { font-size: 18px; color: var(--gray); margin-bottom: 30px; }
    .highlight { color: var(--primary); font-weight: 700; }
    .cta-buttons { display: flex; gap: 15px; margin-bottom: 40px; }
    .btn {
      padding: 14px 30px; border-radius: 50px; font-weight: 600; font-size: 16px;
      cursor: pointer; transition: var(--transition); text-decoration: none;
      display: inline-flex; align-items: center; justify-content: center; border: none;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      background-size: 200% 200%;
      color: white;
      transition: all 0.5s;
    }
    .btn-primary:hover {
      background-position: right center;
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(67,97,238,0.3);
    }

    .hero-visual { position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 50%; height: 80%; z-index: 1; }

    .floating-card {
      position: absolute; background: white; border-radius: 20px; box-shadow: var(--shadow);
      padding: 20px; width: 200px; transition: var(--transition); animation: float 5s ease-in-out infinite;
    }
    .floating-card:nth-child(1) { top: 10%; right: 20%; animation-delay: 0s; }
    .floating-card:nth-child(2) { top: 40%; right: 10%; animation-delay: 1s; }
    .floating-card:nth-child(3) { top: 70%; right: 25%; animation-delay: 2s; }
    .floating-card:hover { transform: translateY(-10px) scale(1.05); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }

    .card-icon { width: 50px; height: 50px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; margin-bottom: 15px; }
    .card-icon i { font-size: 24px; color: white; }
    .card-title { font-weight: 600; margin-bottom: 5px; color: var(--dark); }
    .card-text { font-size: 14px; color: var(--gray); }

    .circle { position: absolute; border-radius: 50%; opacity: 0.1; z-index: -1; }
    .circle-1 { width: 500px; height: 500px; background: linear-gradient(135deg, var(--primary), var(--secondary)); top: -100px; right: -100px; animation: pulse 8s ease-in-out infinite; }
    .circle-2 { width: 300px; height: 300px; background: linear-gradient(135deg, var(--accent), var(--secondary)); bottom: -50px; right: 200px; animation: pulse 6s ease-in-out infinite reverse; }

    /* Features Section */
    .features { padding: 100px 0; background: white; position: relative; overflow: hidden; opacity: 0; transform: translateY(50px); transition: var(--transition); }
    .features.visible { opacity: 1; transform: translateY(0); }

    .section-header { text-align: center; margin-bottom: 60px; }
    .section-title { font-size: 42px; font-weight: 700; color: var(--dark); margin-bottom: 15px; }
    .section-subtitle { font-size: 18px; color: var(--gray); max-width: 600px; margin: 0 auto; }
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }

    .feature-card {
      background: white; border-radius: 20px; padding: 40px 30px; box-shadow: var(--shadow);
      transition: var(--transition); position: relative; overflow: hidden; z-index: 1;
    }
    .feature-card::before {
      content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      transform: scaleX(0); transition: var(--transition); transform-origin: left;
    }
    .feature-card:hover::before { transform: scaleX(1); }
    .feature-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    .feature-icon { width: 70px; height: 70px; border-radius: 18px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; margin-bottom: 25px; box-shadow: 0 8px 20px rgba(67,97,238,0.3); }
    .feature-icon i { font-size: 30px; color: white; }
    .feature-title { font-size: 22px; font-weight: 600; margin-bottom: 15px; color: var(--dark); }
    .feature-description { color: var(--gray); font-size: 16px; }

    /* Animations */
    @keyframes float {
      0%, 100% { transform: translateY(0) rotate(0deg); opacity: 1; }
      50% { transform: translateY(-15px) rotate(3deg); opacity: 0.9; }
    }
    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.1; }
      50% { transform: scale(1.1); opacity: 0.2; }
    }

    /* Responsive */
    @media (max-width: 576px) {
      nav ul { display: none; }
      .mobile-menu-btn { display: block; }
      .hero h1 { font-size: 36px; }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo-container">
      <div class="logo"><i class="fas fa-graduation-cap"></i></div>
      <div class="brand">
        <span class="brand-name">EDUWIDE</span>
        <span class="brand-tagline">Career Guidance System</span>
      </div>
    </div>
   
    <div class="auth-buttons">
      <a href="index.php" class="btn-outline">Login</a>
    </div>
    <div class="mobile-menu-btn"><i class="fas fa-bars"></i></div>
  </header>

  <!-- Hero Section -->
  <section class="hero">

    <div class="container hero-content">
              <img src="assets\images\logos\favicon.png" width="300px">
      <h1>Welcome to <span class="highlight">EDUWIDE</span></h1>
      <br>

      <p>A smart platform that connects <span class="highlight">active and former SLIATE students</span> with profiles, skills, projects, education, and work experience. Our algorithm suggests and highlights top-performing students.</p>
      
    </div>
    <div class="hero-visual">
      <div class="floating-card">
        <div class="card-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="card-title">Profile Analysis</div>
        <div class="card-text">View education, skills, projects, and work experience of students</div>
      </div>
      <div class="floating-card">
        <div class="card-icon"><i class="fas fa-briefcase"></i></div>
        <div class="card-title">Career Matching</div>
        <div class="card-text">Algorithm-based suggestions for suitable career paths</div>
      </div>
      <div class="floating-card">
        <div class="card-icon"><i class="fas fa-chart-line"></i></div>
        <div class="card-title">Top Student Suggestions</div>
        <div class="card-text">Identify the best students and match them with opportunities</div>
      </div>
      <div class="circle circle-1"></div>
      <div class="circle circle-2"></div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features" id="features">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Features</h2>
        <p class="section-subtitle">EDUWIDE offers powerful tools for students, companies, and educators to connect and find the right opportunities based on academic and skill data.</p>
      </div>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-user-graduate"></i></div>
          <h3 class="feature-title">Student Profiles</h3>
          <p class="feature-description">Detailed student profiles with skills, projects, and education history.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-lightbulb"></i></div>
          <h3 class="feature-title">Career Insights</h3>
          <p class="feature-description">career suggestions based on academic performance and experience.</p>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-briefcase"></i></div>
          <h3 class="feature-title">Company Connections</h3>
          <p class="feature-description">Connect top-performing students with potential employers and internships.</p>
        </div>
      </div>
    </div>
  </section>

  <script>
    // Mobile menu toggle
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const navUl = document.querySelector('nav ul');

    menuBtn.addEventListener('click', () => {
      navUl.classList.toggle('mobile-active');
    });

    // Scroll-triggered animations
    const sections = document.querySelectorAll('.features');
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if(entry.isIntersecting) entry.target.classList.add('visible');
      });
    }, { threshold: 0.2 });

    sections.forEach(section => observer.observe(section));

    // Header scroll effect
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
      if(window.scrollY > 50) header.classList.add('scrolled');
      else header.classList.remove('scrolled');
    });
  </script>
</body>
</html>
