<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
<<<<<<< HEAD
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
=======
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

<<<<<<< HEAD
    'ses' => [
        'key' => env('SES_KEY'),
=======
    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

<<<<<<< HEAD
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
=======
    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
>>>>>>> 00ec27f4a978d3702ee7c4bf63b73b8dd2c762a2
        'secret' => env('STRIPE_SECRET'),
    ],

];
