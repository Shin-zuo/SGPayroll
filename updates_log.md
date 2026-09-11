# SGPayroll Updates Log

This document serves as the comprehensive log of all features, enhancements, schema migrations, and bug fixes applied to the SGPayroll system.

---

## [2026-09-11] — Payroll Group Matrix (/payroll/{group}) Dark Mode Contrast & Grid Standardization

### 1. Light Pastel Washed-Out Colors & High Contrast Overhaul
- **Problem**: In the payroll computation matrix page ([`resources/views/payroll/index.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/payroll/index.blade.php)), sections for `Debit`, `Credit`, `Non-Tax Benefits`, `Non-Tax Other Pay`, `Contributions`, `Loans`, `Gross Pay`, and `Net Pay` used light-mode pastel utility classes (`bg-red-50`, `bg-yellow-50`, `bg-purple-50`, `bg-green-50`, `bg-orange-50`, `bg-teal-50`, `bg-blue-100`, `bg-green-100` and `/30` variants) without dark mode definitions. In dark mode, these rendered with blinding white/pastel backgrounds and washed-out text.
- **Root Cause & Solution**:
  - **Global Palette Accents in `resources/assets/css/app.css`**: Added dark mode rules for all pastel background utilities and their fractional opacity variants (`.bg-red-50`, `.bg-yellow-50`, `.bg-purple-50`, `.bg-green-50`, `.bg-orange-50`, `.bg-teal-50`, `.bg-blue-100`, `.bg-green-100`), mapping them to elevated translucent dark card surfaces (`rgba(..., 0.25)`).
  - **Vibrant High-Contrast Text Scales**: Added dark text overrides in `app.css` for `text-red-800/600` (`#fb7185`), `text-yellow-800/600` (`#fcd34d`), `text-purple-800/600` (`#c084fc`), `text-green-800/700/600` (`#34d399`), `text-orange-800/600` (`#fdba74`), `text-teal-800/600` (`#5eead4`), and `text-blue-800/700` (`#93c5fd`).
  - **Dedicated Payroll Matrix Styling**: Added `.payroll-table-main` rules in `app.css` ensuring table cells, dark numeric inputs, and disabled inputs retain full opacity (`opacity: 1 !important`) and high contrast.

### 2. Blade Template Dark Mode & Table Grid Alignment
- **Loans Header Alignment Bug**: Fixed `colspan="8"` to `colspan="7"` on the `Loans` header in [`resources/views/payroll/index.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/payroll/index.blade.php), eliminating the rogue empty black cell that previously appeared beside `SSS EMERG.`.
- **Department Filter Card**: Applied `dark:bg-slate-900`, `dark:border-slate-800`, styled dark inputs and selects, high-contrast labels, and elevated filter button.
- **Employee Header Bar**: Modernized `bg-blue-600` with `dark:bg-slate-800`, avatar badge, and subtle reference tag (`Ref: #ID`).
- **Matrix Inputs & Summary Badges**:
  - Replaced flat inputs with styled dark inputs (`dark:bg-slate-900 dark:border-slate-700 dark:text-slate-100 font-mono text-center`).
  - Styled `Excess Hours` (`dark:bg-slate-800 dark:text-slate-100`), `Gross Pay` (`dark:bg-blue-950/70 dark:text-blue-200`), and `Net Pay` (`dark:bg-emerald-950/50 dark:text-emerald-400 font-mono font-bold`).
- **Recompiled Assets**: Compiled minified styles into [`public/css/tailwind.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/css/tailwind.css) via `npm run build:css`.

---

## [2026-09-11] — Mobile Viewport Full-Width Responsiveness & Off-Canvas Sidebar Layout Fix

### 1. Mobile Sidebar Flow & 250px Blank Void Bug Resolution
- **Problem**: In mobile viewports (< 768px), the main application view had a 256px blank gap/void on the left side of the screen, severely squeezing the main content container and tables to the right and causing awkward horizontal overflow.
- **Root Cause**: In [`resources/views/layouts/app.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/layouts/app.blade.php), `<aside id="app-sidebar">` contained conflicting position classes (`fixed inset-y-0 left-0 ... md:relative ... relative`). Because `relative` appeared at the end of the class list, on mobile devices (where `md:relative` was not yet active), the element took `position: relative`. In CSS Flexbox (`<div class="flex h-screen overflow-hidden">`), a `relative` element with `-translate-x-full` still occupies its full 256px layout box in the flex flow, displacing the sibling content container `<div class="flex-1 flex flex-col min-w-0">` 256px to the right and leaving an empty 256px void on the left.
- **Solution**:
  - **Blade Class Cleanup**: Removed the conflicting trailing `relative` class from `<aside id="app-sidebar">` in [`layouts/app.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/layouts/app.blade.php) line 85.
  - **Hardened Mobile Drawer CSS in `resources/assets/css/app.css`**: Added an explicit `@media (max-width: 767px)` rule for `#app-sidebar` specifying `position: fixed !important; top: 0 !important; bottom: 0 !important; left: 0 !important; z-index: 40 !important; width: 16rem !important; max-width: 80vw !important; transition: transform 0.3s ease-in-out !important;` and hiding the desktop resize handle (`#sidebarResizeHandle { display: none !important; }`). This ensures that on mobile screens the sidebar is strictly removed from document flex flow and operates solely as an off-canvas drawer.
  - **Container Width & Padding Optimization**: Set responsive padding on `<main class="flex-1 overflow-y-auto bg-slate-50/50 dark:bg-slate-950 p-3.5 sm:p-5 md:p-6 lg:p-8">` allowing mobile devices to make use of 100% of the display viewport width.

### 2. Page-Specific Mobile Viewport Optimizations
- **Employee Account View ([resources/views/employee/account.blade.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/account.blade.php))**:
  - Converted the profile header to a responsive flex layout (`flex-col sm:flex-row sm:items-center justify-between gap-3`) preventing action buttons from overflowing.
  - Converted statutory deduction checkboxes from a rigid 4-column grid to responsive `grid-cols-2 sm:grid-cols-4 gap-2`.
  - Added responsive flex wrap on the annual leave credits lock header (`flex-col sm:flex-row sm:items-center justify-between gap-2.5`).
- **Reports Page ([resources/views/reports/index.blade.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/reports/index.blade.php))**:
  - Converted report action buttons into full-width stacked buttons on mobile (`w-full sm:w-auto flex-col-reverse sm:flex-row`) for improved touch usability.
- **Asset Recompilation**: Recompiled all styles into [`public/css/tailwind.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/css/tailwind.css) via `npm run build:css`.

---

## [2026-09-11] — Directory Badges & Directory Tables Dark Mode Contrast Fixes (Active, Inactive, Leave, Loans)

### 1. Count Badges Dark Mode Background & Text Contrast
- **Problem**: Badges indicating record counts (e.g. `X active employees` in Active Employee Directory, `X records` in Leave Applications, `X inactive records` in Inactive Employee Directory, `X records` in Employee Loans) had `bg-slate-200/70 text-slate-700`. Because `bg-slate-200/70` had no dark mode background override while `text-slate-700` remapped to light slate in dark mode, the badge rendered with light text on a light background, making it unreadable.
- **Solution**:
  - **Global CSS in `resources/assets/css/app.css`**: Added dark mode rules for `html.dark .bg-slate-200`, `.bg-slate-200\/60`, `.bg-slate-200\/70`, `.bg-slate-200\/80` to automatically style badges as elevated dark cards (`#1e293b`) with light text (`#e2e8f0`) and a subtle border (`#334155`).
  - **Blade Template Dark Classes**: Updated count badges in [`employee/index.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/index.blade.php), [`leave/index.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/leave/index.blade.php), [`employee/inactive.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/inactive.blade.php), and [`employee/loans.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/loans.blade.php) with explicit `dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-transparent dark:border-slate-700/60` classes.

### 2. Comprehensive Table Surface & Contrast Overhaul
- **Active Employee Directory ([employee/index.blade.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/index.blade.php))**:
  - Added dark mode support to top stat cards (`Total Employees`, `Active Employees`, `Inactive Employees`, `Total Groups`) with elevated dark backgrounds (`#111a2e`), high-contrast headings, and translucent icon badges.
  - Added dark surface classes (`dark:bg-slate-900 dark:border-slate-800`) to the table container and header.
  - Upgraded table cells with high-contrast text: Ref # (`dark:text-slate-300`), Employee Name (`dark:text-white`), Employee ID (`dark:text-slate-300`), Group (`dark:text-slate-100`), Position (`dark:text-slate-300`), and dark-tinted status badges.
- **Leave Applications Directory ([leave/index.blade.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/leave/index.blade.php))**:
  - Applied dark styling to the directory card and header bar.
  - Upgraded table cells: Ref # (`dark:text-slate-300`), Employee Name (`dark:text-white`), Employee ID (`dark:text-slate-300`), Leave Type (`dark:bg-blue-900/40 dark:text-blue-300`), Period (`dark:text-slate-100`), Days (`dark:text-slate-100`), Reason (`dark:text-slate-300`).
  - Dark-tinted status badges for `Pending` (amber), `Approved` (emerald), and `Rejected` (rose) with dark borders and vibrant text.
- **Inactive Employee Directory ([employee/inactive.blade.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/inactive.blade.php))**:
  - Applied dark surface styling to container, header, and back button.
  - Upgraded table rows with high-contrast text and dark-tinted `Inactive` status pills.
- **Employee Loans Directory ([employee/loans.blade.php](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/employee/loans.blade.php))**:
  - Applied dark mode surface styling to container, header, count badge, and table entries.
- **Recompiled Assets**: Built minified styles into [`public/css/tailwind.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/css/tailwind.css) via `npm run build:css`.

---

## [2026-09-11] — Created Payroll Directory Table Standardization & Dark Mode Readability Fixes

### 1. Action Buttons Consistency & Styling
- **Problem**: In the "Created Payroll Directory" table ([`resources/views/payslip/index.blade.php`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/views/payslip/index.blade.php)), action buttons had hardcoded inline styles (`style="background-color: #f0f9ff..."`, `#eff6ff`, `#fff1f2`, borders, dimensions) which overrode dark mode styling, causing them to render as jarring, solid white rectangular boxes instead of translucent badge buttons.
- **Solution**:
  - Replaced inline styles with standardized `.admin-action-btn-group` and `.admin-btn-action` classes matching other directory tables (`employee/index.blade.php`, `employee/loans.blade.php`, `department/index.blade.php`).
  - Standardized the action button set:
    - **Edit**: `.admin-btn-action.admin-btn-action-edit.btn-edit-payslip` with modern `<i class="fa fa-pen"></i>` (soft blue in light mode, translucent cyan `rgba(14, 165, 233, 0.15)` with `#38bdf8` icon and glow on hover in dark mode).
    - **Print**: `.admin-btn-action.admin-btn-action-print` with modern `<i class="fa fa-print"></i>` (soft indigo in light mode, translucent blue `rgba(37, 99, 235, 0.15)` with `#60a5fa` icon in dark mode).
    - **Delete**: `.admin-btn-action.admin-btn-action-danger.btn-delete-payslip` with modern `<i class="fa fa-trash-alt"></i>` (soft rose in light mode, translucent rose `rgba(225, 29, 72, 0.15)` with `#fb7185` icon in dark mode).
  - Preserved all JavaScript event bindings (`.btn-edit-payslip`, `.btn-delete-payslip`, `data-id`, `data-employee`).

### 2. Header Icon & Visual Identity Alignment
- **Problem**: The directory header previously used a green spreadsheet icon badge (`bg-emerald-100` + `fa-table`), which clashed with the blue theme used on directory tables throughout the application.
- **Solution**: Replaced the icon badge with SGPayroll's brand blue container and payslip invoice icon: `<span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-sm shadow-xs"><i class="fa fa-file-invoice-dollar"></i></span>`.

### 3. Text Contrast & Dark Mode Readability Overhaul
- **Problem**: Table entries had poor contrast on dark surfaces: `text-slate-300` had an inverted CSS rule (`color: #64748b !important`) in dark mode causing text to turn nearly black, while employee codes, department numbers, gross pay, deductions, and created dates blended into the `#111a2e` background.
- **Solution**:
  - **Fixed Global Text Scale in `resources/assets/css/app.css`**: Corrected `html.dark .text-slate-300` to `#cbd5e1 !important` (soft readable light slate), added `html.dark .text-slate-200` (`#e2e8f0 !important`), and `html.dark .text-slate-100` (`#f8fafc !important`).
  - **High-Contrast Column Colors**:
    - **Ref #**: `font-mono text-slate-500 dark:text-slate-300 font-semibold` (crisp, high-contrast numeric reference).
    - **Employee Name**: `font-bold text-slate-800 dark:text-white` (pure bright white in dark mode).
    - **Employee ID**: `text-slate-400 dark:text-slate-300 font-mono` (soft readable slate).
    - **Department**: `font-semibold text-slate-700 dark:text-slate-100` (bright off-white).
    - **Payroll #**: `text-slate-400 dark:text-slate-300` (accessible secondary text).
    - **Period Range**: `font-medium text-slate-700 dark:text-slate-100` (clean off-white).
    - **Period Month/Year**: `text-slate-400 dark:text-slate-300`.
    - **Gross Pay**: `font-bold text-slate-800 dark:text-slate-100 col-gross-pay` (bright crisp white).
    - **Deductions**: `font-bold text-rose-600 dark:text-rose-400 col-total-deductions` (vibrant coral rose `#fb7185`).
    - **Net Pay**: `font-bold text-emerald-600 dark:text-emerald-400 col-net-pay` (vivid emerald green `#34d399`).
    - **Created Date**: `text-slate-600 dark:text-slate-200 font-medium` (`#e2e8f0` in dark mode).
  - **Edit Payslip Modal Dark Theme**: Added full dark mode support for `#editPayslipModal` in [`resources/assets/css/app.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/resources/assets/css/app.css) covering KPI cards, tab navigation, input wrappers, currency prefixes, and footer action buttons.
  - **Recompiled Assets**: Compiled minified styles into [`public/css/tailwind.css`](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/public/css/tailwind.css) via `npm run build:css`.

---

## [2026-09-11] — Full Dark Mode System, Theme Switcher & Mobile UI/UX Responsiveness Overhaul

### 1. Complete Dark Mode System Across All Pages & Components
- **Business Need & User Goal**: Users requested a modern, high-contrast Dark Mode with a toggle button situated directly beside the top navigation bar's notification bell. The dark theme needed to cover all layout surfaces, data tables, modals, form controls, dropdowns, and notifications while guaranteeing readable text and smooth transitions.
- **Architectural Implementation**:
  - **Zero-Flicker Head Restoration**: Added immediate inline JavaScript in [`resources/views/layouts/app.blade.php`](file:///c:/Users/PC/Documents/segovia\sgpayroll\sgpayroll\resources\views\layouts\app.blade.php) `<head>` that inspects `localStorage.getItem('sgpayroll_theme')` (or system `prefers-color-scheme`) and applies the `.dark` class before DOM render, preventing any flash of unstyled light content (FOUC).
  - **Dark Mode Toggle Button**: Positioned `#themeToggleBtn` in [`layouts/app.blade.php`](file:///c:/Users/PC/Documents/segovia\sgpayroll\sgpayroll\resources\views\layouts\app.blade.php) right beside the notification bell dropdown with an animated `#themeToggleIcon` (`fa-moon` in light mode, `fa-sun` in dark mode).
  - **Theme Controller (`sidebar.js`)**: Added `initThemeToggle()` to [`public/js/sidebar.js`](file:///c:/Users/PC/Documents/segovia\sgpayroll\sgpayroll\public\js\sidebar.js) that handles click events, toggles the `.dark` class on `document.documentElement`, updates `localStorage`, and dynamically updates tooltip accessibility titles (`Switch to light mode` / `Switch to dark mode`).
  - **Comprehensive Color Palette & Contrast in `app.css`**:
    - **Background / Canvas**: `#090d16` (deep midnight slate, reducing eye fatigue).
    - **Sidebar & Elevated Panels**: `#0c1322` / `#111a2e` with subtle `#1e293b` borders.
    - **Headers & Subsurfaces**: `#16223b`.
    - **Primary High-Contrast Text**: `#f8fafc` (crisp white for headings, values, and titles).
    - **Secondary Readable Text**: `#cbd5e1` / `#e2e8f0` (clean off-white for body text and table cells).
    - **Muted Labels & Captions**: `#94a3b8` (accessible slate-400 for subtext and hints).
    - **Form Controls & Inputs**: `#0b1322` background, `#243452` border, `#f8fafc` text, with vivid `#3b82f6` focus ring.
    - **Action Buttons**: Custom dark-tinted badge buttons with glowing borders (`.admin-btn-action-view`, `.admin-btn-action-print`, `.admin-btn-action-delete`, `.admin-btn-action-success`).
    - **DataTables & Pagination**: Dark inputs, length selects, and blue-active page buttons (`.paginate_button.current`).
    - **Select2 Dropdowns**: Styled container, placeholder, search bar, and highlighted option states for dark mode.
    - **Modals & Dialogs**: Rich `#111a2e` modal body, elevated header, `#0d1527` footer, and dark backdrop overlay.
    - **Alertify Alerts**: Notifications, confirm dialogs, and popups styled for dark mode readability.

### 2. Mobile UI/UX Responsiveness Overhaul
- **Business Need & User Goal**: On mobile phones and tablet devices, the desktop sidebar lacked an overlay, pages suffered from cramped table layouts, action buttons wrapped awkwardly, and modal input fields became unreadable.
- **Implemented Mobile Enhancements**:
  - **Sidebar Clean-Up & Overlay**:
    - Removed duplicate desktop collapse toggle from the topbar, retaining only the single sidebar header arrow button (`<`) per user request.
    - Added an animated mobile backdrop overlay (`fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-25 md:hidden`) in [`layouts/app.blade.php`](file:///c:/Users/PC/Documents/segovia\sgpayroll\sgpayroll\resources\views\layouts\app.blade.php) with click-to-dismiss.
    - Added auto-dismiss for the mobile sidebar drawer when any navigation link is clicked (`@click="if (window.innerWidth < 768) sidebarOpen = false"`).
  - **Responsive Layout & Container Padding**:
    - Adjusted main container padding in [`layouts/app.blade.php`](file:///c:/Users/PC/Documents/segovia\sgpayroll\sgpayroll\resources\views\layouts\app.blade.php) from hardcoded `p-6 lg:p-8` to responsive `p-3.5 sm:p-5 md:p-6 lg:p-8`, expanding usable mobile screen width.
  - **Employee Directory ([employee/index.blade.php](file:///c:/Users/PC/Documents/segovia\sgpayroll\sgpayroll\resources\views\employee\index.blade.php))**:
    - Action bar adjusted to `flex flex-wrap items-center gap-2 sm:gap-3` so import and create buttons wrap cleanly on narrow screens.
    - Added `overflow-x-auto` to table card with reduced mobile padding `p-3.5 sm:p-5`.
    - Converted Add Employee modal input columns to responsive `grid-cols-1 sm:grid-cols-2 gap-3` so inputs remain comfortable touch targets.
  - **Payslip Management ([payslip/index.blade.php](file:///c:/Users/PC/Documents/segovia\sgpayroll\sgpayroll\resources\views\payslip\index.blade.php))**:
    - Submit row converted to `flex flex-col sm:flex-row sm:items-center justify-between gap-3` with full-width print button on phones (`w-full sm:w-auto`).
    - Filter toolbar inputs adjusted to fluid responsive widths (`w-full sm:w-auto`).
    - Added `overflow-x-auto` wrapping around the Created Payroll Directory table.
  - **Report Generation ([reports/index.blade.php](file:///c:/Users/PC/Documents/segovia\sgpayroll\sgpayroll\resources\views\reports\index.blade.php))**:
    - Action buttons converted to stack cleanly on mobile (`flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-3`) with full-width touch buttons.
  - **Employee Account Settings ([employee/account.blade.php](file:///c:/Users/PC/Documents/segovia\sgpayroll\sgpayroll\resources\views\employee\account.blade.php))**:
    - Header converted to `flex-col sm:flex-row` and action buttons wrapped in `flex flex-wrap gap-2` to prevent button row clipping.
    - Statutory deduction checkboxes adjusted from rigid 4 columns to responsive `grid-cols-2 sm:grid-cols-4 gap-2`.

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
