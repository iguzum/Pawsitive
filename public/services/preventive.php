<?php
// :: START PREVENTIVE CARE PAGE CONTENT
$carePage = [
    'pageTitle' => 'Preventive Care',
    'slug' => 'preventive-care',
    'icon' => 'bx bx-pill-bottle',
    'eyebrow' => 'PREVENTIVE CARE',
    'headline' => 'A healthier future',
    'highlight' => 'starts with small steps.',
    'intro' => 'Plan ahead with care conversations about your pet’s wellness, vaccination status, and prevention needs.',
    'image' => 'https://images.unsplash.com/photo-1760530327971-f8523426c60a?auto=format&fit=crop&fm=jpg&ixid=NHwxMjA3fDA%3D&ixlib=rb-4.1.0&q=60&w=3000',
    'imageAlt' => 'Two dogs playing outdoors',
    'imageNote' => 'Keep good days coming with thoughtful prevention.',
    'shortName' => 'preventive care',
    'sectionEyebrow' => 'CARE THAT LOOKS AHEAD',
    'sectionTitle' => 'Build a routine that fits your pet',
    'sectionIntro' => 'Recommendations depend on your pet’s age, history, lifestyle, and the care team’s assessment.',
    'packages' => [
        ['icon' => 'bx bx-shield-quarter', 'title' => 'Vaccination review', 'description' => 'Review your pet’s records and discuss an appropriate vaccination plan.', 'items' => ['Bring existing vaccination records', 'Discuss age and lifestyle factors', 'Ask about recommended next visits']],
        ['icon' => 'bx bx-bug', 'title' => 'Parasite prevention', 'description' => 'Talk about prevention options suited to your pet and environment.', 'items' => ['Discuss exposure and daily routine', 'Review prevention choices with the team', 'Plan follow-up care when recommended']],
        ['icon' => 'bx bx-calendar-check', 'title' => 'Wellness follow-up', 'description' => 'Keep preventive care on your calendar as your pet’s needs change.', 'items' => ['Review ongoing wellness needs', 'Plan age-appropriate check-ins', 'Keep care notes together']],
    ],
];
// :: END PREVENTIVE CARE PAGE CONTENT
require __DIR__ . '/care_page_template.php';

