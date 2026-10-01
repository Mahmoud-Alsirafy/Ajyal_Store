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
        'ability' => 'category.view',
    ],
    [
        'icon' => 'nav-icon bi bi-circle',
        'route' => 'products.index',
        'title' => 'products',
        'ability' => 'product.view',
    ]
];
