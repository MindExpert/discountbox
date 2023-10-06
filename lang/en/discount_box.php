<?php

return [
    'singular'         => 'Discount Box',
    'plural'           => 'Discount Boxes',
    'details'          => 'Details',
    'no_cover_image'   => 'No Cover Image',
    'view_cover_image' => 'View Cover Image',
    'fields'    => [
        'id'              => 'ID',
        'user_id'         => 'User',
        'coupon_id'       => 'Coupon',
        'serial'          => 'Serial',
        'name'            => 'Name',
        'price'           => 'Price',
        'discount'        => 'Discount',
        'total'           => 'Total',
        'expires_at'      => 'Expires at',
        'status'          => 'Status',
        'credits'         => 'Credits',
        'max_discount_percentage' => 'Max Discount Percentage',
        'participants'    => 'Participants',
        'highlighted'     => 'Highlighted',
        'show_on_home'    => 'Show on Home',
        'created_at'      => 'Created at',
        'updated_at'      => 'Updated at',
        'deleted_at'      => 'Deleted at',
        'product_id'      => 'Product',
        'select_status'   => 'Select Status',
        'select_user'     => 'Select User',
        'select_coupon'   => 'Select Coupon',
        'select_product'  => 'Select a Product',
        'image'           => 'Image',
        'cover_image'     => 'Cover Image',
        'coupon_info'     => 'Select a Coupon to be applied to this Discount Box',
        'validity'        => 'Validity',
        'validity_info'   => 'Check on the sales site the methods, times and costs of shipping the product',
    ],
    'actions'   => [
        'search'              => 'Search for a Discount Box...',
        'add'                 => 'Add',
        'create'              => 'Create',
        'view'                => 'View',
        'edit'                => 'Edit',
        'update'              => 'Update',
        'delete'              => 'Delete',
        'create_model'        => 'Add Discount Box',
        'view_model'          => 'View Discount Box',
        'edit_model'          => 'Edit Discount Box',
        'update_model'        => 'Update Discount Box',
        'delete_model'        => 'Delete Discount Box',
        'ask_delete'          => 'Are you sure you want to delete this Discount Box?',
    ],
    'responses' => [
        'created'             => 'Discount Box is successfully created!',
        'not_created'         => 'Discount Box could not be created!',
        'updated'             => 'Discount Box is successfully updated!',
        'not_updated'         => 'Discount Box could not be updated!',
        'deleted'             => 'Discount Box is successfully deleted!',
        'not_deleted'         => 'Discount Box could not be deleted!',
        'coupon_invalid'      => 'Coupon is invalid! Check if coupon has not expired or if it is not already used!',
    ],
    'messages' => [
        'no_products'         => 'No products found in this Discount Box!',
        'concluded'           => 'ScontaBox Concluso. Stiamo elaborando le richieste, a breve verrà comunicato il vincitore!',
        'winner_user'         => 'Complimenti, ti sei aggiudicato lo scontabox: :percentage %, di seguito trovi il codice sconto che ti sei aggiudicato, ricordati di utilizzarlo entro la data di validità sul sito indicato',
        'winner_general'      => 'ScontaBox aggiudicato: :percentage %!',
    ],
];
