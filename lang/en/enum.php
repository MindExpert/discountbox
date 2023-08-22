<?php

use App\Enums\DiscountTypeEnum;
use App\Enums\ProductDiscountRequestStatusEnum;
use App\Enums\StatusEnum;
use App\Enums\RolesEnum;
use App\Enums\TransactionTypeEnum;


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

    TransactionTypeEnum::class => [
        'label' => [
            TransactionTypeEnum::LOGIN->value            => 'Login',
            TransactionTypeEnum::PROFILE_COMPLETE->value => 'Profile Complete',
            TransactionTypeEnum::LIKE->value             => 'Like',
            TransactionTypeEnum::SHARE->value            => 'Share',
            TransactionTypeEnum::EXPENDITURE->value      => 'Expenditure',
            TransactionTypeEnum::MANUAL_CREDIT->value    => 'Manual Credit',
            TransactionTypeEnum::MANUAL_DEBIT->value     => 'Manual Debit',
        ],
    ],

    ProductDiscountRequestStatusEnum::class => [
        'label' => [
            ProductDiscountRequestStatusEnum::PENDING->value  => 'Pending',
            ProductDiscountRequestStatusEnum::APPROVED->value => 'Approved',
            ProductDiscountRequestStatusEnum::REJECTED->value => 'Rejected',
        ],
    ],
];
