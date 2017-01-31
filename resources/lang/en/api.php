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
            'index'         => 'An error occured while returning all of the canvas-items.',
            'store'         => 'An error occured while storing the canvas-items.',
            'show'          => 'An error occured while returning the canvas-items.',
            'update'        => 'An error occured while updating the canvas-items.',
            'batch-update'  => 'An error occured while updating all of the canvas-items.',
            'destroy'       => 'An error occured while deleting the canvas-items.',
            'batch-destroy' => 'An error occured while deleting all of the canvas-items.'
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
            'store'   => 'The class was successfully updated.',
            'destroy' => 'The class was successfully deleted.'
        ],
        'failure' => [
            'store'   => 'An error occured while storing the class.',
            'update'  => 'An error occured while updating the class.',
            'destroy' => 'An error occured while deleting the class.',
        ]
    ],
    'user' => [
        'success' => [
            'store'  => 'The user has successfully been invited!',
            'update' => 'Your user data has been successfully updated.'
        ],
        'failure' => [
            'store' => [
                'too-many-users' => 'You can\'t invite any more users! You\'ve reached your max! (100)',
                'no-priviledge'  => 'You don\'t have the correct permissions to do that!',
                'invalid-email'  => 'The email entered was invalid or it already exists in the system!'
            ]
        ]
    ],
    'setting' => [
        'success' => [
            'store' => 'The user preferences were successfully saved.'
        ]
    ],
    'institution' => [
        'success' => [
            'store'  => 'The institution was successfully saved.',
            'update' => 'The institution was successfully updated.'
        ],
        'failure' => [
            'store'  => 'The institution name needs to be less than 50 characters.',
            'update' => 'You don\'t have permission to update that institution.'
        ]
    ],
    'class-room' => [
        'success' => [
            'store'   => 'The class room was successfully saved.',
            'update'  => 'The class room was successfully updated.'
        ],
        'failure' => [
            'store'   => 'The room name needs to be less than 30 characters or you don\'t have permission.',
            'update'  => 'The room name needs to be less than 30 characters or you don\'t have permission.'
        ]
    ]
];