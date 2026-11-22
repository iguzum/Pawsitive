<?php
// :: START DIAGNOSTIC CARE PAGE CONTENT
$carePage = [
    'pageTitle' => 'Diagnostic Care',
    'slug' => 'diagnostic-care',
    'icon' => 'bx bx-syringe',
    'eyebrow' => 'DIAGNOSTIC CARE',
    'headline' => 'Find the next step',
    'highlight' => 'with clearer answers.',
    'intro' => 'When something feels off, a careful assessment can help the care team discuss what to check next.',
    'image' => 'https://images.unsplash.com/photo-1770836037183-e0b4471fe2c0?auto=format&fit=crop&fm=jpg&ixid=NHwxMjA3fDA%3D&ixlib=rb-4.1.0&q=60&w=3000',
    'imageAlt' => 'Veterinarian performing an ultrasound examination on a dog',
    'imageNote' => 'Thoughtful testing starts with understanding your pet.',
    'shortName' => 'diagnostic care',
    'sectionEyebrow' => 'UNDERSTAND WHAT’S GOING ON',
    'sectionTitle' => 'A guided diagnostic visit',
    'sectionIntro' => 'The care team can recommend suitable next steps after reviewing your pet and their symptoms.',
    'packages' => [
        ['icon' => 'bx bx-note', 'title' => 'Concern and history review', 'description' => 'Start with what you have noticed and when it began.', 'items' => ['Discuss symptoms and recent changes', 'Review relevant health history', 'Bring previous results if available']],
        ['icon' => 'bx bx-test-tube', 'title' => 'Recommended testing', 'description' => 'Testing options are discussed based on the initial assessment.', 'items' => ['Blood work may be recommended', 'Imaging may be discussed when suitable', 'The team explains the next step before proceeding']],
        ['icon' => 'bx bx-message-detail', 'title' => 'Results and follow-up', 'description' => 'Get help understanding findings and possible next steps.', 'items' => ['Review available results with the team', 'Discuss follow-up recommendations', 'Ask questions about ongoing care']],
    ],
];
// :: END DIAGNOSTIC CARE PAGE CONTENT
require __DIR__ . '/care_page_template.php';

