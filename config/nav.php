<?php
return [
    [
        'icon' => 'nav-icon bi bi-speedometer',
        'route' => 'dashboard',
        'title' => 'Dashboard',
    ],
    [
        'icon' => 'nav-icon bi bi-circle',
        'route' => 'Categories.index',
        'title' => 'Categories',
        'ability' => 'categories.view',
    ],
    [
        'icon' => 'nav-icon bi bi-circle',
        'route' => 'products.index',
        'title' => 'products',
        'ability' => 'products.view',
    ],
    [
        'icon' => 'nav-icon bi bi-shield',
        'route' => 'Roles.index',
        'title' => 'Roles',
        'ability' => 'roles.view',
    ],
    [
        'icon' => 'nav-icon bi bi-shield',
        'route' => 'admins.index',
        'title' => 'Admins',
        'ability' => 'admins.view',
    ]
];