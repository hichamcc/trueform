TRUEFORM ELITE — REFERRAL SYSTEM



1. Overview



Keep the page layout as it currently is — the design and structure are good.



We only need to:



Fix the copy



Clarify the mechanics



Implement real referral logic



Adjust a few sections for clarity



Remove anything unnecessary



Everything below outlines the final structure + required functionality.



✅ 2. HERO SECTION (TOP)
Replace current text with:



Title:
Give 15% Off. Earn 10% Monthly.



Subtitle:
Invite friends to True Form Elite — they save on their first month, and you earn 10% monthly rewards for as long as they stay.



Nothing else changes visually.



✅ 3. BENEFIT CARDS (TOP PURPLE CARDS)
Left Card (Friend Discount):



Title: Give 15% Off
Text: Your friends get 15% off their first month when they join using your link.



Right Card (Your Rewards):



Title: Earn 10% Monthly
Text: You earn 10% of their monthly subscription while they remain active.



Add a tooltip icon (i) next to the title:



“Rewards are calculated monthly and apply only while your referred friend remains subscribed.”



No design changes — only text.



✅ 4. UNIQUE REFERRAL LINK MODULE



Keep the layout exactly the same.



Add text under the link:



Share this link with friends. They automatically get 15% off, and you earn 10% monthly rewards.



Behind the scenes requirements:



Each user has a unique referral code



Referral link = https://yourdomain.com/?ref=CODE



When someone subscribes with that link, we log:



who referred them



the referred user’s subscription status



the referred user’s monthly payment



✅ 5. STATS ROW



Keep these boxes but adjust:



Final stats to keep:



Total Invites



Successful Referrals



Rewards Earned (AUD)



If “Pending” is not a real backend status:



Remove the Pending box completely.



This reduces confusion.



✅ 6. PROGRESS BAR TO FREE MONTH



Keep the same design.



Update the text logic:



If 0 referrals:



“Invite 3 more friends to earn a free month.”



If 1 referral:



“Invite 2 more friends to earn a free month.”



If 2 referrals:



“Invite 1 more friend to earn a free month.”



If 3+ referrals:



“You’ve unlocked a free month! Our team will apply it to your next billing cycle.”



Backend logic:
progress = successfulReferrals / 3



When they reach 3 referrals:



Trigger a “free month earned” event



Admin is notified



Admin manually credits free month (for now)



✅ 7. SEND INVITATION MODULE



UI stays the same.



Add text under the email input:



“We’ll email your friend a 15% off link and your invitation message.”



Add pre-filled email template:



Subject: Join me on the True Form Elite 90-Day Program (15% Off)



Body:
“Hey, I’ve been using the True Form Elite 90-Day Program — it helps with energy, focus, sleep, gut health and skin.
Here’s a link that gives you 15% off your first month: [referral link]
Join me and let’s do the 90-day challenge together.”



✅ 8. OPTIONAL SHARE BUTTONS (IF EASY)



If easy to implement, add:



Copy Message



WhatsApp share



Messenger share



Not required for MVP.



✅ 9. “HOW IT WORKS” STRIP (Simple)



Place a small horizontal section under the stats row:



Title: How It Works



3 icons with text:



1. Share Your Link
Your friends get 15% off their first month.



2. They Subscribe
You earn 10% monthly from active referrals.



3. Unlock Free Months
Every 3 referrals = 1 free month for you.



This adds clarity without bulk.

11. BACKEND LOGIC SUMMARY



Implement:



Referral Table



referral_code



user_id



created_at



Referral Conversions Table



referrer_user_id



referred_user_id



subscription_active (boolean)



subscription_start_date



monthly_subscription_value (179)



discount_applied (true/false)



Rewards Table



referrer_user_id



referred_user_id



month



reward_amount (subscription_value * 10%)



status (pending/paid)



Free Month Logic



When successfulReferrals % 3 == 0



Trigger event: mark “Free Month Earned”



Admin manually applies credit to Shopify subscription (Recharge or native Shopify Subscription API)



✅ 12. ADMIN PANEL REQUIREMENTS



Admin must be able to:



See total referrals per user



See who referred who



See active subscriptions from referrals



See monthly rewards owed



See earned free months



Mark rewards as paid



Apply free month manually



This should be a simple admin dashboard — table format is fine.\