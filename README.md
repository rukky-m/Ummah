# Ummah - Community Financial & Member Management System

Ummah is a comprehensive financial management platform designed for community-based savings and credit systems. Built with the **Laravel** ecosystem, it provides a robust, secure, and user-friendly interface for managing members, loans, and financial contributions.

## 🚀 Key Features

### 👥 Member Management
- **Seamless Onboarding**: Multi-step registration wizard for new members.
- **Profile Controls**: Self-service profile management, including bank detail updates.
- **Member Statements**: Real-time access to personal financial statements.

### 💰 Financial Services
- **Savings & Contributions**: Track and manage individual savings and regular contributions.
- **Flexible Deposits**: In-app tools for managing financial inflows.

### 🏥 Advanced Loan System
- **Loan Wizard**: Guided application process for standard and specialized loans.
- **Specialized Products**:
  - **Ramadan & Sallah Loans**: Targeted support for religious festivities.
  - **Asset Acquisition**: Loans for tangible asset purchases.
  - **Motorcycle Loans**: Tailored financing for transportation needs.
- **Approval Workflow**: Multi-layered review process from staff to final disbursement.

### 🛠️ Administrative & Staff Tools
- **Role-Based Access**: Specialized views for Manager, auditor, Treasurer, and Finance roles.
- **Cashbook Management**: Integrated financial tracking with export/import capabilities.
- **Announcements**: Internal communication system for members and staff.
- **Support Tickets**: Built-in customer support for resolving member inquiries.

## 🛠️ Technical Stack
- **Framework**: [Laravel 11](https://laravel.com)
- **Styling**: [Tailwind CSS](https://tailwindcss.com)
- **Frontend Tooling**: [Vite](https://vitejs.dev)
- **Authentication**: Built-in secure authentication with Role-Based Access Control (RBAC).

## ⚙️ Installation

1. **Clone & Install**:
   ```bash
   git clone <repo-url>
   cd ummah
   composer install
   npm install && npm run build
   ```

2. **Configuration**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database**:
   ```bash
   php artisan migrate --seed
   ```

4. **Serve**:
   ```bash
   php artisan serve
   ```

## 🤝 Contributing
Contributions are welcome! Please follow standard pull request workflows for any feature requests or bug fixes.

## 📄 License
The Ummah project is open-sourced software licensed under the [MIT license](LICENSE).
