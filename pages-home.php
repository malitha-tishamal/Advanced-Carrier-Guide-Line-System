
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="assets/images/logos/favicon.png">
  <title>EDUWIDE | Advanced Career Guidance System</title>
  <link rel="icon" href="assets/images/logos/favicon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4361ee;
      --primary-dark: #3a56d4;
      --primary-light: #4895ef;
      --secondary: #7209b7;
      --secondary-light: #9d4edd;
      --accent: #4cc9f0;
      --accent-light: #7bdff2;
      --success: #4bb543;
      --warning: #ff9f1c;
      --danger: #e63946;
      --info: #4361ee;
      --dark: #1a1a2e;
      --darker: #0d0d1a;
      --light: #f8f9fa;
      --gray: #6c757d;
      --gray-light: #e9ecef;
      --shadow: 0 10px 30px rgba(0,0,0,0.08);
      --shadow-heavy: 0 20px 50px rgba(0,0,0,0.15);
      --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
      --border-radius: 16px;
      --glass-bg: rgba(255, 255, 255, 0.08);
      --glass-border: rgba(255, 255, 255, 0.1);
    }

    /* Light Theme Variables */
    [data-theme="light"] {
      --dark: #f8f9fa;
      --darker: #ffffff;
      --light: #1a1a2e;
      --gray: #495057;
      --gray-light: #343a40;
      --glass-bg: rgba(0, 0, 0, 0.05);
      --glass-border: rgba(0, 0, 0, 0.1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0c0c1e 0%, #1a1a3e 50%, #2d2d5e 100%);
      color: var(--light);
      line-height: 1.6;
      min-height: 100vh;
      overflow-x: hidden;
      position: relative;
      transition: var(--transition);
    }

    [data-theme="light"] body {
      background: linear-gradient(135deg, #f0f2f5 0%, #ffffff 50%, #e9ecef 100%);
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 80%, rgba(67, 97, 238, 0.15) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(114, 9, 183, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(76, 201, 240, 0.1) 0%, transparent 50%);
      z-index: -1;
      transition: var(--transition);
    }

    [data-theme="light"] body::before {
      background: 
        radial-gradient(circle at 20% 80%, rgba(67, 97, 238, 0.08) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(114, 9, 183, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(76, 201, 240, 0.05) 0%, transparent 50%);
    }

    .container { 
      max-width: 1400px; 
      margin: 0 auto; 
      padding: 0 20px; 
    }

    /* Theme Toggle Button */
    .theme-toggle {
      position: relative;
      width: 60px;
      height: 30px;
      border-radius: 50px;
      background: rgba(67, 97, 238, 0.1);
      border: 2px solid rgba(67, 97, 238, 0.2);
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 5px;
      margin-left: 15px;
      backdrop-filter: blur(5px);
    }

    .theme-toggle:hover {
      border-color: var(--primary);
      background: rgba(67, 97, 238, 0.2);
    }

    .theme-toggle::before {
      content: '';
      position: absolute;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      transition: var(--transition);
      left: 3px;
    }

    [data-theme="light"] .theme-toggle::before {
      transform: translateX(30px);
      background: linear-gradient(135deg, var(--warning), #ff9f1c);
    }

    .theme-toggle i {
      font-size: 14px;
      z-index: 1;
      transition: var(--transition);
    }

    .theme-toggle .fa-sun {
      color: #ff9f1c;
    }

    .theme-toggle .fa-moon {
      color: #4361ee;
    }

    /* Header */
    header {
      padding: 20px 0;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      transition: var(--transition);
      background: rgba(13, 13, 26, 0.85);
      backdrop-filter: blur(15px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    [data-theme="light"] header {
      background: rgba(255, 255, 255, 0.85);
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    header.scrolled { 
      padding: 15px 0; 
      background: rgba(13, 13, 26, 0.95);
      box-shadow: 0 5px 30px rgba(0, 0, 0, 0.2);
    }

    [data-theme="light"] header.scrolled {
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
    }

    .logo-container { 
      display: flex; 
      align-items: center; 
      gap: 15px;
    }
    .logo {
      width: 50px; 
      height: 50px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      border-radius: 12px;
      display: flex; 
      align-items: center; 
      justify-content: center;
      box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
      animation: float 6s ease-in-out infinite;
      position: relative;
      overflow: hidden;
    }
    .logo::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, transparent, rgba(255,255,255,0.2), transparent);
      transform: translateX(-100%);
      animation: shimmer 3s infinite;
    }
    .logo i { 
      font-size: 24px; 
      color: white; 
      z-index: 1;
    }
    .brand { 
      display: flex; 
      flex-direction: column; 
    }
    .brand-name { 
      font-size: 24px; 
      font-weight: 800; 
      background: linear-gradient(135deg, var(--primary-light), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: -0.5px; 
    }
    .brand-tagline { 
      font-size: 12px; 
      color: var(--gray-light); 
      font-weight: 500; 
    }

    nav ul { 
      display: flex; 
      list-style: none; 
      gap: 30px;
    }
    nav li { 
      position: relative; 
    }
    nav a {
      text-decoration: none; 
      color: var(--gray-light); 
      font-weight: 500; 
      font-size: 15px;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 8px 0;
    }
    nav a:hover { 
      color: var(--light); 
    }
    nav a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
      transition: var(--transition);
    }
    nav a:hover::after {
      width: 100%;
    }
    nav a i {
      font-size: 14px;
    }

    .auth-buttons { 
      display: flex; 
      gap: 15px; 
      align-items: center;
    }
    .btn-outline {
      padding: 10px 22px; 
      border-radius: 50px; 
      font-weight: 600; 
      font-size: 14px;
      cursor: pointer; 
      transition: var(--transition); 
      text-decoration: none;
      display: inline-flex; 
      align-items: center; 
      justify-content: center;
      border: 2px solid rgba(67, 97, 238, 0.3);
      color: var(--primary-light);
      background: rgba(67, 97, 238, 0.1);
      gap: 8px;
      backdrop-filter: blur(5px);
    }
    .btn-outline:hover { 
      background: rgba(67, 97, 238, 0.2);
      border-color: var(--primary);
      color: var(--light);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
    }

    .btn {
      padding: 14px 32px; 
      border-radius: 50px; 
      font-weight: 600; 
      font-size: 15px;
      cursor: pointer; 
      transition: var(--transition); 
      text-decoration: none;
      display: inline-flex; 
      align-items: center; 
      justify-content: center; 
      border: none;
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
      gap: 10px;
      position: relative;
      overflow: hidden;
    }
    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
      transform: translateX(-100%);
    }
    .btn:hover::before {
      animation: shimmer 0.6s;
    }
    .btn-primary {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
    }
    .btn-primary:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(67, 97, 238, 0.3);
      background: linear-gradient(135deg, var(--primary-light), var(--secondary-light));
    }

    .btn-gradient {
      background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent));
      background-size: 200% 200%;
      color: white;
      animation: gradientShift 3s ease infinite;
    }
    .btn-gradient:hover {
      animation: gradientShift 1s ease infinite;
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(67, 97, 238, 0.4);
    }

    .mobile-menu-btn {
      display: none;
      font-size: 24px;
      cursor: pointer;
      color: var(--light);
      background: rgba(67, 97, 238, 0.1);
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: none;
      align-items: center;
      justify-content: center;
      border: 1px solid rgba(67, 97, 238, 0.2);
    }

    /* Hero Section */
    .hero { 
      min-height: 100vh; 
      display: flex; 
      align-items: center; 
      position: relative; 
      overflow: hidden; 
      padding: 150px 0 50px; 
    }
    .hero-content { 
      max-width: 700px; 
      z-index: 10; 
      position: relative; 
    }
    .hero h1 { 
      font-size: 60px; 
      font-weight: 900; 
      line-height: 1.1; 
      margin-bottom: 20px; 
      background: linear-gradient(135deg, var(--light) 0%, var(--primary-light) 50%, var(--accent) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    .hero h2 {
      font-size: 32px;
      font-weight: 600;
      margin-bottom: 30px;
      color: var(--gray-light);
    }
    .hero p { 
      font-size: 18px; 
      color: var(--gray-light); 
      margin-bottom: 40px; 
      max-width: 600px;
      line-height: 1.8;
    }
    .highlight { 
      background: linear-gradient(135deg, var(--primary-light), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: 700; 
    }
    .cta-buttons { 
      display: flex; 
      gap: 20px; 
      margin-bottom: 60px; 
      flex-wrap: wrap;
    }
    
    .hero-visual { 
      position: absolute; 
      right: 0; 
      top: 50%; 
      transform: translateY(-50%); 
      width: 50%; 
      height: 80%; 
      z-index: 1; 
    }

    .floating-card {
      position: absolute; 
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      border-radius: 20px; 
      box-shadow: var(--shadow);
      padding: 25px; 
      width: 240px; 
      transition: var(--transition); 
      animation: float 5s ease-in-out infinite;
      border: 1px solid var(--glass-border);
      overflow: hidden;
    }
    .floating-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
    }
    .floating-card:nth-child(1) { 
      top: 10%; 
      right: 20%; 
      animation-delay: 0s; 
    }
    .floating-card:nth-child(2) { 
      top: 40%; 
      right: 10%; 
      animation-delay: 1s; 
    }
    .floating-card:nth-child(3) { 
      top: 70%; 
      right: 25%; 
      animation-delay: 2s; 
    }
    .floating-card:hover { 
      transform: translateY(-15px) scale(1.05); 
      background: rgba(255, 255, 255, 0.1);
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
      border-color: var(--glass-border);
    }

    [data-theme="light"] .floating-card {
      background: rgba(255, 255, 255, 0.7);
      border: 1px solid rgba(0, 0, 0, 0.1);
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    [data-theme="light"] .floating-card:hover {
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .card-icon { 
      width: 60px; 
      height: 60px; 
      border-radius: 16px; 
      background: linear-gradient(135deg, var(--primary), var(--secondary)); 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      margin-bottom: 20px; 
      box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
      position: relative;
      overflow: hidden;
    }
    .card-icon::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, transparent, rgba(255,255,255,0.2), transparent);
      transform: translateX(-100%);
    }
    .floating-card:hover .card-icon::after {
      animation: shimmer 0.8s;
    }
    .card-icon i { 
      font-size: 28px; 
      color: white; 
      z-index: 1;
    }
    .card-title { 
      font-weight: 700; 
      margin-bottom: 10px; 
      color: var(--light); 
      font-size: 20px;
    }
    .card-text { 
      font-size: 14px; 
      color: var(--gray-light); 
      line-height: 1.6;
    }

    .stats {
      display: flex;
      gap: 40px;
      flex-wrap: wrap;
      margin-top: 40px;
    }
    .stat-item {
      text-align: center;
    }
    .stat-number {
      font-size: 40px;
      font-weight: 800;
      background: linear-gradient(135deg, var(--primary-light), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 5px;
      text-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .stat-label {
      color: var(--gray-light);
      font-size: 14px;
      font-weight: 500;
    }

    /* System Overview */
    .system-overview {
      padding: 100px 0;
      position: relative;
    }
    
    .section-header { 
      text-align: center; 
      margin-bottom: 80px; 
    }
    .section-title { 
      font-size: 48px; 
      font-weight: 800; 
      margin-bottom: 20px; 
      background: linear-gradient(135deg, var(--light) 0%, var(--primary-light) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .section-subtitle { 
      font-size: 18px; 
      color: var(--gray-light); 
      max-width: 700px; 
      margin: 0 auto; 
      line-height: 1.8;
    }
    
    .overview-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 30px;
      margin-top: 50px;
    }
    
    .overview-card {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      border-radius: var(--border-radius);
      padding: 40px 30px;
      box-shadow: var(--shadow);
      transition: var(--transition);
      border: 1px solid var(--glass-border);
      position: relative;
      overflow: hidden;
    }
    
    [data-theme="light"] .overview-card {
      background: rgba(255, 255, 255, 0.7);
      border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .overview-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 5px;
      height: 100%;
      background: linear-gradient(to bottom, var(--primary), var(--secondary));
    }
    
    .overview-card:hover {
      transform: translateY(-10px);
      background: rgba(255, 255, 255, 0.08);
      box-shadow: var(--shadow-heavy);
      border-color: var(--glass-border);
    }
    
    [data-theme="light"] .overview-card:hover {
      background: rgba(255, 255, 255, 0.9);
    }
    
    .overview-card h3 {
      font-size: 24px;
      margin-bottom: 20px;
      color: var(--light);
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .overview-card h3 i {
      color: var(--accent);
      font-size: 28px;
    }
    
    .overview-card p {
      color: var(--gray-light);
      margin-bottom: 20px;
      line-height: 1.7;
    }
    
    .overview-card ul {
      padding-left: 20px;
      margin-bottom: 20px;
    }
    
    .overview-card li {
      margin-bottom: 12px;
      color: var(--gray-light);
      line-height: 1.6;
    }
    
    .highlight-list {
      color: var(--accent-light) !important;
      font-weight: 600;
    }

    /* User Roles */
    .user-roles {
      padding: 100px 0;
      background: radial-gradient(circle at center, rgba(26, 26, 46, 0.8) 0%, rgba(13, 13, 26, 0.9) 100%);
      position: relative;
    }
    
    [data-theme="light"] .user-roles {
      background: radial-gradient(circle at center, rgba(240, 242, 245, 0.8) 0%, rgba(255, 255, 255, 0.9) 100%);
    }
    
    .roles-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      margin-top: 40px;
    }
    
    .role-card {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      border-radius: var(--border-radius);
      padding: 35px 25px;
      box-shadow: var(--shadow);
      transition: var(--transition);
      text-align: center;
      position: relative;
      overflow: hidden;
      border: 1px solid var(--glass-border);
    }
    
    [data-theme="light"] .role-card {
      background: rgba(255, 255, 255, 0.7);
      border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .role-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
    }
    
    .role-card:hover {
      transform: translateY(-10px);
      background: rgba(255, 255, 255, 0.08);
      box-shadow: var(--shadow-heavy);
      border-color: var(--glass-border);
    }
    
    [data-theme="light"] .role-card:hover {
      background: rgba(255, 255, 255, 0.9);
    }
    
    .role-icon {
      width: 80px;
      height: 80px;
      border-radius: 20px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 25px;
      color: white;
      font-size: 32px;
      box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
      position: relative;
      overflow: hidden;
    }
    .role-icon::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, transparent, rgba(255,255,255,0.2), transparent);
      transform: translateX(-100%);
    }
    .role-card:hover .role-icon::after {
      animation: shimmer 0.8s;
    }
    
    .role-title {
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 15px;
      color: var(--light);
    }
    
    .role-description {
      color: var(--gray-light);
      font-size: 15px;
      line-height: 1.6;
      margin-bottom: 20px;
    }
    
    .role-features {
      margin-top: 20px;
      text-align: left;
      font-size: 14px;
      color: var(--gray-light);
    }
    
    .role-features li {
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 5px 0;
    }
    .role-features li i {
      color: var(--accent);
    }

    /* Features */
    .features { 
      padding: 100px 0; 
      position: relative; 
      overflow: hidden; 
    }
    
    .features-grid { 
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); 
      gap: 30px; 
    }

    .feature-card {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      border-radius: 20px; 
      padding: 40px 30px; 
      box-shadow: var(--shadow);
      transition: var(--transition); 
      position: relative; 
      overflow: hidden; 
      z-index: 1;
      border: 1px solid var(--glass-border);
    }
    
    [data-theme="light"] .feature-card {
      background: rgba(255, 255, 255, 0.7);
      border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .feature-card::before {
      content: ''; 
      position: absolute; 
      top: 0; 
      left: 0; 
      width: 100%; 
      height: 5px;
      background: linear-gradient(90deg, var(--primary), var(--secondary), var(--accent));
      transform: scaleX(0); 
      transition: var(--transition); 
      transform-origin: left;
    }
    .feature-card:hover::before { 
      transform: scaleX(1); 
    }
    .feature-card:hover { 
      transform: translateY(-10px); 
      background: rgba(255, 255, 255, 0.08);
      box-shadow: var(--shadow-heavy);
      border-color: var(--glass-border);
    }
    
    [data-theme="light"] .feature-card:hover {
      background: rgba(255, 255, 255, 0.9);
    }
    
    .feature-icon { 
      width: 80px; 
      height: 80px; 
      border-radius: 20px; 
      background: linear-gradient(135deg, var(--primary), var(--secondary)); 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      margin-bottom: 30px; 
      box-shadow: 0 10px 30px rgba(67,97,238,0.3);
      position: relative;
      overflow: hidden;
    }
    .feature-icon::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, transparent, rgba(255,255,255,0.2), transparent);
      transform: translateX(-100%);
    }
    .feature-card:hover .feature-icon::after {
      animation: shimmer 0.8s;
    }
    .feature-icon i { 
      font-size: 36px; 
      color: white; 
      z-index: 1;
    }
    .feature-title { 
      font-size: 24px; 
      font-weight: 700; 
      margin-bottom: 20px; 
      color: var(--light); 
    }
    .feature-description { 
      color: var(--gray-light); 
      font-size: 16px; 
      line-height: 1.8;
    }

    /* AI Section */
    .ai-section {
      padding: 100px 0;
      background: linear-gradient(135deg, rgba(26, 26, 46, 0.9) 0%, rgba(13, 13, 26, 0.95) 100%);
      position: relative;
      overflow: hidden;
    }
    
    [data-theme="light"] .ai-section {
      background: linear-gradient(135deg, rgba(240, 242, 245, 0.9) 0%, rgba(255, 255, 255, 0.95) 100%);
    }
    
    .ai-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 30% 70%, rgba(67, 97, 238, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 70% 30%, rgba(114, 9, 183, 0.1) 0%, transparent 50%);
      z-index: -1;
    }
    
    .ai-section .section-title {
      color: var(--light);
    }
    
    .ai-section .section-subtitle {
      color: var(--gray-light);
    }
    
    .ai-features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 30px;
      margin-top: 50px;
    }
    
    .ai-card {
      background: var(--glass-bg);
      backdrop-filter: blur(10px);
      border-radius: var(--border-radius);
      padding: 35px 30px;
      border: 1px solid var(--glass-border);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }
    
    [data-theme="light"] .ai-card {
      background: rgba(255, 255, 255, 0.7);
      border: 1px solid rgba(0, 0, 0, 0.1);
    }
    
    .ai-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 5px;
      height: 100%;
      background: linear-gradient(to bottom, var(--primary), var(--accent));
    }
    
    .ai-card:hover {
      background: rgba(255, 255, 255, 0.08);
      transform: translateY(-10px);
      border-color: var(--glass-border);
      box-shadow: var(--shadow-heavy);
    }
    
    [data-theme="light"] .ai-card:hover {
      background: rgba(255, 255, 255, 0.9);
    }
    
    .ai-card h3 {
      font-size: 24px;
      margin-bottom: 20px;
      color: var(--light);
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .ai-card h3 i {
      color: var(--accent);
      font-size: 28px;
    }
    
    .ai-card p {
      color: var(--gray-light);
      line-height: 1.8;
      margin-bottom: 20px;
    }
    
    .match-score {
      display: inline-block;
      padding: 8px 20px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 14px;
      margin-top: 15px;
      border: none;
      background: rgba(255, 255, 255, 0.1);
    }
    
    .excellent {
      background: linear-gradient(135deg, rgba(75, 181, 67, 0.2), rgba(75, 181, 67, 0.4));
      color: #4bb543;
      border: 1px solid rgba(75, 181, 67, 0.3);
    }
    
    .good {
      background: linear-gradient(135deg, rgba(255, 159, 28, 0.2), rgba(255, 159, 28, 0.4));
      color: #ff9f1c;
      border: 1px solid rgba(255, 159, 28, 0.3);
    }
    
    .average {
      background: linear-gradient(135deg, rgba(230, 57, 70, 0.2), rgba(230, 57, 70, 0.4));
      color: #e63946;
      border: 1px solid rgba(230, 57, 70, 0.3);
    }

    /* Footer */
    footer {
      background: rgba(13, 13, 26, 0.95);
      color: white;
      padding: 80px 0 30px;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
      position: relative;
    }
    
    [data-theme="light"] footer {
      background: rgba(255, 255, 255, 0.95);
      color: var(--dark);
      border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .footer-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 40px;
      margin-bottom: 50px;
    }
    
    .footer-column h3 {
      font-size: 22px;
      margin-bottom: 30px;
      color: var(--light);
      position: relative;
      padding-bottom: 15px;
    }
    
    .footer-column h3::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
    }
    
    .footer-links {
      list-style: none;
    }
    
    .footer-links li {
      margin-bottom: 15px;
    }
    
    .footer-links a {
      color: var(--gray-light);
      text-decoration: none;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .footer-links a:hover {
      color: var(--light);
      transform: translateX(5px);
    }
    
    .social-icons {
      display: flex;
      gap: 15px;
      margin-top: 25px;
    }
    
    .social-icons a {
      width: 45px;
      height: 45px;
      border-radius: 12px;
      background: var(--glass-bg);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--light);
      font-size: 18px;
      transition: var(--transition);
      border: 1px solid var(--glass-border);
    }
    
    .social-icons a:hover {
      background: rgba(67, 97, 238, 0.2);
      transform: translateY(-5px);
      border-color: var(--primary);
    }
    
    .copyright {
      text-align: center;
      padding-top: 30px;
      border-top: 1px solid var(--glass-border);
      color: var(--gray-light);
      font-size: 14px;
    }

    /* Animations */
    @keyframes float {
      0%, 100% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(5deg); }
    }
    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.1; }
      50% { transform: scale(1.05); opacity: 0.2; }
    }
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    @keyframes shimmer {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    /* Responsive */
    @media (max-width: 1200px) {
      .hero-visual {
        opacity: 0.3;
        right: -100px;
      }
    }
    
    @media (max-width: 992px) {
      .hero-visual {
        display: none;
      }
      
      .hero-content {
        max-width: 100%;
        text-align: center;
      }
      
      .hero h1 {
        font-size: 48px;
      }
      
      .hero h2 {
        font-size: 28px;
      }
      
      .cta-buttons {
        justify-content: center;
      }
      
      .stats {
        justify-content: center;
      }
    }
    
    @media (max-width: 768px) {
      nav ul { 
        display: none; 
      }
      .mobile-menu-btn { 
        display: flex; 
      }
      .hero h1 { 
        font-size: 40px; 
      }
      .hero h2 {
        font-size: 24px;
      }
      .section-title {
        font-size: 36px;
      }
      
      .theme-toggle {
        display: none;
      }
      
      .mobile-auth {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
        padding: 20px 0 0;
        border-top: 1px solid var(--glass-border);
      }
      
      nav ul.mobile-active { 
        display: flex; 
        flex-direction: column; 
        position: absolute; 
        top: 80px; 
        right: 20px; 
        background: rgba(13, 13, 26, 0.95);
        backdrop-filter: blur(20px);
        padding: 25px; 
        border-radius: 16px; 
        box-shadow: var(--shadow-heavy); 
        width: 280px;
        border: 1px solid var(--glass-border);
        gap: 0;
      }
      
      [data-theme="light"] nav ul.mobile-active {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(0, 0, 0, 0.1);
      }
      
      nav ul.mobile-active li {
        margin: 0;
        padding: 12px 0;
        border-bottom: 1px solid var(--glass-border);
      }
      
      nav ul.mobile-active li:last-child {
        border-bottom: none;
      }
      
      .features-grid,
      .overview-container,
      .roles-container,
      .ai-features {
        grid-template-columns: 1fr;
      }
      
      .cta-buttons {
        flex-direction: column;
        align-items: center;
      }
      
      .btn, .btn-outline {
        width: 100%;
        max-width: 300px;
      }
      
      .mobile-theme-toggle {
        display: flex !important;
        width: 100%;
        justify-content: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--glass-border);
      }
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
        <span class="brand-tagline">Advanced Career Guidance System</span>
      </div>
    </div>
    
    <nav>
      <ul>
        <li><a href="#overview"><i class="fas fa-info-circle"></i> System Overview</a></li>
        <li><a href="#roles"><i class="fas fa-users"></i> User Roles</a></li>
        <li><a href="#features"><i class="fas fa-cogs"></i> Features</a></li>
        <li><a href="#ai"><i class="fas fa-robot"></i> Intelligent Matching</a></li>
      </ul>
    </nav>
    
    <div class="auth-buttons">
      <a href="index.php" class="btn-outline"><i class="fas fa-sign-in-alt"></i> Login</a>
      <a href="pages-signup.php" class="btn-outline"><i class="fas fa-user-plus"></i> Register</a>
      <div class="theme-toggle" id="themeToggle">
        <i class="fas fa-sun"></i>
        <i class="fas fa-moon"></i>
      </div>
    </div>
    <div class="mobile-menu-btn"><i class="fas fa-bars"></i></div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container hero-content">
      <h1>Welcome to EDUWIDE</h1>
      <h2>Advanced Career Guidance System</h2>
      <br>
      <p>A comprehensive platform connecting <span class="highlight">active and former students</span> with intelligent algorithm for career matching, skill analysis, and employer connections. Our system provides detailed profiles, skill tracking, and intelligent suggestions for students, lecturers, and companies.</p>
      
      <div class="cta-buttons">
        <a href="#overview" class="btn btn-gradient"><i class="fas fa-rocket"></i> Explore System</a>
        <a href="login.php" class="btn-outline"><i class="fas fa-user-graduate"></i> Student Login</a>
        <a href="login.php" class="btn-outline"><i class="fas fa-briefcase"></i> Company Login</a>
      </div>
      
      <div class="stats">
        <div class="stat-item">
          <div class="stat-number">5</div>
          <div class="stat-label">User Roles</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">2700+</div>
          <div class="stat-label">Skills Database</div>
        </div>
        <div class="stat-item">
<div class="stat-number">Smart Engine</div>
<div class="stat-label">Intelligent algorithm</div>

        </div>
        <!--div class="stat-item">
          <div class="stat-number">100+</div>
          <div class="stat-label">Top Student Suggestions</div>
        </div-->
      </div>
    </div>
    
    <div class="hero-visual">
      <div class="floating-card">
        <div class="card-icon"><i class="fas fa-user-shield"></i></div>
        <div class="card-title">Admin Dashboard</div>
        <div class="card-text">Full system control with real-time reporting and user management</div>
      </div>
      <div class="floating-card">
        <div class="card-icon"><i class="fas fa-chart-network"></i></div>
<div class="card-title">Intelligent Matching</div>
<div class="card-text">
Intelligent algorithm that analyzes skills, projects, education, and experience to match students with the most suitable career opportunities
</div>

      </div>
      <div class="floating-card">
        <div class="card-icon"><i class="fas fa-project-diagram"></i></div>
        <div class="card-title">Skills & Projects</div>
        <div class="card-text">Track 20+ skills and projects with timeline-based display</div>
      </div>
    </div>
  </section>

  <!-- System Overview -->
  <section class="system-overview" id="overview">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">System Overview</h2>
        <p class="section-subtitle">EDUWIDE is designed to provide comprehensive career support for students and alumni, while giving administrators, lecturers, and companies the tools to manage data and facilitate connections.</p>
      </div>
      
      <div class="overview-container">
        <div class="overview-card">
          <h3><i class="fas fa-bullseye"></i> Purpose</h3>
          <p>Provide comprehensive career support for students and former students while enabling administrators, lecturers, and companies to manage user data, skills, achievements, and intelligent algorithm.</p>
          <ul>
            <li class="highlight-list">career suggestions</li>
            <li class="highlight-list">Skill and project tracking</li>
            <li class="highlight-list">Top student identification</li>
            <li class="highlight-list">Employer-student connections</li>
          </ul>
        </div>
        
        <div class="overview-card">
          <h3><i class="fas fa-cogs"></i> Core Functionalities</h3>
          <ul>
            <li><strong>Admin Module:</strong> Full system management & reporting</li>
            <li><strong>Lecturer Module:</strong> Student management & mentoring</li>
            <li><strong>Student Module:</strong> Profile, skills, projects, career guidance</li>
            <li><strong>Alumni Module:</strong> Career profiling & networking</li>
            <li><strong>Company Module:</strong> Candidate search & Intelligent Matching</li>
          </ul>
        </div>
        
        <div class="overview-card">
          <h3><i class="fas fa-database"></i> Data Management</h3>
          <ul>
            <li>2700+ skills across 13+ categories</li>
            <li>Student achievements & certifications</li>
            <li>Education & work experience timeline</li>
            <li>Project portfolios with multimedia</li>
            <li>Real-time reporting system</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- User Roles -->
  <section class="user-roles" id="roles">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">User Roles & Access</h2>
        <p class="section-subtitle">EDUWIDE provides specialized interfaces and functionalities for different user types within the ecosystem.</p>
      </div>
      
      <div class="roles-container">
        <div class="role-card">
          <div class="role-icon"><i class="fas fa-user-shield"></i></div>
          <h3 class="role-title">Admin</h3>
          <p class="role-description">Full system control with user management, reporting, and configuration access.</p>
          <ul class="role-features">
            <li><i class="fas fa-check-circle"></i> User Management</li>
            <li><i class="fas fa-check-circle"></i> System Reports</li>
            <li><i class="fas fa-check-circle"></i> Skill Database Management</li>
            <li><i class="fas fa-check-circle"></i> Course Content Management</li>
          </ul>
        </div>
        
        <div class="role-card">
          <div class="role-icon"><i class="fas fa-chalkboard-teacher"></i></div>
          <h3 class="role-title">Lecturer</h3>
          <p class="role-description">Student management, mentoring, and academic oversight capabilities.</p>
          <ul class="role-features">
            <li><i class="fas fa-check-circle"></i> Student Management</li>
            <li><i class="fas fa-check-circle"></i> Skill Filtering</li>
            <li><i class="fas fa-check-circle"></i> Academic Oversight</li>
            <li><i class="fas fa-check-circle"></i> Report Generation</li>
          </ul>
        </div>
        
        <div class="role-card">
          <div class="role-icon"><i class="fas fa-user-graduate"></i></div>
          <h3 class="role-title">Active Student</h3>
          <p class="role-description">Profile management, skill tracking, project showcase, and career guidance.</p>
          <ul class="role-features">
            <li><i class="fas fa-check-circle"></i> Profile Management</li>
            <li><i class="fas fa-check-circle"></i> Skills & Projects</li>
            <li><i class="fas fa-check-circle"></i> Career Suggestions</li>
            <li><i class="fas fa-check-circle"></i> Achievement Tracking</li>
          </ul>
        </div>
        
        <div class="role-card">
          <div class="role-icon"><i class="fas fa-user-tie"></i></div>
          <h3 class="role-title">Former Student</h3>
          <p class="role-description">Alumni profile with career history, networking, and continued skill development.</p>
          <ul class="role-features">
            <li><i class="fas fa-check-circle"></i> Alumni Networking</li>
            <li><i class="fas fa-check-circle"></i> Career Profiling</li>
            <li><i class="fas fa-check-circle"></i> Mentorship Opportunities</li>
            <li><i class="fas fa-check-circle"></i> Job Matching</li>
          </ul>
        </div>
        
        <div class="role-card">
          <div class="role-icon"><i class="fas fa-building"></i></div>
          <h3 class="role-title">Company</h3>
          <p class="role-description">Search for top candidates, intelligent algorithm, and connect with students.</p>
          <ul class="role-features">
            <li><i class="fas fa-check-circle"></i> Candidate Search</li>
            <li><i class="fas fa-check-circle"></i> Intelligent Matching</li>
            <li><i class="fas fa-check-circle"></i> Top Student Suggestions</li>
            <li><i class="fas fa-check-circle"></i> Admin Contact</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="features" id="features">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Core Features</h2>
        <p class="section-subtitle">Comprehensive tools for career development, skill tracking, and connection building across the SLIATE community.</p>
      </div>
      
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-tachometer-alt"></i></div>
          <h3 class="feature-title">Admin Dashboard</h3>
          <p class="feature-description">Real-time overview of system users, recent logins, and comprehensive reporting tools with priority filtering and management capabilities.</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-user-cog"></i></div>
          <h3 class="feature-title">User Management</h3>
          <p class="feature-description">Full control over all user accounts with approval, disabling, deletion, reset, and editing capabilities for admins and lecturers.</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-trophy"></i></div>
          <h3 class="feature-title">Achievements & Certifications</h3>
          <p class="feature-description">Students can add and showcase achievements, certifications, and events with image support, all used in Advanced suggestion algorithms.</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-project-diagram"></i></div>
          <h3 class="feature-title">Skills & Projects</h3>
          <p class="feature-description">Add up to 20 skills from 2700+ options and showcase projects with descriptions, timelines, links, and images in timeline-based display.</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-road"></i></div>
          <h3 class="feature-title">Path Tab (LinkedIn Style)</h3>
          <p class="feature-description">Bio & summary editing with work experience and education paths displayed in modern timeline format for professional presentation.</p>
        </div>
        
        <div class="feature-card">
          <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
          <h3 class="feature-title">Reports Management</h3>
          <p class="feature-description">Comprehensive reporting system with priority levels (High/Medium/Low), filtering, and real-time interface for admin responses.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- AI Section -->
  <section class="ai-section" id="ai">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Intelligent algorithm</h2>
        <p class="section-subtitle">Intelligent algorithm that matches students with career opportunities based on skills, projects, education, and experience.</p>
      </div>
      
      <div class="ai-features">
        <div class="ai-card">
          <h3><i class="fas fa-robot"></i> Suggestion Algorithm</h3>
          <p>Matches students based on comprehensive analysis of skills, projects, education, work experience, achievements, and certifications to provide accurate career suggestions.</p>
          <div class="match-score excellent">Excellent: 80%+ Match</div>
        </div>
        
        <div class="ai-card">
          <h3><i class="fas fa-filter"></i> Advanced Filtering</h3>
          <p>Filter students by batch year, status (Working/Free/Study), and up to 20 skills simultaneously to find the perfect candidates for specific opportunities.</p>
          <div class="match-score good">Good: 60-79% Match</div>
        </div>
        
        <div class="ai-card">
          <h3><i class="fas fa-users"></i> Top Student Suggestions</h3>
          <p>Display top 100-150 candidates by match score with quality indicators (Excellent/Good/Average) and detailed skill breakdowns for companies and lecturers.</p>
          <div class="match-score average">Average: 40-59% Match</div>
        </div>
      </div>
      
      <div style="text-align: center; margin-top: 60px;">
        <a href="login.php" class="btn btn-gradient" style="font-size: 18px; padding: 18px 45px;">
          <i class="fas fa-rocket"></i> Experience EDUWIDE Now
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="footer-content">
        <div class="footer-column">
          <h3>EDUWIDE</h3>
          <p style="color: var(--gray-light); margin-bottom: 25px; line-height: 1.7;">Advanced Career Guidance System f students and alumni, providing Intelligent career matching and comprehensive skill development tools.</p>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
            <a href="#"><i class="fab fa-github"></i></a>
          </div>
        </div>
        
        <div class="footer-column">
          <h3>Quick Links</h3>
          <ul class="footer-links">
            <li><a href="#overview"><i class="fas fa-chevron-right"></i> System Overview</a></li>
            <li><a href="#roles"><i class="fas fa-chevron-right"></i> User Roles</a></li>
            <li><a href="#features"><i class="fas fa-chevron-right"></i> Core Features</a></li>
            <li><a href="#ai"><i class="fas fa-chevron-right"></i> Intelligent Matching</a></li>
          </ul>
        </div>
        
        <div class="footer-column">
          <h3>User Access</h3>
          <ul class="footer-links">
            <li><a href="admin/pages-signup.php"><i class="fas fa-sign-in-alt"></i> Admin Login</a></li>
            <li><a href="lectures/pages-signup.php"><i class="fas fa-chalkboard-teacher"></i> Lecturer Login</a></li>
            <li><a href="oddstudents/pages-signup.php"><i class="fas fa-user-graduate"></i> Student Login</a></li>
            <li><a href="pages-signup.php"><i class="fas fa-user-graduate"></i> Former Student Login</a></li>
            <li><a href="companies/pages-signup.php"><i class="fas fa-building"></i> Company Login</a></li>
          </ul>
        </div>
        
        <div class="footer-column">
          <h3>Contact</h3>
          <ul class="footer-links">
            <li><a href="#"><i class="fas fa-envelope"></i> malithatishamal@gmail.com</a></li>
          </ul>
        </div>
      </div>
      
      <div class="copyright">
        &copy; 2025 EDUWIDE - Advanced Career Guidance System by Malitha Tishamal. All Rights Reserved.
      </div>
    </div>
  </footer>

  <script>
    // Theme Toggle Functionality
    const themeToggle = document.getElementById('themeToggle');
    const htmlElement = document.documentElement;
    
    // Check for saved theme preference or default to dark
    const savedTheme = localStorage.getItem('theme') || 'dark';
    htmlElement.setAttribute('data-theme', savedTheme);
    
    // Update toggle position based on saved theme
    if (savedTheme === 'light') {
      themeToggle.querySelector('.fa-sun').style.opacity = '0.5';
      themeToggle.querySelector('.fa-moon').style.opacity = '1';
    } else {
      themeToggle.querySelector('.fa-sun').style.opacity = '1';
      themeToggle.querySelector('.fa-moon').style.opacity = '0.5';
    }
    
    // Toggle theme on click
    themeToggle.addEventListener('click', () => {
      const currentTheme = htmlElement.getAttribute('data-theme');
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      
      // Set new theme
      htmlElement.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);
      
      // Update toggle icons
      if (newTheme === 'light') {
        themeToggle.querySelector('.fa-sun').style.opacity = '0.5';
        themeToggle.querySelector('.fa-moon').style.opacity = '1';
      } else {
        themeToggle.querySelector('.fa-sun').style.opacity = '1';
        themeToggle.querySelector('.fa-moon').style.opacity = '0.5';
      }
    });

    // Mobile menu toggle
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const navUl = document.querySelector('nav ul');

    menuBtn.addEventListener('click', () => {
      navUl.classList.toggle('mobile-active');
      
      // Create mobile auth buttons if they don't exist
      if (!document.querySelector('.mobile-auth')) {
        const mobileAuth = document.createElement('div');
        mobileAuth.className = 'mobile-auth';
        mobileAuth.innerHTML = `
          <a href="login.php" class="btn-outline" style="justify-content: center;"><i class="fas fa-sign-in-alt"></i> Login</a>
          <a href="register.php" class="btn-outline" style="justify-content: center;"><i class="fas fa-user-plus"></i> Register</a>
          <div class="theme-toggle mobile-theme-toggle" id="mobileThemeToggle" style="display: none;">
            <i class="fas fa-sun"></i>
            <i class="fas fa-moon"></i>
          </div>
        `;
        navUl.appendChild(mobileAuth);
        
        // Clone theme toggle for mobile
        const mobileThemeToggle = mobileAuth.querySelector('#mobileThemeToggle');
        mobileThemeToggle.style.display = 'flex';
        
        // Add click event to mobile theme toggle
        mobileThemeToggle.addEventListener('click', () => {
          themeToggle.click(); // Trigger the main theme toggle
        });
      }
    });

    // Close mobile menu when clicking a link
    document.querySelectorAll('nav a').forEach(link => {
      link.addEventListener('click', () => {
        navUl.classList.remove('mobile-active');
      });
    });

    // Header scroll effect
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
      if(window.scrollY > 50) header.classList.add('scrolled');
      else header.classList.remove('scrolled');
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if(targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if(targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 80,
            behavior: 'smooth'
          });
        }
      });
    });

    // Add floating animation to cards on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.animationPlayState = 'running';
        }
      });
    }, observerOptions);

    // Observe floating cards
    document.querySelectorAll('.floating-card, .feature-card, .role-card').forEach(card => {
      observer.observe(card);
    });
  </script>
</body>
</html>