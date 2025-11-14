<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuaranteeFaqController extends Controller
{
    /**
     * Display the Guarantee & FAQ page
     */
    public function index()
    {
        // FAQ data structure
        $faqs = [
            [
                'category' => 'Getting Started',
                'questions' => [
                    [
                        'question' => 'What is the True Form Elite Program?',
                        'answer' => 'The True Form Elite Program is a comprehensive 360-day wellness transformation journey. You\'ll track five key metrics daily (Energy, Focus, Sleep, Gut Health, and Skin Glow) and watch your Mito-Age Score improve over time through three distinct stages: Foundation (Days 1-90), Expansion (Days 91-180), and Mastery (Days 181-360).'
                    ],
                    [
                        'question' => 'How do I set my baseline?',
                        'answer' => 'Visit the Tracker page and complete the baseline form. Rate your current state for all five wellness metrics on a scale of 1-10. This establishes your starting point for measuring progress throughout your journey.'
                    ],
                    [
                        'question' => 'Do I need to log metrics every day?',
                        'answer' => 'While daily logging is recommended for best results and streak maintenance, missing occasional days won\'t disqualify you from the program. However, consistent tracking provides more accurate insights into your transformation.'
                    ],
                ]
            ],
            [
                'category' => 'Tracking & Metrics',
                'questions' => [
                    [
                        'question' => 'What is the Mito-Age Score?',
                        'answer' => 'Your Mito-Age Score is the average of your five wellness metrics (Energy, Focus, Sleep, Gut Health, and Skin Glow). It represents your overall cellular vitality and wellness state on a scale of 1-10.'
                    ],
                    [
                        'question' => 'How should I rate my metrics?',
                        'answer' => 'Rate each metric honestly based on how you feel that day. Use 1-3 for poor days, 4-6 for average days, and 7-10 for excellent days. Consistency in your rating approach is more important than the exact numbers.'
                    ],
                    [
                        'question' => 'Can I update a log after submitting it?',
                        'answer' => 'Yes! You can update your daily log by visiting the Tracker page on the same day. The system allows one log per day, and submitting again will update your existing entry.'
                    ],
                    [
                        'question' => 'What is the Transformation Glow percentage?',
                        'answer' => 'The Transformation Glow is a 0-100% score that shows your overall improvement from baseline. It compares your last 7 days\' average metrics against your starting baseline, normalized to show your wellness evolution.'
                    ],
                ]
            ],
            [
                'category' => 'Milestones & Rewards',
                'questions' => [
                    [
                        'question' => 'How do I unlock milestones?',
                        'answer' => 'Milestones unlock automatically when you log your metrics on or after milestone days (30, 60, 90, 120, 150, 180, 270, and 360). Each milestone recognizes your commitment and progress through different program stages.'
                    ],
                    [
                        'question' => 'What rewards do I get for reaching milestones?',
                        'answer' => 'Each milestone unlocks recognition badges and may include exclusive content, product recommendations, or special community access. Specific rewards are revealed when you reach each milestone.'
                    ],
                    [
                        'question' => 'What happens after Day 360?',
                        'answer' => 'Upon completing the full 360-day journey, you\'ll have the option to extend for another 30 days, upgrade to ongoing Elite Life membership, or continue self-tracking with lifetime dashboard access.'
                    ],
                ]
            ],
            [
                'category' => 'Community & Support',
                'questions' => [
                    [
                        'question' => 'How do I access the community?',
                        'answer' => 'Visit the Community & Support page to find links to our exclusive member community, submit your transformation case study, and access additional wellness resources.'
                    ],
                    [
                        'question' => 'Can I share my progress with others?',
                        'answer' => 'Absolutely! Use our referral program to invite friends and family. You can also submit your transformation story as a case study to inspire other members.'
                    ],
                    [
                        'question' => 'What if I need help or have questions?',
                        'answer' => 'Contact our support team at support@trueform.com or visit the Community & Support page for resources. We typically respond within 24-48 hours on business days.'
                    ],
                ]
            ],
            [
                'category' => 'Technical & Account',
                'questions' => [
                    [
                        'question' => 'Can I access my dashboard on mobile?',
                        'answer' => 'Yes! The dashboard is fully responsive and works on all devices. Simply log in through your mobile browser for the same experience as desktop.'
                    ],
                    [
                        'question' => 'How do I update my profile information?',
                        'answer' => 'Click on your profile icon in the top navigation and select "Edit Profile" to update your name, email, or password.'
                    ],
                    [
                        'question' => 'Is my health data secure?',
                        'answer' => 'Absolutely. We use industry-standard encryption and security practices. Your wellness data is private and will never be shared with third parties without your explicit consent.'
                    ],
                    [
                        'question' => 'Can I export my data?',
                        'answer' => 'Data export functionality is coming soon. You\'ll be able to download your complete tracking history in CSV or PDF format for personal records.'
                    ],
                ]
            ],
        ];

        return view('guarantee-faq', compact('faqs'));
    }
}
