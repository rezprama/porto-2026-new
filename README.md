# Reza Pratama — Developer Portfolio

Personal developer portfolio and interactive project showcases highlighting enterprise telecom platforms, internal operational tools, and workflow automation systems.

![Tech Stack](https://img.shields.io/badge/Laravel-13.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-blue?style=flat-square&logo=php)
![Vue.js](https://img.shields.io/badge/Vue.js-3.x-emerald?style=flat-square&logo=vue.js)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.x-sky?style=flat-square&logo=tailwindcss)
![Vercel Ready](https://img.shields.io/badge/Vercel-Deployment%20Ready-black?style=flat-square&logo=vercel)

---

## 🌟 Overview

This web portfolio showcases real enterprise architectures and in-repo interactive UI miniatures based on 6+ years of engineering experience across **Telkom Group** and **InfraNexia**:

- **Bilingual Interface**: Native support for Indonesian (`ID`) and English (`EN`) with seamless in-browser switching.
- **Theme System**: Ergonomic Light Mode and eye-strain-free Dark Graphite Mode.
- **Interactive System Miniatures**: Authentic, interactive UI simulations for field operations, telemetry, and approval workflows.
- **Responsive & Accessible**: Strict adherence to modern frontend craft, clean typography, and WCAG AA contrast standards.

---

## 🚀 Featured Enterprise Projects

### 1. DALAPA Platform (2026)
*Regional Operations & Asset Intelligence Suite*
- **GIS Map Alpro**: Geospatial infrastructure mapping for fiber optics (STO, OLT, ODP occupancy tracking).
- **GCU-OLT Telemetry**: Real-time DC voltage, current load monitoring, and optical power SLA verification.
- **QE & BOQ Workflow**: Multi-tier digital approval pipeline for capital expenditure and material planning.

### 2. DALAPA Regional (Legacy Suite)
*Monolithic Telecom Operations Engine*
- End-to-end network element mapping, assurance ticket reconciliation, and NTE stock opname tracking.

### 3. TOMMAN Operational Suite
*Field Operations & Bot Automation*
- Work order dispatching, technician assignment tracking, and automated Telegram broadcast bot for outage alerts.

---

## 🛠️ Tech Stack & Architecture

- **Backend**: Laravel 13 (PHP 8.3)
- **Frontend**: Blade, Vue.js 3, Tailwind CSS v4
- **Database**: SQLite / MySQL compatibility
- **Deployment**: Configured for Vercel Serverless (`vercel-php`) & standard PHP hosting

---

## 💻 Local Development Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/rezprama/porto-2026-new.git
   cd porto-2026-new
   ```

2. **Install PHP & JS dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Set up environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Build assets and start the application:**
   ```bash
   npm run build
   php artisan serve
   ```

---

## 📄 License & Credits

Designed and engineered by **Reza Pratama** — Balikpapan, Indonesia.  
Open-source under the [MIT License](LICENSE).
