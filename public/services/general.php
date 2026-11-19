<?php
// :: START GENERAL CARE PAGE CONTENT
$carePage = [
    'pageTitle' => 'General Care',
    'slug' => 'general-care',
    'icon' => 'bx bx-band-aid',
    'eyebrow' => 'GENERAL CARE',
    'headline' => 'Everyday care,',
    'highlight' => 'made personal.',
    'intro' => 'A gentle wellness visit gives you time to check in on your pet’s health, habits, and everyday needs.',
    'image' => 'https://images.unsplash.com/photo-1770836037289-e00e5f351d11?auto=format&fit=crop&fm=jpg&ixid=NHwxMjA3fDA%3D&ixlib=rb-4.1.0&q=60&w=3000',
    'imageAlt' => 'Veterinarian examining a dog during a wellness visit',
    'imageNote' => 'Small check-ins can support everyday wellbeing.',
    'shortName' => 'general care',
    'sectionEyebrow' => 'A GOOD PLACE TO START',
    'sectionTitle' => 'What a general care visit can include',
    'sectionIntro' => 'Talk through your pet’s current needs with the care team and build a visit around them.',
    'packages' => [
        ['icon' => 'bx bx-heart', 'title' => 'Wellness check', 'description' => 'A general review of your pet’s health and condition.', 'items' => ['Physical wellness check', 'Weight and general condition review', 'Time to discuss questions or concerns']],
        ['icon' => 'bx bx-food-menu', 'title' => 'Everyday care guidance', 'description' => 'Discuss practical routines that fit your pet and household.', 'items' => ['Nutrition and activity conversation', 'Age and lifestyle considerations', 'Personalized at-home care suggestions']],
        ['icon' => 'bx bx-calendar-check', 'title' => 'Next-step planning', 'description' => 'Leave with a clearer idea of what care may be helpful next.', 'items' => ['Follow-up recommendations', 'Questions for your next visit', 'Referrals or tests discussed when appropriate']],
    ],
];
// :: END GENERAL CARE PAGE CONTENT
require __DIR__ . '/care_page_template.php';

