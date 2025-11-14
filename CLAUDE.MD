# True Form Elite - 90 Day Wellness Tracking Dashboard

## Project Overview
A premium, app-like customer dashboard for the True Form wellness brand. Customers track their personal transformation over 90 days, logging metrics like energy, focus, sleep, gut health, and skin glow. The system compares baseline data vs ongoing progress in real-time with charts, percentages, and a luxury mobile app experience.

## Tech Stack
- **Backend**: Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS 4, Vanilla JavaScript
- **Authentication**: Laravel Breeze (Blade stack)
- **Icons**: Blade Icons with Phosphor Icons
- **Database**: SQLite (development) - PostgreSQL/MySQL ready for production
- **Design**: Dark matte theme with silver accents

---

## Database Schema

### Tables Created:

1. **users**
   - Standard Laravel authentication table
   - Fields: id, name, email, password, email_verified_at, remember_token, timestamps

2. **baselines**
   - Stores initial wellness metrics (starting point)
   - Fields:
     - user_id (foreign key)
     - energy (decimal 3,1) - Energy level 1-10
     - focus (decimal 3,1) - Focus level 1-10
     - sleep (decimal 3,1) - Sleep quality 1-10
     - gut_health (decimal 3,1) - Gut health 1-10
     - skin_glow (decimal 3,1) - Skin glow 1-10
     - mito_age_score (virtual column) - Auto-calculated average
     - timestamps

3. **daily_logs**
   - Daily tracking entries
   - Fields:
     - user_id (foreign key)
     - log_date (date) - unique per user per day
     - energy, focus, sleep, gut_health, skin_glow (decimal 3,1)
     - mito_age_score (virtual column) - Auto-calculated average
     - notes (text, nullable) - Optional daily notes
     - timestamps
   - Unique constraint: [user_id, log_date]

4. **milestones**
   - Achievement tracking for Day 30, 60, 90
   - Fields:
     - user_id (foreign key)
     - milestone_day (integer) - 30, 60, or 90
     - unlocked_at (timestamp, nullable)
     - reward_claimed (boolean, default false)
     - reward_title (string, nullable)
     - reward_description (text, nullable)
     - timestamps
   - Unique constraint: [user_id, milestone_day]

5. **user_program_enrollments**
   - Program enrollment and progress tracking
   - Fields:
     - user_id (foreign key, unique)
     - start_date (date)
     - is_active (boolean, default true)
     - baseline_completed (boolean, default false)
     - timestamps

---

## Features Implemented

### 1. Dashboard Pages (4 pages)

#### **Welcome/Dashboard** (`/dashboard`)
- Hero section with current day counter and progress bar
- Quick stats: Mito-Age Score, Today's Log Status, Baseline Status
- Recent activity log (last 7 entries)
- Milestone preview (Day 30/60/90)
- Quick action buttons

#### **Tracker** (`/dashboard/tracker`)
- Baseline setup form (first-time users)
- Daily log form with 5 metrics (1-10 scale)
- Optional notes field
- Baseline summary display (once set)
- Visual feedback and validation
- Tracking tips section

#### **Progress & Milestones** (`/dashboard/progress`)
- Mito-Age Score comparison (baseline vs current)
- Detailed metrics comparison with percentage changes
- Color-coded progress bars (green=improvement, red=decline)
- Timeline visualization (bar chart)
- Milestone badges with unlock status
- Progress insights with AI-like recommendations

#### **Community & Support** (`/dashboard/community`)
- Resource cards:
  - Run Glow Scan (AI skin analysis)
  - Submit Case Study (Google Form)
  - Join Community (community platform)
  - Referral Program (invite friends)
- Community stats showcase
- FAQ section with expandable details
- Support contact information

---

## Key Functionality

### Auto-Calculated Mito-Age Score
- Virtual database column calculates: `(energy + focus + sleep + gut_health + skin_glow) / 5`
- Updates automatically on insert/update
- Displayed throughout dashboard

### Progress Tracking
- Automatic day counter from enrollment date
- Days remaining calculator (90 - current_day)
- Visual progress bars and percentages

### Baseline vs Current Comparisons
- Real-time percentage change calculations
- Identifies strongest improvement metric
- Color-coded feedback (green/red)

### Automatic Milestone Unlocking
- Checks on every daily log submission
- Unlocks Day 30/60/90 milestones automatically
- Rewards ready to claim
- Visual badge system

### Conditional Color Formatting
- Green for improvements (positive change)
- Red for declines (negative change)
- Gray for neutral/baseline states

---

## Routes Structure

```php
// Public routes
GET  /                          - Marketing landing page
GET  /register                  - User registration
GET  /login                     - User login
POST /login                     - Process login
POST /logout                    - Logout user

// Authenticated routes (requires login)
GET  /dashboard                 - Welcome page
GET  /dashboard/tracker         - Tracking forms
POST /dashboard/tracker/baseline - Save baseline metrics
POST /dashboard/tracker/log     - Save daily log
GET  /dashboard/progress        - Progress & Milestones
GET  /dashboard/community       - Community & Support

// Profile routes
GET    /profile                 - Edit profile
PATCH  /profile                 - Update profile
DELETE /profile                 - Delete account
```

