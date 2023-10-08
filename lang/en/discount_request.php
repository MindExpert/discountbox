<?php

return [
    'singular'   => 'Discount Request',
    'plural'     => 'Discount Requests',
    'details'    => 'Details',
    'congrats'   => 'Congrats',
    'view_offer' => 'View Offer',
    'fields' => [
        'id'              => 'ID',
        'user_id'         => 'User',
        'discount_box_id' => 'Discount Box',
        'percentage'      => 'Percentage',
        'approved_at'     => 'Approved at',
        'credit'          => 'Credit',
        'notes'           => 'Notes',
        'status'          => 'Status',
        'created_at'      => 'Created at',
        'updated_at'      => 'Updated at',
        'deleted_at'      => 'Deleted at',
        'select_user'     => 'Select User',
        'select_discount_box' => 'Select Discount Box',
        'participation_fee' => 'Participation fee',
        'sales_sites'       => 'Sales site',
        'current_price'     => 'Current price',
        'discount_you'      => 'DiscountYou (max :percentage %)',
    ],
    'actions'   => [
        'search'              => 'Search for a discount requests..',
        'add'                 => 'Add',
        'create'              => 'Create',
        'view'                => 'View',
        'edit'                => 'Edit',
        'update'              => 'Update',
        'delete'              => 'Delete',
        'confirm'             => 'Confirm',
        'confirm_info'        => 'Have you entered the amount you would like to obtain. Once confirmed the import cannot be changed!',
        'create_model'        => 'Add Discount requests',
        'view_model'          => 'View Discount requests',
        'edit_model'          => 'Edit Discount requests',
        'update_model'        => 'Update Discount requests',
        'delete_model'        => 'Delete Discount requests',
        'ask_approve'         => 'Are you sure you want to Approve this Discount requests? Other requests will be rejected.',
        'ask_reject'          => 'Are you sure you want to Reject this Discount requests?',
        'ask_delete'          => 'Are you sure you want to delete Discount requests?',
    ],
    'responses' => [
        'created'             => 'Discount requests is successfully created!',
        'not_created'         => 'Discount requests could not be created!',
        'updated'             => 'Discount requests is successfully updated!',
        'not_updated'         => 'Discount requests could not be updated!',
        'deleted'             => 'Discount requests is successfully deleted!',
        'not_deleted'         => 'Discount requests could not be deleted!',
        'approved'            => 'Discount requests is successfully approved!',
        'not_approved'        => 'Discount requests could not be approved!',
        'rejected'            => 'Discount requests is successfully rejected!',
        'not_rejected'        => 'Discount requests could not be rejected!',
    ],
];
