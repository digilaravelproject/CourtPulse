<?php

return [
    'documents' => [
        'advocate' => [
            'profile_photo' => ['label' => 'Profile Photo', 'icon' => 'bi-person-bounding-box', 'required' => true],
            'bar_council_certificate' => ['label' => 'Bar Council Certificate', 'icon' => 'bi-patch-check', 'required' => true],
            'enrollment_certificate' => ['label' => 'Enrollment Certificate', 'icon' => 'bi-journal-check', 'required' => true],
            'degree_certificate' => ['label' => 'LLB / LLM Degree', 'icon' => 'bi-mortarboard', 'required' => true],
            'aadhar_card' => ['label' => 'Aadhar Card', 'icon' => 'bi-credit-card-2-front', 'required' => true],
            'pan_card' => ['label' => 'PAN Card', 'icon' => 'bi-card-text', 'required' => true],
            'practice_certificate' => ['label' => 'Practice Certificate (Sanad)', 'icon' => 'bi-award', 'required' => false],
        ],
        'clerk' => [
            'profile_photo' => ['label' => 'Profile Photo', 'icon' => 'person', 'required' => true],
            'court_id_card' => ['label' => 'Court ID Card', 'icon' => 'badge', 'required' => true],
            'clerk_appointment_letter' => ['label' => 'Appointment Letter', 'icon' => 'description', 'required' => true],
            'service_certificate' => ['label' => 'Service Certificate', 'icon' => 'workspace_premium', 'required' => true],
            'aadhar_card' => ['label' => 'Aadhar Card', 'icon' => 'credit_card', 'required' => true],
            'pan_card' => ['label' => 'PAN Card', 'icon' => 'account_balance_wallet', 'required' => true],
        ],
        'ca' => [
            'profile_photo' => ['label' => 'Profile Photo', 'icon' => 'bi-person-bounding-box', 'required' => true],
            'icai_certificate' => ['label' => 'ICAI Membership Certificate', 'icon' => 'bi-patch-check', 'required' => true],
            'aadhar_card' => ['label' => 'Aadhar Card', 'icon' => 'bi-credit-card-2-front', 'required' => true],
            'pan_card' => ['label' => 'PAN Card', 'icon' => 'bi-card-text', 'required' => true],
        ],
    ],
];
