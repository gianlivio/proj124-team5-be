<?php

use Carbon\Carbon;

return [
    [
        'type' => 'Free',
        'duration' => Carbon::now(),
        'price' => 0.00,
        'sponsorship_description' => 'Nessuna sponsorizzazione attiva, non avrai nessun vantaggio'
    ],
    [
        'type' => 'Basic',
        'duration' => Carbon::now()->addDays(1)->toDateTimeString(),
        'price' => 2.99,
        'sponsorship_description' => 'Sponsorizzazione di base per un giorno, ideale per chi vuole testare la visibilità aggiuntiva.'
    ],
    [
        'type' => 'Standard',
        'duration' => Carbon::now()->addDays(3)->toDateTimeString(), 
        'price' => 5.99,
        'sponsorship_description' => 'Sponsorizzazione standard per 3 giorni, offre maggiore visibilità e attrattiva per il tuo appartamento.'
    ],
    [
        'type' => 'Premium',
        'duration' => Carbon::now()->addDays(6)->toDateTimeString(), 
        'price' => 9.99,
        'sponsorship_description' => 'Sponsorizzazione premium per 6 giorni, massima visibilità e priorità nelle ricerche per attrarre più ospiti.'
    ]
];
