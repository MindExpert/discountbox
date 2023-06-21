<?php

use App\Enums\RolesEnum;


return [
    RolesEnum::class => [
        'label' => [
            RolesEnum::ADMIN->value  => 'Admin',
            RolesEnum::USER->value   => 'Operatore',
        ],
    ],
];
