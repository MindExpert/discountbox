<?php

return [
    'singular'               => 'Transaction',
    'plural'                 => 'Transactions',
    'transferred_to'         => 'Transferred to',
    'transferred_from'       => 'Transferred from',
    'spent_to'               => 'Spent to',
    'spent_from'             => 'Spent from',
    'info_spent'             => 'Debit (Withdrawal) from account of user :user, for product :product',
    'fields' => [
        'id'                 => 'ID',
        'user_id'            => 'User',
        'amount'             => 'Amount',
        'transactional_type' => 'Type',
        'transactional_id'   => 'Transaction Nr.',
        'name'               => 'Name',
        'notes'              => 'Notes',
        'description'        => 'Description',
        'debit'              => 'Debit',
        'credit'             => 'Credit',
        'type'               => 'Type',
        'created_at'         => 'Created at',
        'updated_at'         => 'Updated at',
        'deleted_at'         => 'Deleted at',
        'select_user'        => 'Select User',
    ],
    'actions' => [
        'cash_in'         => 'Cash In',
        'cash_out'        => 'Cash Out',
        'transfer'        => 'Transfer',
        'transfer_to'     => 'Transfer to',
        'search'          => 'Search Transaction',
        'create'          => 'Add',
        'view'            => 'View',
        'edit'            => 'Edit',
        'update'          => 'Update',
        'delete'          => 'Delete',
        'create_model'    => 'Add Transaction',
        'view_model'      => 'View Transaction',
        'edit_model'      => 'Edit Transaction',
        'ask_delete'      => 'Are you sure you want to delete this Transaction?',
    ],
    'names' => [
        'credit'           => 'Credit was added for :actionable event',
        'debit'            => 'Debit was removed for :actionable event',
        'login_bonus'      => 'Login Bonus',
        'profile_bonus'    => 'Profile Bonus',
        'register_bonus'   => 'Register Bonus',
        'share_bonus'      => 'Share Bonus',
        'like_bonus'       => 'Like Bonus',
        'invite_bonus'     => 'Invite Bonus',
        'manual_bonus'     => 'Manual Bonus',
        'manual_debit'     => 'Manual Debit',
        'expenditure_for_request' => 'Expenditure for Product Discount request on product :product ',
    ],
    'event' => [
        'login'    => 'Login',
        'register' => 'Register',
        'profile'  => 'Profile',
        'share'    => 'Share',
        'like'     => 'Like',
        'invite'   => 'Invite',
        'manual'   => 'Manual',
        'expenditure' => 'Expenditure',
    ],
    'description' => [
        'login'    => 'Upon your first daily login, you will automatically receive a bonus of :amount credits',
        'register' => 'By registering, you will receive a bonus of :amount credits',
        'profile'  => 'Completing your profile will earn you a bonus of :amount credits',
        'share'    => 'You can share the won auction on social media. For each share, you will receive a bonus of :amount credits',
        'like'     => 'You can like the won auction. For each like, you will receive a bonus of :amount credits',
        'invite'   => 'You can invite your friends to join the auction. For each friend who registers, you will receive a bonus of :amount credits',
        'manual'   => ':type Manual for :amount credits',
        'expenditure' => 'Spent for a discount request for an amount of :amount credits',
    ],
    'responses'              => [
        'created'              => 'Transaction is successfully created!',
        'not_created'          => 'Transaction could not be created!',
        'updated'              => 'Transaction is successfully updated!',
        'not_updated'          => 'Transaction could not be updated!',
        'deleted'              => 'Transaction is successfully deleted!',
        'not_deleted'          => 'Transaction could not be deleted!',
        'transferred'          => 'Transfer is successfully created!',
        'not_transferred'      => 'Transfer could not be created!',
        'description_updated'  => 'Description is successfully updated!',
        'description_not_updated' => 'Description could not be updated!',
    ],
    'exceptions' => [
        'insufficient_credits'  => 'Insufficient credits!',
    ],
];
