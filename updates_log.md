# SGPayroll Updates Log

This document serves as the comprehensive log of all features, enhancements, schema migrations, and bug fixes applied to the SGPayroll system.

---

## [2026-09-10] — CSV Onboarding Overhaul, Excel Template Download, Employee Modal Requirements & Payslip Enhancements

### 1. Bulk Employee CSV Onboarding, Alertify Feedback & Excel Template Download
- **Business Need**: HR bulk onboarding previously lacked `contact_no`, treated `email` as optional (which skipped user portal account creation), had no visual feedback or ongoing alert during import, and dumped raw server errors without pinpointing failed rows or allowing easy Excel editing.
- **Added Features & Enhancements**:
  - **Downloadable Excel Template (`.xlsx`)**:
    - Created a pre-formatted OpenXML Excel template file: [`public/templates/employee_import_template.xlsx`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/templates/employee_import_template.xlsx).
    - Contains all 21 columns with styled dark headers and two realistic sample rows (complete record & optional fields blank).
    - Registered download route `GET /employee/download-template` in [`routes/web.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/routes/web.php).
    - Added `EmployeeController@downloadTemplate` to safely stream the file.
  - **Import Modal Guide Redesign ([index.blade.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/index.blade.php))**:
    - Added prominent **"Download Excel Template (.xlsx)"** button in the modal guide.
    - Added an instructional tip highlighting the Excel-to-CSV workflow (*"Fill in Excel, then Save As > CSV (*.csv) to import"*).
    - Restructured the 21-column reference table with high-visibility badges:
      - **10 Required Fields** (Red `<span class="badge">Required *</span>`): `employee_id`, `last_name`, `first_name`, `gender`, `date_hired`, `birth_date`, `department`, `position`, `contact_no`, `email`.
      - **11 Optional Fields** (Slate `<span class="badge">Optional</span>`): `middle_name`, `status`, `address`, `sss_number`, `tin_number`, `hdmf_number`, `philhealth_number`, `ucpb_number`, `basic_pay`, `cola`, `other_nt_pay`.
    - Added clear portal password notice (`testPass`).
  - **Alertify Loading Flow, Delayed Reload & Dynamic Error Container**:
    - Submit handler in [`resources/views/employee/index.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/index.blade.php):
      - Disables submit and dismiss buttons while adding an animated SVG spinner (`Importing Employees...`).
      - Displays an ongoing non-blocking Alertify notification (`alertify.notify('Importing employees, please wait...', 'custom', 0)`).
      - **100% Success**: Dismisses the ongoing alert, triggers `alertify.success(...)`, and delays page reload by 1.5 seconds for a smooth UX.
      - **Partial Failure / Errors**: Keeps the modal open, triggers `alertify.warning(...)` or `alertify.error(...)`, re-enables form controls, and renders an inline scrollable error list (`#employeeImportErrors`) listing exact line numbers and validation issues so HR can fix mistakes immediately.
  - **Robust Importer Validation & Account Creation ([EmployeeController.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Http/Controllers/Employee/EmployeeController.php))**:
    - `batchImportCsv` now strictly enforces all 10 required fields and validates email format.
    - Added row-level duplicate checks for `employee_id` and `email` with precise failure messages.
    - Correctly maps `contact_no` / `contact_number` to `employees.contactNo`.
    - Automatically creates a `User` portal account for every imported employee with default password `testPass`.

