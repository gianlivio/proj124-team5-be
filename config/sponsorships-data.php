<?php

use Carbon\Carbon;

return [
    [
        'type' => 'Basic',
        'duration' => Carbon::now()->addDays(7)->toDateTimeString(), // 7 giorni
        'price' => 19.99,
        'sponsorship_description' => 'Sponsorizzazione di base per 7 giorni, ideale per chi vuole testare la visibilità aggiuntiva.'
    ],
    [
        'type' => 'Standard',
        'duration' => Carbon::now()->addDays(14)->toDateTimeString(), // 14 giorni
        'price' => 34.99,
        'sponsorship_description' => 'Sponsorizzazione standard per 14 giorni, offre maggiore visibilità e attrattiva per il tuo appartamento.'
    ],
    [
        'type' => 'Premium',
        'duration' => Carbon::now()->addDays(30)->toDateTimeString(), // 30 giorni
        'price' => 59.99,
        'sponsorship_description' => 'Sponsorizzazione premium per 30 giorni, massima visibilità e priorità nelle ricerche per attrarre più ospiti.'
    ]
];
