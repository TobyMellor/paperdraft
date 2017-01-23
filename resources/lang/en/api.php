<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for the response messages
    | for the API routes.
    |
    */

    'canvas-item' => [
        'success' => [
            'index'         => 'All of the canvas-items were successfully returned.',
            'store'         => 'The canvas-item was successfully stored.',
            'show'          => 'The canvas-item was successfully returned.',
            'update'        => 'The canvas-item was successfully updated.',
            'batch-update'  => 'All of the canvas-items were successfully updated.',
            'destroy'       => 'The canvas-item was successfully deleted.',
            'batch-destroy' => 'All of the canvas-items were successfully deleted.'
        ],
        'failure' => [
            'index'            => 'An error occured while returning all of the canvas-items.',
            'store'            => 'An error occured while storing the canvas-items.',
            'show'             => 'An error occured while returning the canvas-items.',
            'update'           => 'An error occured while updating the canvas-items.',
            'batch-update'     => 'An error occured while updating all of the canvas-items.',
            'destroy'          => 'An error occured while deleting the canvas-items.',
            'batch-destroy'    => 'An error occured while deleting all of the canvas-items.'
        ]
    ],
    'item' => [
        'success' => [
            'index' => 'All of the items were successfully returned.'
        ]
    ],
    'canvas-history' => [
        'success' => [
            'index' => 'All of the history records were successfully returned.',
            'store' => 'The history record was successfully stored.'
        ],
        'failure' => [
            'store' => 'An error occured while storing the history record.'
        ]
    ],
    'student' => [
        'success' => [
            'index'        => 'All of the students were successfully returned.',
            'store'        => 'The student was successfully stored.',
            'update'       => 'The student was successfully updated.',
            'destroy'      => 'The student was successfully deleted.',
            'guess-gender' => 'The students gender was successfully guessed.'
        ],
        'failure' => [
            'guess-gender' => 'The students gender could not be guessed.'
        ]
    ],
    'class-student' => [
        'success' => [
            'index'   => 'All of the class students were successfully returned.',
            'store'   => 'The class student was successfully stored.',
            'update'  => 'The class student was successfully updated.',
            'destroy' => 'The class student was successfully deleted.'
        ]
    ],
    'class' => [
        'success' => [
            'store'   => 'The class was successfully stored.',
            'destroy' => 'The class was successfully deleted.'
        ]
    ],
    'user' => [
        'success' => [
            'update' => 'Your user data has been successfully updated.'
        ]
    ]
];