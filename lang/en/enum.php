<?php

use App\Enums\DiscountTypeEnum;
use App\Enums\StatusEnum;
use App\Enums\RolesEnum;


return [
    RolesEnum::class => [
        'label' => [
            RolesEnum::ADMIN->value  => 'Admin',
            RolesEnum::USER->value   => 'Operator',
        ],
    ],

    StatusEnum::class => [
        'label' => [
            StatusEnum::IN_PROGRESS->value => 'In Progress',
            StatusEnum::AWARDED->value     => 'Awarded',
            StatusEnum::CONCLUDED->value   => 'Concluded',
        ],
    ],

    DiscountTypeEnum::class => [
        'label' => [
            DiscountTypeEnum::PERCENTAGE->value => 'Percentage',
            DiscountTypeEnum::VALUE->value      => 'Value',
        ],
    ],
];
