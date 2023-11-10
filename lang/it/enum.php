<?php

use App\Enums\DiscountTypeEnum;
use App\Enums\DiscountRequestStatusEnum;
use App\Enums\StatusEnum;
use App\Enums\RolesEnum;
use App\Enums\TransactionTypeEnum;


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

    TransactionTypeEnum::class => [
        'label' => [
            TransactionTypeEnum::LOGIN->value            => 'Accesso',
            TransactionTypeEnum::PROFILE_COMPLETE->value => 'Profilo completato',
            TransactionTypeEnum::LIKE->value             => 'Mi piace',
            TransactionTypeEnum::SHARE->value            => 'Condividi',
            TransactionTypeEnum::INVITE->value           => 'Invita',
            TransactionTypeEnum::EXPENDITURE->value      => 'Spesa',
            TransactionTypeEnum::MANUAL_CREDIT->value    => 'Crediti manuali',
            TransactionTypeEnum::MANUAL_DEBIT->value     => 'Debiti manuali',
        ],
    ],

    DiscountRequestStatusEnum::class => [
        'label' => [
            DiscountRequestStatusEnum::PENDING->value  => 'In attesa',
            DiscountRequestStatusEnum::APPROVED->value => 'Approvato',
            DiscountRequestStatusEnum::REJECTED->value => 'Rifiutato',
        ],
    ],
];
