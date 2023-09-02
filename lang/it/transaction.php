<?php

return [
    'singular'               => 'Transazione',
    'plural'                 => 'Transazioni',
    'transferred_to'         => 'Trasferito a',
    'transferred_from'       => 'Trasferito da',
    'spent_to'               => 'Speso a',
    'spent_from'             => 'Speso da',
    'info_spent'             => 'Addebito (Prelievo) dal conto dell\'utente :user, per prodotto :product',
    'fields' => [
        'id'                 => 'ID',
        'user_id'            => 'Utente',
        'amount'             => 'Quantità',
        'transactional_type' => 'Tipo',
        'transactional_id'   => 'Transazione',
        'name'               => 'Nome',
        'notes'              => 'Note',
        'description'        => 'Descrizione',
        'debit'              => 'Addebito',
        'credit'             => 'Credito',
        'type'               => 'Tipo',
        'created_at'         => 'Creato il',
        'updated_at'         => 'Aggiornato il',
        'deleted_at'         => 'Cancellato il',
        'select_user'        => 'Seleziona Utente',
    ],
    'actions' => [
        'cash_in'         => 'Incassa',
        'cash_out'        => 'Incassare',
        'transfer'        => 'Trasferimento',
        'transfer_to'     => 'Trasferisci a',
        'search'          => 'Cerca Transazione',
        'create'          => 'Aggiungi',
        'view'            => 'Visualizza',
        'edit'            => 'Modifica',
        'update'          => 'Aggiorna',
        'delete'          => 'Elimina',
        'create_model'    => 'Crea Transazione',
        'view_model'      => 'Visualizza Transazione',
        'edit_model'      => 'Edita Transazione',
        'ask_delete'      => 'Sei sicuro di voler eliminare questa Transazione?',
    ],
    'names' => [
        'credit'          => 'Il credito è stato aggiunto per l\'evento :actionable',
        'debit'           => 'Il debito è stato rimosso per l\'evento :actionable',
        'login_bonus'     => 'Bonus di accesso',
        'profile_bonus'   => 'Bonus profilo',
        'register_bonus'  => 'Bonus di registrazione',
        'share_bonus'     => 'Bonus di condivisione',
        'like_bonus'      => 'Bonus Like',
        'manual_bonus'    => 'Credito manuale',
        'manual_debit'    => 'Rimosso manuale',
        'expenditure_for_request' => 'Spesa per richiesta di sconto prodotto su prodotto :product',
    ],
    'event' => [
        'login'    => 'Accesso',
        'register' => 'Registrazione',
        'profile'  => 'Profilo',
        'share'    => 'Condividi',
        'like'     => 'Like',
        'manual'   => 'Manuale',
        'expenditure' => 'Spesa',
    ],
    'responses'=> [
        'created'              => 'La transazione è stata creata con successo!',
        'not_created'          => 'La transazione non è stata creata!',
        'updated'              => 'La transazione è stata aggiornata con successo!',
        'not_updated'          => 'La transazione non è stata aggiornata!',
        'deleted'              => 'La transazione è stata eliminata con successo!',
        'not_deleted'          => 'La transazione non è stata eliminata!',
        'transferred'          => 'Il trasferimento è stato creato con successo!',
        'not_transferred'      => 'Il trasferimento non è stato creato!',
        'description_updated'  => 'Descrizione aggiornata con successo!',
        'description_not_updated' => 'Descrizione non aggiornata!',
    ],
    'exceptions' => [
        'insufficient_credits'  => 'Crediti insufficienti!',
    ],
];
