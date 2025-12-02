ere’s exactly how I want the Skin Glow Assessment to work, how it ties into the dashboard, and what I need to see in the admin side.



Overall Concept
We are removing the old “Glow AI Scan” idea.



Instead, I want a “Skin Glow Assessment” page where users do a structured check-in every 30 days (Day 0, 30, 60, 90, 180, 270, 360).
This page is the only place where skin is updated
The system will calculate a Skin Score from their answers.
The Skin Score is then displayed (read-only) on the main dashboard metrics section.
From the admin side, I need to be able to see:
all assessments
all metrics



all uploaded photos for each user.



2️⃣ Navigation / Naming Changes



Sidebar:



Replace any “Glow Scan” item with:
“Skin Glow Assessment”



Community & Support Page:



The existing tile/button that says something like “Run Glow Scan” should be changed to:
Title: Skin Glow Assessment
Subtitle: Update your Skin Score every 30 days with a simple check-in and photo.
Button text: Open Assessment



Clicking this should open / navigate to the Skin Glow Assessment page.



3️⃣ Frequency / 30-Day Logic



Users only need to complete the Skin Glow Assessment every 30 days.



Milestones we care about:



Baseline (Day 0 / when they start)



Day 30



Day 60



Day 90



Day 180



Day 270



Day 360



Skin Glow Assessment Page – Frontend Layout



This page replaces the old Glow AI Scan concept.



Header section



Title: Skin Glow Assessment



Subtext:



“You only need to do this every 30 days. These check-ins help you track real changes in your skin over your 90–360 day journey.”



If a check-in is due (based on milestone logic), show a small badge:



“Next assessment due: Day XX”



Section A – Current Status / Summary



Show:



Current Skin Score: (latest skin_score from this user’s assessments)



Change vs Baseline: (current_skin_score – baseline_skin_score, in % or absolute value)



Last Assessment: date of the last SkinAssessment record.



This should match what’s shown on the main dashboard (see section 6).



Section B – Milestone Cards



Show a horizontal or vertical list of milestone cards:



Baseline



Day 30



Day 60



Day 90



Day 180



Day 270



Day 360



Each card:



Shows milestone name



Shows status:



Pending / Completed



If completed:



Show the Skin Score for that milestone



Small thumbnail of the photo (if uploaded)



Buttons:



If pending: “Complete Check-In”



If completed: “View Details” (open read-only view of that assessment)



Section C – Check-In Form (only when they click “Complete Check-In”)



When the user clicks “Complete Check-In” on a milestone, show the assessment form.



Fields:



Sliders (1–10)
Label each like this:



“How radiant and glowing does your skin look today?”



“How smooth does your skin texture feel today?”



“How calm is your skin (redness / inflammation)?”



“How clear is your skin (breakouts/acne)?”



“How hydrated does your skin feel?”



“How firm and youthful does your skin look (fine lines)?”



“How even is your overall skin tone?”



Use simple descriptions like:



1 = Very poor



10 = Excellent



Photo Upload (optional but encouraged)



Label: Upload your skin check-in photo



Helper text:



“Optional but highly recommended. This helps you visually track your glow over time.”



Notes (optional)



Textarea:
Placeholder: "Any changes you've noticed? Breakouts, redness, smoothness, compliments, etc."



Submit button



Label: Save Assessment



On submit:



Save a record in SkinAssessments.



Calculate skin_score as the average of the sliders.



Update the milestone card to “Completed”.



Update the user’s current Skin Score value that the dashboard uses (see next section).



Show a confirmation message:



“Your Skin Glow Assessment has been saved and your Skin Score has been updated.”



6️⃣ Dashboard – How Skin Score Appears



On the main dashboard where the other metrics (Energy, Focus, Sleep, Gut) live:



The Skin Score tile should:



Display only:



Current Skin Score (from the last SkinAssessment for that user)



Change vs baseline (optional, nice to have)



Last updated date.



Users cannot edit Skin Score here.
It is read-only and comes from the Skin Glow Assessment page.



Include a small note / link under the Skin Score tile:



“Skin is tracked through your Skin Glow Assessment every 30 days.”
Button: Open Skin Glow Assessment



Clicking that button should take them directly to the Skin Glow Assessment page.



7️⃣ Admin Side – What I Need to See



I need an admin view where I can:



See all users who have submitted Skin Glow Assessments.



For each user:



See all their SkinAssessments in a table:



Date



Day in program



Milestone label



Each slider value



Overall Skin Score



See thumbnail(s) of their uploaded photos.



Click to view a larger version of the photo + their notes (if any).



Minimum requirement:



One “Skin Assessments” admin page with:



Filter by user



Filter by date / milestone



Ability to open individual assessments and view photo + metrics.



If exporting as CSV is easy, that’s a bonus but not mandatory for v1.



8️⃣ Simple Behaviour Summary



Users only do Skin Glow Assessment every ±30 days, not daily.



Skin Score is not editable from the main dashboard – only via the Assessment page.



Main dashboard Skin Score is always pulled from the latest SkinAssessment.



I can see all user assessments and photos from admin.

This is what i want to do to replace the skin glow AI scan