---

## Design System

### Color Palette
**Dark Theme:**
- Background: `#0a0a0a` (deep black)
- Card background: `#1a1a2e` (dark navy)
- Secondary card: `#16213e` (navy blue)
- Border: `#2a2a3e` (subtle border)

**Silver Accents:**
- silver-50: `#f8f8f8`
- silver-100: `#f0f0f0`
- silver-200: `#e4e4e4`
- silver-300: `#d1d1d1`
- silver-400: `#b4b4b4`
- silver-500: `#9a9a9a`
- silver-600: `#818181`
- silver-700: `#6a6a6a`
- silver-800: `#5a5a5a`
- silver-900: `#4e4e4e`

**Status Colors:**
- Green: Improvements, success states
- Red: Declines, warnings
- Yellow: Pending actions
- Blue: Informational

### Typography
- Font Family: Figtree (sans-serif)
- Headings: Bold, gradient text effects
- Body: Regular, gray tones for readability

### UI Components
- Rounded corners: `rounded-xl` (12px), `rounded-2xl` (16px)
- Shadows: Subtle for depth, `shadow-lg` for primary actions
- Gradients: Silver gradients for primary buttons, dark gradients for cards
- Borders: Thin borders with low opacity (`border-silver-900/30`)

---

## Models & Relationships

### User Model
```php
// Relationships
hasOne(Baseline)
hasMany(DailyLog)
hasMany(Milestone)
hasOne(UserProgramEnrollment)
```

### Baseline Model
```php
// Fillable: user_id, energy, focus, sleep, gut_health, skin_glow
belongsTo(User)
```

### DailyLog Model
```php
// Fillable: user_id, log_date, energy, focus, sleep, gut_health, skin_glow, notes
belongsTo(User)
```

### Milestone Model
```php
// Fillable: user_id, milestone_day, unlocked_at, reward_claimed, reward_title, reward_description
belongsTo(User)
// Method: isUnlocked()
```

### UserProgramEnrollment Model
```php
// Fillable: user_id, start_date, is_active, baseline_completed
belongsTo(User)
// Methods: getCurrentDay(), getDaysRemaining(), isCompleted()
```

---

## External Integration Points

### Placeholder Links (to be configured)
1. **Glow Scan** - AI skin analysis app
   - Current: `#`
   - Update to actual app URL

2. **Case Study Form** - Google Form submission
   - Current: `#`
   - Update to actual Google Form URL

3. **Community Platform** - Forum/Discord/Slack
   - Current: `#`
   - Update to community platform URL

4. **Referral Program** - Invite system
   - Current: `#`
   - Update to referral platform URL

5. **Support Email** - Contact support
   - Current: `support@trueform.com`
   - Update to actual support email

---

## Installation & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 20.19+ or 22.12+
- SQLite (or MySQL/PostgreSQL for production)

### Installation Steps

```bash
# 1. Install PHP dependencies
composer install

# 2. Install Node dependencies
npm install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Run database migrations
php artisan migrate

# 6. Build frontend assets
npm run build
# OR for development with hot reload:
npm run dev

# 7. Start the development server
php artisan serve
```

### Access the Application
- URL: `http://localhost:8000`
- Register a new account
- Complete onboarding flow

---

## User Journey Flow

### First-Time User
1. **Register** → Create account with email/password
2. **Login** → Access dashboard
3. **Auto-enrollment** → Automatically enrolled in 90-day program (start date = today)
4. **Set Baseline** → Prompted to enter initial metrics
5. **Daily Tracking** → Log metrics daily

### Returning User
1. **Login** → Access dashboard
2. **Dashboard Overview** → See progress, current day, Mito-Age Score
3. **Log Today's Metrics** → Quick access to tracker
4. **View Progress** → Charts, comparisons, milestones
5. **Community Access** → Resources and support

### Milestone Unlocking
- **Day 30+** → Milestone unlocked automatically on next log submission
- **Day 60+** → Second milestone unlocked
- **Day 90+** → Final milestone and program completion

---

## Business Logic

### Mito-Age Score Calculation
```
Mito-Age Score = (Energy + Focus + Sleep + Gut Health + Skin Glow) / 5
```
- Calculated as virtual column in database
- Updates automatically on save
- Displayed with 1 decimal precision

### Day Counter Logic
```php
Current Day = (Today - Start Date) + 1
Days Remaining = max(0, 90 - Current Day)
Is Completed = Current Day > 90
```

### Milestone Logic
- Checks on every daily log submission
- Automatically creates/updates milestone records
- Sets `unlocked_at` timestamp
- Pre-fills reward title and description

### Daily Log Constraints
- One log per user per day
- Uses `updateOrCreate` to allow edits
- Unique constraint enforced at database level

---

## Production Checklist

