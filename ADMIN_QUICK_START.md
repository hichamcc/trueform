# Admin Panel - Quick Start Guide

## Access the Admin Panel

**URL:** `http://localhost:8000/admin`

**Admin Login Credentials:**
- Email: `admin@gmail.com`
- Password: `password`
- Status: Admin privileges enabled

**Regular User Account:**
- Email: `user@gmail.com`
- Password: `password`
- Status: Regular user (no admin access)

---

## Admin Panel Features

### 1. Dashboard (`/admin`)
- **Overview stats**: Total users, active programs, completion rate, average improvement
- **Recent activity**: New registrations, milestone unlocks, daily logs
- **Quick metrics**: Baselines completed, total logs, average logs per user

### 2. User Management (`/admin/users`)
**Features:**
- View all registered users with search and filters
- Filter by admin status (Admin/User)
- Filter by program status (Active/Inactive)
- View detailed user profiles
- Promote/demote admin privileges
- Activate/deactivate user programs
- Export individual user data (JSON)

**Actions per user:**
- View full profile with baseline, logs, milestones
- Toggle admin status
- Toggle program active status
- Export user data

### 3. Program Management (`/admin/programs`)
**Features:**
- View all 90-day program enrollments
- See current day, days remaining, and status
- Filter by program status
- Track baseline completion
- Monitor user engagement

### 4. Analytics & Reports (`/admin/analytics`)
**Features:**
- Average improvement by metric (Energy, Focus, Sleep, Gut Health, Skin Glow)
- Milestone completion rates (Day 30, 60, 90)
- Engagement statistics (total logs, average logs per user, active users)
- Export analytics report (JSON)

### 5. Daily Logs Management (`/admin/logs`)
**Features:**
- View all daily logs submitted by users
- Filter by date range
- Search by user name/email
- Export logs as CSV
- Stats: Total logs, logs today, average Mito-Age score

### 6. Milestones Management (`/admin/milestones`)
**Features:**
- View all milestone unlocks
- See Day 30, 60, and 90 achievement counts
- Track reward claim status
- Filter by milestone day and date range

### 7. Glow Scans Management (`/admin/glow-scans`)
**Features:**
- View all glow scan submissions
- Track scans per week
- Search by user

### 8. Data Exports (`/admin/exports`)
**Export Options:**
- **Users CSV**: All user data with enrollment status
- **Daily Logs CSV**: All daily logs with all metrics
- **Baselines CSV**: All baseline metrics
- **Complete Package (JSON)**: Everything in one file

### 9. Settings (`/admin/settings`)
**Features:**
- View all admin users
- System information (Laravel version, PHP version)

---

## How to Promote a User to Admin

### Method 1: Via Tinker (Command Line)
```bash
php artisan tinker
```

Then run:
```php
$user = User::where('email', 'user@example.com')->first();
$user->is_admin = true;
$user->save();
```

### Method 2: Via Admin Panel
1. Login as admin
2. Go to `/admin/users`
3. Click on a user
4. Click "Promote to Admin"

---

## Security Features

- **Middleware Protection**: All admin routes protected by `auth` + `admin` middleware
- **Access Control**: Only users with `is_admin = true` can access admin panel
- **Self-Protection**: Admins cannot demote themselves
- **CSRF Protection**: All forms protected against CSRF attacks

---

## Common Admin Tasks

### View User Progress
1. Go to `/admin/users`
2. Search for user by name or email
3. Click "View Details"
4. See their baseline, daily logs, milestones, and program status

### Export Data for Analysis
1. Go to `/admin/exports`
2. Choose export type (Users, Logs, Baselines, or Complete)
3. Click the export button
4. Download starts automatically

### Monitor Program Health
1. Go to `/admin/analytics`
2. View average improvements across all metrics
3. Check milestone completion rates
4. Review engagement statistics

### Track Daily Activity
1. Go to `/admin` (dashboard)
2. See "Today's Logs" metric
3. View recent daily logs table
4. Monitor recent milestone unlocks

