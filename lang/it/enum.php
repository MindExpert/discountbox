<?php

use App\Enums\DiscountTypeEnum;
use App\Enums\StatusEnum;
use App\Enums\RolesEnum;


return [
    RolesEnum::class => [
        'label' => [
            RolesEnum::ADMIN->value  => 'Admin',
            RolesEnum::USER->value   => 'Operatore',
        ],
    ],

    StatusEnum::class => [
        'label' => [
            StatusEnum::IN_PROGRESS->value => 'In corso',
            StatusEnum::AWARDED->value     => 'Aggiudicato',
            StatusEnum::CONCLUDED->value   => 'Conclusi',
        ],
    ],

    DiscountTypeEnum::class => [
        'label' => [
            DiscountTypeEnum::PERCENTAGE->value => 'Percentuale',
            DiscountTypeEnum::VALUE->value      => 'Valore',
        ],
    ],
];
