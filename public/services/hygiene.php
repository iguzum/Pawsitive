<?php
// :: START HYGIENE CARE PAGE CONTENT
$carePage = [
    'pageTitle' => 'Hygiene Care',
    'slug' => 'hygiene-care',
    'icon' => 'bx bx-water-drop',
    'eyebrow' => 'HYGIENE CARE',
    'headline' => 'Fresh, comfortable,',
    'highlight' => 'and ready for cuddles.',
    'intro' => 'Choose grooming and hygiene care to help your pet feel clean, comfortable, and cared for.',
    'image' => 'https://images.unsplash.com/photo-1733964659477-35534815c626?auto=format&fit=crop&fm=jpg&ixid=NHwxMjA3fDA%3D&ixlib=rb-4.1.0&q=60&w=3000',
    'imageAlt' => 'Small dog wrapped in a towel after a bath',
    'imageNote' => 'A little freshening up can feel like a lot of love.',
    'shortName' => 'hygiene care',
    'sectionEyebrow' => 'A FRESH, GENTLE RESET',
    'sectionTitle' => 'Hygiene care options',
    'sectionIntro' => 'Services can be tailored to your pet’s coat, comfort, and grooming needs.',
    'packages' => [
        ['icon' => 'bx bx-water', 'title' => 'Bath and dry', 'description' => 'A gentle clean-up to leave your pet feeling fresh.', 'items' => ['Bath with suitable pet products', 'Gentle towel or blow dry', 'Coat check before and after care']],
        ['icon' => 'bx bx-cut', 'title' => 'Brushing and trimming', 'description' => 'Keep the coat manageable with care suited to its type.', 'items' => ['Brushing and light detangling', 'Coat trimming by request', 'Style and length discussed before trimming']],
        ['icon' => 'bx bx-hand', 'title' => 'Tidy-up care', 'description' => 'Ask about small grooming details that support daily comfort.', 'items' => ['Nail trimming', 'Paw and hygiene-area tidy-up', 'Ear cleaning when suitable']],
    ],
];
// :: END HYGIENE CARE PAGE CONTENT
require __DIR__ . '/care_page_template.php';