### 2. Standardized Payroll CSV Import Flow & Excel Template Download (Reports Module)
- **Business Need**: The Reports module's "Import Payroll CSV" lacked an easily editable template file, lacked loading feedback during lengthy payroll imports, and did not follow the standard Alertify notifications or row error reporting.
- **Added Features & Enhancements**:
  - **Downloadable Excel Template (`.xlsx`)**:
    - Created a pre-formatted OpenXML Excel template file: [`public/templates/payroll_import_template.xlsx`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/templates/payroll_import_template.xlsx).
    - Contains all 59 payroll columns with styled dark headers and two realistic sample rows covering earnings, deductions, loan amortizations, and net pay.
    - Registered download route `GET /reports/download-template` in [`routes/web.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/routes/web.php).
    - Added `ReportsController@downloadTemplate` to stream the template.
  - **Import Modal Standardization ([index.blade.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/reports/index.blade.php))**:
    - Added **"Download Excel Template (.xlsx)"** button and instruction tip (*"Edit in Excel, then Save As > CSV (*.csv) to import"*) in `#payroll-step-1`.
    - Submit handler updated to mirror the employee import UX:
      - Button spinner state (`Importing Records...`) and disabled dismiss controls.
      - Ongoing non-blocking Alertify notification (`Importing payroll records, please wait...`).
      - On full success: triggers `alertify.success(...)` and reloads after 1.5s.
      - On partial/total error: keeps modal open, re-enables buttons, and renders row-by-row error details in `#payrollImportErrors`.
  - **Backend Validation & BOM Sanitization ([ReportsController.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Http/Controllers/Reports/ReportsController.php))**:
    - Enhanced `batchImportPayrollCsv`: validates file upload, strips UTF-8 Byte Order Marks (BOM), validates 59-column count, verifies employee existence in DB, and returns structured row-level errors.

### 3. Employee Account Settings (Probationary Contract Dates)
- **Business Need**: In Employee Account Settings, the "Contract Date From" and "Contract Date To" datepickers were only enabled when selecting *Contractual*, leaving *Probationary* employees unable to record contract duration.
- **Modifications**:
  - [`resources/views/employee/account.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/account.blade.php): Updated `Status of Employment` options (`1: Regular`, `2: Contractual`, `3: Probationary`, `4: Consultant & Senior Worker`) and enabled date inputs for values `2`, `3`, `'Contractual'`, and `'Probationary'`.
  - [`public/js/employee/employee.js`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/js/employee/employee.js): Added `checkEmploymentStatusDates()` triggered on page load and on `#employmentStatus` change.

### 4. Add Employee Modal Validation, Red Asterisks & Loading Alert
- **Business Need**: Missing required indicators, missing contact and email validations, unhandled SQL exceptions when middle name was empty, and lack of visual feedback during employee creation.
- **Modifications**:
  - [`resources/views/employee/index.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/index.blade.php): Added red asterisk `<span class="text-rose-500">*</span>` to all required fields. Contact Number and Email marked as required. Middle Name marked as optional.
  - [`public/js/employee/employee.js`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/js/employee/employee.js):
    - Added form validation for email format and contact number.
    - Submit button changes to disabled spinner state (`Adding Employee...`).
    - Added non-blocking Alertify loading notification.
    - On success: modal closes cleanly, Alertify success alert appears, and page smoothly refreshes after a 1.2s delay.
  - [`app/Http/Controllers/Employee/EmployeeController.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Http/Controllers/Employee/EmployeeController.php):
    - `addEmployee`: Added duplicate `employee_id` check, allowed nullable `employee_Mname`, wrapped operations in `try/catch` returning clean JSON `{ success, message }`.
    - `updateAccount`: Allowed nullable `employee_Mname`.
  - [`app/Employee.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Employee.php):
    - Updated `getFullNameAttribute()` to format `Lastname, Firstname` without trailing dots when middle name is null.
  - **Database Migration**:
    - Created and executed [`database/migrations/2026_09_10_000001_make_employee_mname_nullable.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/database/migrations/2026_09_10_000001_make_employee_mname_nullable.php) making `employees.employee_Mname` `VARCHAR(191) NULL DEFAULT NULL`.

### 5. Payslip Generator Active/Inactive Status Filter & Searchable Dropdown
- **Business Need**: HR needed to filter employees by Active / Inactive / All status and quickly search specific employees by name or ID when configuring payslips.
- **Modifications**:
  - [`app/Http/Controllers/Payslip/PayslipController.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Http/Controllers/Payslip/PayslipController.php): Updated `showDataPayslip` to accept `status` (`'1'`, `'2'`, `'all'`) and filter employees accordingly.
  - [`resources/views/payslip/index.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/payslip/index.blade.php): Added segmented pill filter buttons (**Active**, **Inactive**, **All**), Select2 CSS, and status badge styling.
  - [`public/js/payslip/payslip.js`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/js/payslip/payslip.js): Integrated Select2 type-to-search on `#employee_id` with real-time status badges, dynamic reload on status toggle, and batch print checkbox sync.
  - Added offline vendor assets [`public/css/select2.min.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/css/select2.min.css) and [`public/js/select2.min.js`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/js/select2.min.js).

### 6. Resizable & Minimizable Sidebar with Smooth Transitions, Icon-Only Collapsed Mode & Floating Tooltips
- **Business Need**: Users required a dynamic sidebar that can be resized to custom widths and collapsed into an ultra-clean, icon-only and logo-only navigation bar to maximize workspace screen real estate, complete with smooth animations and tooltips.
- **Added Features & Enhancements**:
  - **Minimizable Icon-Only Sidebar**:
    - When collapsed (`.sidebar-collapsed`), the sidebar smoothly contracts to `72px` (`4.5rem`).
    - **Logo & Brand**: Shows only the centered "SG" corporate badge (`w-8 h-8 rounded-lg bg-blue-600`); brand name text is hidden.
    - **Navigation Items**: Menu labels fade and collapse; navigation items display only centered icons within 44px x 44px rounded hover pills.
    - **Category Headings**: Section titles smoothly transform into subtle, clean 1px divider lines (`#f1f5f9`).
    - **Floating Tooltips**: Implemented `#sidebarFloatingTooltip` positioned dynamically on hover next to each icon so users always know where each menu icon leads.
  - **Drag-to-Resize Functionality**:
    - Added desktop resize handle (`#sidebarResizeHandle`) along the right border of the sidebar with active hover glow.
    - Supports fluid dragging between `200px` (min) and `460px` (max).
    - Features snap-to-collapse when dragged narrower than `135px`, and auto-expansion when dragged outward past `145px`.
    - Double-clicking the resize handle resets width to the default `256px`.
    - Transitions are disabled during active drag (`.is-resizing`) for 60fps responsiveness, and re-enabled smoothly upon release.
  - **Toggle Triggers & Keyboard Shortcut**:
    - Dedicated sidebar collapse button with arrow indicator (`#sidebarToggleBtn`) in the sidebar header with smooth 180-degree rotation (`<` when expanded, `>` when minimized).
    - Removed redundant desktop topbar hamburger button so only the clean arrow button controls the sidebar.
    - Clicking the "SG" brand badge while collapsed expands the sidebar.
    - Global keyboard shortcut: `Ctrl + B` (or `Cmd + B`) toggles between expanded and minimized views.
  - **Zero-Flicker State Persistence**:
    - Stored states: `sgpayroll_sidebar_collapsed` (`'true'` / `'false'`) and `sgpayroll_sidebar_width` (`px`) in `localStorage`.
    - Integrated inline head script in [`app.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/layouts/app.blade.php) that initializes classes and CSS variables before the first paint, preventing layout shift or flickering across page navigations.
  - **Modified Files**:
    - [`resources/views/layouts/app.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/layouts/app.blade.php): Added head restoration script, updated `#app-sidebar` container, added resize handle, desktop topbar toggle, and `#sidebarFloatingTooltip`.
    - [`public/js/sidebar.js`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/js/sidebar.js): Full rewrite supporting resize calculations, snap behavior, tooltip placement, toggle actions, and keyboard shortcuts.
    - [`resources/assets/css/app.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/assets/css/app.css) & [`public/css/tailwind.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/css/tailwind.css): Added cubic-bezier transitions, `.sidebar-collapsed` rules, resize handle pseudo-elements, and tooltip animations.
    - [`resources/views/admin/sidebar.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/admin/sidebar.blade.php): Added `data-tooltip`, `.sidebar-nav-item`, `.sidebar-icon`, `.sidebar-label`, and `.sidebar-heading`.
    - [`resources/views/superadmin/sidebar.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/superadmin/sidebar.blade.php): Added matching navigation classes and tooltips.
    - [`resources/views/portal/sidebar.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/portal/sidebar.blade.php): Added matching navigation classes and tooltips.

---

## [2026-09-09] — Notification System, Navigation Layout, Reporting Direct Queries, and Container Permissions

### 1. Application-Wide Notification System
- **Commit**: `6aadd60`
- **Overview**: Implemented an automated in-app notification infrastructure for system events, leave approval workflows, and employee announcements.
- **Key Files**:
  - [`database/migrations/2026_09_09_000001_create_app_notifications_table.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/database/migrations/2026_09_09_000001_create_app_notifications_table.php): Notification storage schema.
  - [`app/AppNotification.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/AppNotification.php): Model with helper scopes for unread, user-specific notifications.
  - [`app/Http/Controllers/Notification/NotificationController.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Http/Controllers/Notification/NotificationController.php): Endpoints for fetching, marking read, and clearing notifications.
  - [`resources/views/layouts/app.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/layouts/app.blade.php): Topbar notification bell icon with badge counter, slide-out dropdown, and polling script.
  - Integrated notification dispatch into [`LeaveApplicationController.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Http/Controllers/Leave/LeaveApplicationController.php) when leave requests are approved or rejected.

### 2. Modern Application Layout & Sidebar Navigation
- **Commit**: `65e0a69`
- **Overview**: Revamped application shell with unified collapsible sidebar navigation, breadcrumbs, user profile dropdown, and responsive mobile drawer.
- **Key Files**:
  - [`resources/views/layouts/app.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/layouts/app.blade.php): Responsive layout structure.

### 3. Employee Information Report Direct Query
- **Commit**: `ef82260`
- **Overview**: Fixed PDF export where newly created employees failed to appear in Employee Information reports.
- **Key Files**:
  - [`app/Http/Controllers/Reports/ReportsController.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Http/Controllers/Reports/ReportsController.php): Queried `Employee` model directly instead of stale cached collections.
  - [`resources/views/reports/employeeInformation.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/reports/employeeInformation.blade.php): Updated table view.

### 4. Docker Environment & Build Fixes
- **Commits**: `268e4ab`, `2f8d4c4`, `43eb392`, `8cc0c01`
- **Overview**: Resolved container boot issues, Debian apt repository archive changes, volume shadowing of `vendor`, and view compilation storage permissions.
- **Key Files**:
  - [`Dockerfile`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/Dockerfile): Updated Debian Bullseye apt sources to `archive.debian.org`, optimized build layer caching.
  - [`docker-entrypoint.sh`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/docker-entrypoint.sh): Added automatic `chmod -R 777 storage bootstrap/cache` and vendor integrity checks.
  - [`docker-compose.yml`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/docker-compose.yml): Fixed volume mount definitions.

### 5. Comprehensive Payroll Management Module & View Standardization
- **Commit**: `0bf961a`
- **Overview**: Overhauled administrative views, leave ledger management, and payroll processing.
- **Key Files**:
  - [`app/Console/Commands/ReloadDecemberLeaveCredits.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Console/Commands/ReloadDecemberLeaveCredits.php): Artisan command for leave credit resets.
  - [`app/LeaveCreditLedger.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/LeaveCreditLedger.php): Ledger calculation logic.
  - [`app/Http/Controllers/Admin/LeaveWindowController.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Http/Controllers/Admin/LeaveWindowController.php): Superadmin leave window toggle.
  - Standardized UI across 32 view and controller files.

---

## [2026-09-08] — Tailwind CSS Overhaul & Core Payslip Generation

### 1. Full UI Overhaul using Tailwind CSS
- **Commit**: `8b67cd2`
- **Overview**: Transitioned SGPayroll from legacy Bootstrap styling to modern, professional Tailwind CSS with curated color schemes, rounded cards, refined typography, and subtle micro-interactions.
- **Key Files**:
  - [`tailwind.config.js`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/tailwind.config.js): Configured color palette (slate, emerald, blue, rose) and content paths.
  - [`resources/assets/css/app.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/assets/css/app.css) -> [`public/css/tailwind.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/css/tailwind.css): Compiled utility classes.
  - Modernized sidebars, authentication screens, department management, employee list, and loan schedules.

### 2. Core Payslip Generation & PDF Export
- **Commit**: `65d45e4`
- **Overview**: Implemented comprehensive single and batch payslip calculation logic with official printable PDF generation.
- **Key Files**:
  - [`app/Http/Controllers/Payslip/PayslipController.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/app/Http/Controllers/Payslip/PayslipController.php): Calculation of gross pay, non-taxable allowances, statutory deductions (SSS, PhilHealth, Pag-IBIG), withholding tax, loan amortizations, and net pay.
  - [`resources/views/payslip/print.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/payslip/print.blade.php): Clean two-column printable payslip voucher with corporate header and signature lines.