---

## Navigation

**Sidebar Menu:**
- Dashboard - Overview stats and activity
- Users - User management
- Programs - 90-day program tracking
- Analytics - Deep insights and reports
- Daily Logs - All log submissions
- Milestones - Achievement tracking
- Glow Scans - Skin analysis submissions
- Exports - Bulk data export
- Settings - Admin configuration

**Top Bar:**
- Admin badge (indicates admin status)
- User info and logout
- "Back to Dashboard" link (returns to customer dashboard)

---

## Troubleshooting

### Cannot Access Admin Panel (403 Error)
**Solution:** Make sure your user has `is_admin = true`
```bash
php artisan tinker --execute="User::where('email', 'your@email.com')->first()->update(['is_admin' => true]);"
```

### Middleware Alias Not Found
**Solution:** Clear config cache
```bash
php artisan config:clear
php artisan cache:clear
```

### View Not Found
**Solution:** Make sure all views are created in `resources/views/admin/`

### Routes Not Working
**Solution:** Clear route cache
```bash
php artisan route:clear
```

---

## Files Created

### Middleware
- `app/Http/Middleware/IsAdmin.php`

### Controllers (9)
- `app/Http/Controllers/Admin/AdminDashboardController.php`
- `app/Http/Controllers/Admin/AdminUserController.php`
- `app/Http/Controllers/Admin/AdminProgramController.php`
- `app/Http/Controllers/Admin/AdminAnalyticsController.php`
- `app/Http/Controllers/Admin/AdminLogController.php`
- `app/Http/Controllers/Admin/AdminMilestoneController.php`
- `app/Http/Controllers/Admin/AdminGlowScanController.php`
- `app/Http/Controllers/Admin/AdminExportController.php`
- `app/Http/Controllers/Admin/AdminSettingsController.php`

### Views (16)
- `resources/views/admin/layouts/admin.blade.php` (Main layout with sidebar)
- `resources/views/admin/dashboard/index.blade.php`
- `resources/views/admin/users/index.blade.php`
- `resources/views/admin/users/show.blade.php`
- `resources/views/admin/programs/index.blade.php`
- `resources/views/admin/programs/show.blade.php`
- `resources/views/admin/analytics/index.blade.php`
- `resources/views/admin/logs/index.blade.php`
- `resources/views/admin/logs/show.blade.php`
- `resources/views/admin/milestones/index.blade.php`
- `resources/views/admin/glow-scans/index.blade.php`
- `resources/views/admin/glow-scans/show.blade.php`
- `resources/views/admin/exports/index.blade.php`
- `resources/views/admin/settings/index.blade.php`

### Routes
- 25 admin routes added to `routes/web.php`
- All routes prefixed with `/admin`
- All routes protected by `auth` and `admin` middleware

### Database
- Migration already exists: `2025_11_08_111845_add_is_admin_to_users_table.php`
- Field: `is_admin` (boolean, default: false)

---

## Design Consistency

The admin panel maintains the same dark matte theme with silver accents:
- **Background**: `#0a0a0a`
- **Cards**: `#1a1a2e` to `#16213e` gradients
- **Admin Accent**: Blue (#3b82f6) for admin-specific elements
- **Success**: Green for positive metrics
- **Warning**: Yellow for milestones
- **Danger**: Red for issues

---

## Next Steps (Optional Enhancements)

1. **Add Chart.js visualizations** for:
   - User growth over time
   - Daily log submission trends
   - Mito-Age score distribution

2. **Email notifications** when:
   - New users register
   - Milestones are unlocked
   - Users go inactive

3. **Advanced filters** on all tables:
   - Date range pickers
   - Multi-select filters
   - Saved filter presets

4. **Bulk actions**:
   - Bulk email users
   - Bulk export selections
   - Bulk program modifications

5. **Role-based permissions**:
   - Super admin vs regular admin
   - View-only admin access
   - Custom permission sets

---

**Last Updated:** 2025-11-08
**Status:** ✅ Fully functional and ready to use