### Configuration
- [ ] Update `.env` with production database credentials
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure mail driver for notifications
- [ ] Set up proper `APP_URL`

### External Services
- [ ] Replace Glow Scan URL with actual app link
- [ ] Create and link Google Form for case studies
- [ ] Set up community platform and add link
- [ ] Configure referral program integration
- [ ] Set up support email address

### Database
- [ ] Migrate to PostgreSQL or MySQL
- [ ] Run `php artisan migrate --force`
- [ ] Set up database backups
- [ ] Configure connection pooling

### Enhancements
- [ ] Add Chart.js for interactive charts
- [ ] Implement email notifications for milestones
- [ ] Add push notifications (optional)
- [ ] Integrate actual Glow Scan API
- [ ] Add user profile image uploads
- [ ] Implement actual referral tracking system
- [ ] Add export data functionality (CSV/PDF)
- [ ] Set up analytics tracking

### Performance
- [ ] Enable Laravel caching (`php artisan config:cache`)
- [ ] Optimize database queries with eager loading
- [ ] Compress images and assets
- [ ] Set up CDN for static assets
- [ ] Enable Redis for sessions/cache

### Security
- [ ] Enable HTTPS/SSL
- [ ] Set up rate limiting
- [ ] Configure CORS if needed
- [ ] Review and update security headers
- [ ] Set up regular security audits

---

## File Structure

```
true-form-dashboard/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Dashboard/
│   │           ├── WelcomeController.php
│   │           ├── TrackerController.php
│   │           ├── ProgressController.php
│   │           └── CommunityController.php
│   └── Models/
│       ├── User.php
│       ├── Baseline.php
│       ├── DailyLog.php
│       ├── Milestone.php
│       └── UserProgramEnrollment.php
├── database/
│   └── migrations/
│       ├── *_create_baselines_table.php
│       ├── *_create_daily_logs_table.php
│       ├── *_create_milestones_table.php
│       └── *_create_user_program_enrollments_table.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── dashboard.blade.php
│       └── dashboard/
│           ├── welcome.blade.php
│           ├── tracker.blade.php
│           ├── progress.blade.php
│           └── community.blade.php
├── routes/
│   ├── web.php
│   └── auth.php (Breeze)
├── tailwind.config.js
├── vite.config.js
├── composer.json
├── package.json
└── CLAUDE.MD (this file)
```

---

## Testing the Application

### Manual Testing Steps

1. **Registration & Login**
   - Register new account
   - Verify email validation
   - Test login/logout

2. **Baseline Setup**
   - Access dashboard
   - Complete baseline form
   - Verify Mito-Age Score calculation
   - Check form validation (1-10 range)

3. **Daily Logging**
   - Log today's metrics
   - Update existing log
   - Add notes
   - Verify success message

4. **Progress Tracking**
   - View progress page
   - Check percentage calculations
   - Verify color coding (green/red)
   - Test with multiple logs

5. **Milestones**
   - Fast-forward days (modify enrollment start_date in DB)
   - Log metrics to trigger milestone unlock
   - Verify Day 30/60/90 badges appear
   - Test milestone states

6. **Navigation**
   - Test all menu links
   - Verify active states
   - Check mobile responsiveness
   - Test logout

---

## API Endpoints for Future Mobile App

When building a mobile app, these endpoints can be created:

```
POST   /api/auth/register
POST   /api/auth/login
POST   /api/auth/logout

GET    /api/user
GET    /api/user/enrollment
GET    /api/user/baseline
POST   /api/user/baseline

GET    /api/logs
POST   /api/logs
PUT    /api/logs/{id}
GET    /api/logs/today

GET    /api/milestones
POST   /api/milestones/{id}/claim

GET    /api/progress/stats
GET    /api/progress/chart-data
```

---

## Support & Maintenance

### Common Issues

**Issue**: Mito-Age Score not calculating
- **Solution**: Check that database supports virtual columns (MySQL 5.7+, PostgreSQL, SQLite)

**Issue**: Milestones not unlocking
- **Solution**: Verify enrollment start_date is set correctly and getCurrentDay() method works

**Issue**: Can't log metrics
- **Solution**: Check that baseline is completed first

**Issue**: Styles not loading
- **Solution**: Run `npm run build` and clear browser cache

---

## Credits

**Developed for**: True Form Wellness Brand
**Project Type**: MVP Dashboard
**Timeline**: Fast-track development
**Purpose**: Client demonstration and early user testing

**Technologies**:
- Laravel Framework (Taylor Otwell)
- Tailwind CSS (Adam Wathan)
- Blade Icons (Blade UI Kit)
- Laravel Breeze (Laravel Team)

---

## License & Usage

This is a proprietary application developed for True Form. All rights reserved.

---

## Contact

For questions about this project:
- **Email**: [Your contact email]
- **Client**: True Form Elite Program

---

**Last Updated**: 2025-11-04
**Version**: 1.0.0 (MVP)
**Status**: ✅ Complete and ready for client review
