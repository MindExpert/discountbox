<?php

return [
    'singular'   => 'Richiesta di sconto sul prodotto',
    'plural'     => 'Richieste di sconto sul prodotto',
    'details'    => 'Dettagli',
    'congrats'   => 'Congratulazioni',
    'view_offer' => 'Visualizza offerta',
    'fields' => [
        'id'              => 'ID',
        'user_id'         => 'Utente Partecipante',
        'discount_box_id' => 'Scontabox',
        'percentage'      => 'Percentuale',
        'approved_at'     => 'Approvato il',
        'credit'          => 'Credito',
        'notes'           => 'Note',
        'status'          => 'Stato',
        'created_at'      => 'Creato il',
        'updated_at'      => 'Aggiornato il',
        'deleted_at'      => 'Eliminato il',
        'select_user'     => 'Seleziona utente',
        'user_info'       => 'Seleziona un utente per il quale vuoi creare una richiesta di sconto.',
        'select_discount_box' => 'Seleziona Scontabox',
        'select_product'    => 'Seleziona prodotto',
        'participation_fee' => 'Quota di partecipazione',
        'sales_sites'       => 'Siti di vendita',
        'current_price'     => 'Prezzo attuale',
        'discount_you'      => 'ScontaTu (max percentage %)',
    ],
    'actions'   => [
        'search'              => 'Cerca una richiesta di sconto..',
        'add'                 => 'Aggiungi',
        'create'              => 'Crea',
        'view'                => 'Visualizza',
        'edit'                => 'Modifica',
        'update'              => 'Aggiorna',
        'delete'              => 'Elimina',
        'confirm'             => 'Conferma',
        'confirm_info'        => 'Hai inserito il conto che vorresti ottenere. Una volta confermato L\'import non puo essere modificato!',
        'create_model'        => 'Crea Richieste di sconto',
        'view_model'          => 'Visualizza Richieste di sconto',
        'edit_model'          => 'Modifica Richieste di sconto',
        'update_model'        => 'Aggiorna Richieste di sconto',
        'delete_model'        => 'Elimina Richieste di sconto',
        'ask_approve'         => 'Sei sicuro di voler approvare questa richiesta di sconto? Altre richieste verranno rifiutate.',
        'ask_reject'          => 'Sei sicuro di voler rifiutare questa richiesta di sconto?',
        'ask_delete'          => 'Sei sicuro di voler eliminare la richiesta di sconto?',
    ],
    'responses' => [
        'created'             => 'Richieste di sconto è stato creato con successo!',
        'not_created'         => 'Richieste di sconto non può essere creato!',
        'updated'             => 'Richieste di sconto è stato aggiornato con successo!',
        'not_updated'         => 'Richieste di sconto non può essere aggiornato!',
        'deleted'             => 'Richieste di sconto è stato eliminato con successo!',
        'not_deleted'         => 'Richieste di sconto non può essere eliminato!',
    ],
    'messages' => [
        'congrats'            => 'Congratulazioni!',
        'not_enough_credits'  => 'Non hai abbastanza crediti per richiedere questo sconto.',
        'discount_box_not_in_progress' => 'Questo sconto non è più disponibile.',
        'already_requested'   => 'Hai già richiesto un\'iscrizione per questo sconto.',
        'request_sent'        => 'La tua richiesta è stata inviata con successo.',
        'not_authenticated'   => 'Per poter partecipare è necessario essere loggati. Se non hai ancora un account procedi con la registrazione.',
        'error_info'          => 'Si è verificato un errore durante la creazione della richiesta di sconto. Riprova più tardi.',
        'invalid_percentage' => 'La percentuale inserita non è valida.',
    ],
    'validation' => [
        'already_requested'            => 'Hai già richiesto un\'iscrizione per questo sconto.',
        'discount_box_not_in_progress' => 'Questo sconto non è più disponibile.',
        'user_not_enough_credits'      => 'L\'utente non ha abbastanza crediti per richiedere questo sconto.',
    ]
];
