<?php

return [
    'singular'         => 'Sconta Box',
    'plural'           => 'Sconta Boxes',
    'details'          => 'Dettagli',
    'no_cover_image'   => 'Nessuna immagine di copertina',
    'view_cover_image' => 'Visualizza l\'immagine di copertina',
    'fields'    => [
        'id'              => 'ID',
        'user_id'         => 'Utente',
        'coupon_id'       => 'Buono',
        'serial'          => 'Serial',
        'name'            => 'Nome',
        'price'           => 'Prezzo',
        'discount'        => 'Sconto',
        'total'           => 'Totale',
        'expires_at'      => 'Scade il',
        'status'          => 'Stato',
        'winner_user_id'  => 'Utente vincitore',
        'credits'         => 'Crediti',
        'participants'    => 'Partecipanti',
        'max_discount_percentage' => 'Percentuale massima di sconto',
        'highlighted'     => 'In evidenza',
        'show_on_home'    => 'Mostra in home',
        'created_at'      => 'Creato il',
        'updated_at'      => 'Aggiornato il',
        'deleted_at'      => 'Cancellato il',
        'product'         => 'Prodotto',
        'select_status'   => 'Seleziona Stato',
        'select_user'     => 'Seleziona Utente',
        'select_coupon'   => 'Seleziona Buono',
        'select_product'  => 'Seleziona Prodotto',
        'select_winner_user'  => 'Seleziona Utente vincitore',
        'image'           => 'Immagine',
        'cover_image'     => 'Immagine di copertina',
        'validity'        => 'Validità',
        'validity_info'   => 'Verifica sul sito di vendita modalità, tempi e costi di spedizione del prodotto',
    ],
    'actions'   => [
        'search'              => 'Cerca un Sconto Box...',
        'add'                 => 'Aggiungi',
        'create'              => 'Crea',
        'view'                => 'Visualizza',
        'edit'                => 'Modifica',
        'update'              => 'Aggiorna',
        'delete'              => 'Cancella',
        'create_model'        => 'Aggiungi Sconto Box',
        'view_model'          => 'Vedi Sconto Box',
        'edit_model'          => 'Modifica Sconto Box',
        'update_model'        => 'Aggiorna Sconto Box',
        'delete_model'        => 'Elimina Sconto Box',
        'ask_delete'          => 'Sei sicuro di voler eliminare questo Sconta Box?',
    ],
    'responses' => [
        'created'             => 'Sconta Box è stato creato con successo!',
        'not_created'         => 'Sconta Box non è stato creato!',
        'updated'             => 'Sconta Box è stato aggiornato con successo!',
        'not_updated'         => 'Sconta Box non è stato aggiornato!',
        'deleted'             => 'Sconta Box è stato eliminato con successo!',
        'not_deleted'         => 'Sconta Box non è stato eliminato!',
        'coupon_invalid'      => 'Il Buono è invalido! Controlla se il buono non è scaduto o se non è già stato utilizzato!',
    ],
    'messages' => [
        'no_products'         => 'Nessun prodotto trovato su questo Sconta Box!',
        'concluded'           => 'ScontaBox Concluso. Stiamo elaborando le richieste, a breve verrà comunicato il vincitore!',
        //'winner_user'         => 'Complimenti, ti sei aggiudicato lo scontabox: :percentage %, di seguito trovi il codice sconto che ti sei aggiudicato, ricordati di utilizzarlo entro la data di validità sul sito indicato',
        'winner_user'         => 'COMPLIMENTI!!! Ti sei aggiudicato lo sconto del :percentage %. Il Coupon e le istruzioni ti verranno inviate tramite email entro 24 ore. Se non ricevi l’email contattaci',
        'winner_general'      => 'ScontaBox concluso, lo sconto del :percentage % è stato aggiudicato da un altro utente!',
    ],
];
