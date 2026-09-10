# SGPayroll System Instructions & Project Guidelines

## 1. Documentation & Updates Logging Policy (CRITICAL RULE)

Whenever you add new features, enhance existing functionality, fix bugs, or modify the codebase in this project, you **MUST** record every change in [updates_log.md](file:///c:/Users/PC/Documents/segovia/sgpayroll/sgpayroll/updates_log.md).

### Logging Standards in `updates_log.md`:
1. **Timestamp & Title**: Record the date (e.g. `YYYY-MM-DD`) and a descriptive title for the feature or fix.
2. **Feature Overview**: Provide a clear explanation of what was added or changed and the business/operational rationale.
3. **Modified Files List**: Include clickable markdown links to every created or modified file with brief descriptions of specific changes within each file.
4. **Database & Schema Changes**: Document migrations, SQL queries, table changes, or model changes.
5. **Technical Constraints & Gotchas**: Note any important environment-specific constraints (e.g., PHP 7.4 compatibility, Docker container mounts, client browser guidelines).

---

## 2. Core Project Architecture & Rules

- **Framework**: Laravel 5.4 running in Docker on PHP 7.4 (`sgpayroll-app-1`).
- **Database**: MySQL (`sgpayroll-db-1` / `sgpayroll_db`).
- **Styling**: Tailwind CSS + Custom SGPayroll Component Utilities (`resources/assets/css/app.css` -> `public/css/tailwind.css`).
- **UI & Alerts**: Alertify (`public/js/alert/alertify.min.js`), DataTables, Select2 (`public/css/select2.min.css`, `public/js/select2.min.js`).
- **Spreadsheet / File Export**:
  - Legacy `PHPExcel` has deprecated curly brace offset syntax (`$str{$i}`) under PHP 7.4+.
  - For Excel templates, serve pre-formatted OpenXML `.xlsx` files from `public/templates/` or use pure OpenXML scripts rather than calling old PHPExcel functions that crash in PHP 7.4.
- **User Constraints**:
  - **Do NOT access or take over the user's browser** unless explicitly instructed by the user. Let the user test directly in their own browser.
  - Always provide clean JSON responses with try/catch blocks for AJAX endpoints rather than letting unhandled 500 exceptions bubble up.
