<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute deve essere accettato.',
    'accepted_if' => ':attribute deve essere accettato quando :other è :value.',
    'active_url' => ':attribute non è un URL valido.',
    'after' => ':attribute deve essere una data successiva al :date.',
    'after_or_equal' => ':attribute deve essere una data successiva o uguale al :date.',
    'alpha' => ':attribute può contenere solo lettere.',
    'alpha_dash' => ':attribute può contenere solo lettere, numeri e trattini.',
    'alpha_num' => ':attribute può contenere solo lettere e numeri.',
    'array' => ':attribute deve essere un array.',
    'ascii' => ':attribute must only contain single-byte alphanumeric characters and symbols.',
    'attached' => ':attribute è già associato.',
    'before' => ':attribute deve essere una data precedente al :date.',
    'before_or_equal' => ':attribute deve essere una data precedente o uguale al :date.',
    'between' => [
        'array' => ':attribute deve avere tra :min - :max elementi.',
        'file' => ':attribute deve trovarsi tra :min - :max kilobytes.',
        'numeric' => ':attribute deve trovarsi tra :min - :max.',
        'string' => ':attribute deve trovarsi tra :min - :max caratteri.',
    ],
    'boolean' => 'Il campo :attribute deve essere vero o falso.',
    'confirmed' => 'Il campo di conferma per :attribute non coincide.',
    'current_password' => 'Password non valida.',
    'date' => ':attribute non è una data valida.',
    'date_equals' => ':attribute deve essere una data e uguale a :date.',
    'date_format' => ':attribute non coincide con il formato :format.',
    'declined' => ':attribute deve essere rifiutato.',
    'declined_if' => ':attribute deve essere rifiutato quando :other è :value.',
    'different' => ':attribute e :other devono essere differenti.',
    'digits' => ':attribute deve essere di :digits cifre.',
    'digits_between' => ':attribute deve essere tra :min e :max cifre.',
    'dimensions' => 'Le dimensioni dell\'immagine di :attribute non sono valide.',
    'distinct' => ':attribute contiene un valore duplicato.',
    'doesnt_start_with' => ':attribute non può iniziare con uno dei seguenti valori: :values.',
    'doesnt_end_with' => ':attribute non può terminare con uno dei seguenti valori: :values.',
    'email' => ':attribute non &egrave;  valido.',
    'ends_with' => ':attribute deve finire con uno dei seguenti valori: :values.',
    'enum' => 'Il campo :attribute non è valido.',
    'exists' => ':attribute selezionato non è valido.',
    'failed' => 'Credenziali non valide.',
    'file' => ':attribute deve essere un file.',
    'filled' => 'Il campo :attribute deve contenere un valore.',
    'gt' => [
        'array' => ':attribute deve contenere più di :value elementi.',
        'file' => ':attribute deve essere maggiore di :value kilobytes.',
        'numeric' => ':attribute deve essere maggiore di :value.',
        'string' => ':attribute deve contenere più di :value caratteri.',
    ],
    'gte' => [
        'array' => ':attribute deve contenere un numero di elementi uguale o maggiore di :value.',
        'file' => ':attribute deve essere uguale o maggiore di :value kilobytes.',
        'numeric' => ':attribute deve essere uguale o maggiore :value.',
        'string' => ':attribute deve contenere un numero di caratteri uguale o maggiore di :value caratteri.',
    ],
    'image' => ':attribute deve essere un\'immagine.',
    'in' => ':attribute selezionato non è valido.',
    'in_array' => 'Il valore del campo :attribute non esiste in :other.',
    'integer' => ':attribute deve essere un numero intero.',
    'ip' => ':attribute deve essere un indirizzo IP valido.',
    'ipv4' => ':attribute deve essere un indirizzo IPv4 valido.',
    'ipv6' => ':attribute deve essere un indirizzo IPv6 valido.',
    'json' => ':attribute deve essere una stringa JSON valida.',
    'lowercase' => ':attribute deve contenere solo caratteri minuscoli.',
    'lt' => [
        'array' => ':attribute deve contenere meno di :value elementi.',
        'file' => ':attribute deve essere minore di :value kilobytes.',
        'numeric' => ':attribute deve essere minore di :value.',
        'string' => ':attribute deve contenere meno di :value caratteri.',
    ],
    'lte' => [
        'array' => ':attribute deve contenere un numero di elementi minore o uguale a :value.',
        'file' => ':attribute deve essere minore o uguale a :value kilobytes.',
        'numeric' => ':attribute deve essere minore o uguale a :value.',
        'string' => ':attribute deve contenere un numero di caratteri minore o uguale a :value caratteri.',
    ],
    'mac_address' => 'Il campo :attribute deve essere un indirizzo MAC valido.',
    'max' => [
        'array' => ':attribute non può avere più di :max elementi.',
        'file' => ':attribute non può essere superiore a :max kilobytes.',
        'numeric' => ':attribute non può essere superiore a :max.',
        'string' => ':attribute non può contenere più di :max caratteri.',
    ],
    'max_digits' => ':attribute non può contenere più di :max cifre.',
    'mimes' => ':attribute deve essere del tipo: :values.',
    'mimetypes' => ':attribute deve essere del tipo: :values.',
    'min' => [
        'array' => ':attribute deve avere almeno :min elementi.',
        'file' => ':attribute deve essere almeno di :min kilobytes.',
        'numeric' => ':attribute deve essere almeno :min.',
        'string' => ':attribute deve contenere almeno :min caratteri.',
    ],
    'multiple_of' => ':attribute deve essere un multiplo di :value.',
    'not_in' => 'Il valore selezionato per :attribute non è valido.',
    'not_regex' => 'Il formato di :attribute non è valido.',
    'numeric' => ':attribute deve essere un numero.',
    'password' => [
        'uncompromised' => 'La password deve avere almeno 8 caratteri e deve contenere almeno 1 lettera maiuscola, 1 numero ed un carattere speciale.',
        'letters' => 'Password deve contenere almeno un carattere.',
        'mixed' => 'Password deve contenere almeno un carattere maiuscolo ed un carattere minuscolo.',
        'numbers' => 'Password deve contenere almeno un numero.',
        'symbols' => 'Password deve contenere almeno un simbolo.',
    ],
    'present' => 'Il campo :attribute deve essere presente.',
    'prohibited' => ':attribute non consentito.',
    'prohibited_if' => ':attribute non consentito quando :other è :value.',
    'prohibited_unless' => ':attribute non consentito a meno che :other sia contenuto in :values.',
    'prohibits' => ':attribute impedisce a :other di essere presente.',
    'regex' => 'La password deve avere almeno 8 caratteri e deve contenere almeno 1 lettera maiuscola, 1 numero ed un carattere speciale.',
    'required' => 'Il campo :attribute è richiesto.',
    'required_array_keys' => 'Il campo :attribute deve contenere voci per: :values.',
    'required_if' => 'Il campo :attribute è richiesto quando :other è :value.',
    'required_if_accepted' => ':attribute è richiesto quando :other è accettato.',
    'required_unless' => 'Il campo :attribute è richiesto a meno che :other sia in :values.',
    'required_with' => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_with_all' => 'Il campo :attribute è richiesto quando :values sono presenti.',
    'required_without' => 'Il campo :attribute è richiesto quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è richiesto quando nessuno di :values è presente.',
    'same' => ':attribute e :other devono coincidere.',
    'size' => [
        'array' => ':attribute deve contenere :size elementi',
        'file' => ':attribute deve essere :size kilobyte.',
        'numeric' => ':attribute deve essere :size.',
        'string' => ':attribute deve contenere :size caratteri.',
    ],
    'starts_with' => ':attribute deve iniziare con uno dei seguenti: :values.',
    'string' => ':attribute deve essere una stringa.',
    'timezone' => ':attribute deve essere una zona valida.',
    'unique' => ':attribute è stato già utilizzato.',
    'uploaded' => ':attribute non è stato caricato.',
    'url' => 'Il formato del campo :attribute non è valido.',
    'uuid' => ':attribute deve essere un UUID valido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    // 'custom' => [
    //     'attribute-name' => [
    //         'rule-name' => 'custom-message',
    //     ],
    // ],

    'custom' => [
        'type' => [
            'required' => 'Il tipo di utente è richiesto.',
        ],
        'name' => [
            'required' => 'Il nome è richiesto.',
        ],

        'lastname' => [
            'required' => 'Il cognome è richiesto.',
        ],
        'username' => [
            'required' => 'Il nome utente è richiesto.',
        ],
        'address'        => [
            'required'   => 'Indirizzo è richiesto.',
        ],
        'tax_id_number'  => [
            'required'   => 'P.IVA è richiesto.',
        ],
        'email'  => [
            'required'   => 'Email è richiesto.',
            'email'      => "L'e-mail non è corretta.",
            'exists'     => "L'email selezionata non è valida.",
            'format'     => 'Email non è corretto.',
            'unique'     => 'Questo indirizzo email è già utilizzato.'
        ],
        'email_amm'  => [
            'required'   => 'Email Amm è richiesto.',
            'email'      => "L'e-mail amm non è corretta.",
            'format'     => 'Email Amm non è corretto.',
            'unique'     => 'Questo indirizzo email amm è già utilizzato.'
        ],
        'email_pec'  => [
            'required'   => 'Email Pec è richiesto.',
            'email'      => "L'e-mail pec non è corretta.",
            'exists'     => 'xhena',
            'format'     => 'Email Pec non è corretto.',
            'unique'     => 'Questo indirizzo email pec è già utilizzato.'
        ],
        [
            // 'password' => [
            //     'uncompromised' => 'La password deve avere almeno 8 caratteri e deve contenere almeno 1 lettera maiuscola, 1 numero ed un carattere speciale:attribute.',
            //     'letters' => 'Password deve contenere almeno un carattere.',
            //     'mixed' => 'Password deve contenere almeno un carattere maiuscolo ed un carattere minuscolo.',
            //     'numbers' => 'Password deve contenere almeno un numero.',
            //     'symbols' => 'Password deve contenere almeno un simbolo.',
            // ],
            'regex'      => 'Password deve contenere almeno 1 lettera minuscola, 1 lettera maiuscola, 1 cifra ,1 carattere speciale!'
        ],
        'password_confirmation' =>
        [
            'required'   => 'Conferma password è richiesto.',
        ],
        'company'        => [
            'required'   => 'Azienda è richiesto.',
        ],
        'cell_number'   => [
            'required'   =>'Il numero di celular è richiesto',
            'regex'      =>'Il formato del numero di celular non è valido.',
            'min'        =>'Deve contenere almeno 10 numeri.'
        ],
        'phone_number'   => [
            'required'   =>'Il numero di telefono è richiesto.',
            'regex'      =>'Il formato del numero di telefono non è valido.',
            'min'        =>'Deve contenere almeno 10 numeri.'
        ],
        'fiscal_code'   => [
            'required'   =>'Il codice fiscale è richiesto.',
        ],
        'agency_name'   => [
            'required'   =>"Azienda è richiesta.",
        ],
        // 'birthdate'     =>[
        //     'required'   => 'Data di nascita è richiesto.',
        //     'before_or_equal' => 'Devi avere almeno 18 anni.',
        // ],

        // 'luogo' => [
        //     'required' => 'Luogo è richiesto.',
        // ],
        'country' => [
            'required_if' => 'Nazione è richiesta.',
        ],
        'country_back' => [
            'required' => 'Nazione è richiesta.',
        ],
        'region' => [
            'required_if' => 'Regione è richiesto.',
        ],
        'region_back' => [
            'required' => 'Regione è richiesto.',
        ],
        'city_back' => [
            'required' => 'Città è richiesta.',
        ],
        'city' => [
            'required_if' => 'Città è richiesta.',
        ],
        'zip_code'   => [
            'required'   =>'Cap è richiesto.',
            'numeric'    =>'Cap deve essere un numero.'
        ],

        'nacionality'   => [
            'required'   =>'Scegli la nazionalità.',

        ],

        'district'   => [
            'required_if'   =>'Provincia è richiesta.',
        ],

        'district_back' => [
            'required'   =>'Provincia è richiesta.',
        ],
        'state_id' => [
            'required_if' => 'Regione è richiesto.',
        ],

        'province_id' => [
            'required_if' => 'Provincia è richiesta.',
        ],

        'city_id' => [
            'required_if' => 'Città è richiesta.',
        ],

        'url' => [
            'required' => "L'Url è richiesta.",
            'regex'    => "Il formato dell'URL non è valido."
        ],
        '0' => [
            'required' => 'Il nome è richiesto.',
        ],
        '1' => [
            'required' => 'Email è richiesto.',
            'email'     => 'Email non è corretto.',
            'unique'    => 'Questo email è già utilizzato.',
        ],
        '4' => [
            'required' => 'P.IVA è richiesto.',
        ],
        '5' => [
            'required' => 'Azienda è richiesto.',
        ],
        '6' => [
            'required' => 'Il numero di telefono è richiesto.',
        ],
        '8' => [
            'required' => 'Il nome di regione è richiesto.',
        ],
        '9' => [
            'required' => 'Il codice fiscale è richiesto.',
        ],
        '11' => [
            'required' => 'Città è richiesta.',
        ],
    ],
      // Pop Up Validation
    'popUp' => [
        'title'            => 'Grazie per esserti iscritto ad Ascendi!',
        'description'      => "La tua iscrizione sarà ora valutata. Riceverai una mail per terminare l’attivazione dell’account!",
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
