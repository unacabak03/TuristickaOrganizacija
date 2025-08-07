<?php

return [
    'users' => [
        'itemTitle' => 'User',
        'collectionTitle' => 'Users',
        'inputs' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Name',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Email',
            ],
            'phone_number' => [
                'label' => 'Phone number',
                'placeholder' => 'Phone number',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Password',
            ],
            'role' => [
                'label' => 'Role',
                'placeholder' => 'Role',
            ],
        ],
    ],
    'reservations' => [
        'itemTitle' => 'Reservation',
        'collectionTitle' => 'Reservations',
        'inputs' => [
            'tour_id' => [
                'label' => 'Tour id',
                'placeholder' => 'Tour id',
            ],
            'status' => [
                'label' => 'Status',
                'placeholder' => 'Status',
            ],
            'number_of_people' => [
                'label' => 'Number of people',
                'placeholder' => 'Number of people',
            ],
            'user_id' => [
                'label' => 'User id',
                'placeholder' => 'User id',
            ],
        ],
    ],
    'reviews' => [
        'itemTitle' => 'Review',
        'collectionTitle' => 'Reviews',
        'inputs' => [
            'tour_id' => [
                'label' => 'Tour id',
                'placeholder' => 'Tour id',
            ],
            'rating' => [
                'label' => 'Rating',
                'placeholder' => 'Rating',
            ],
            'comment' => [
                'label' => 'Comment',
                'placeholder' => 'Comment',
            ],
            'user_id' => [
                'label' => 'User id',
                'placeholder' => 'User id',
            ],
        ],
    ],
    'tours' => [
        'itemTitle' => 'Tour',
        'collectionTitle' => 'Tours',
        'inputs' => [
            'title' => [
                'label' => 'Title',
                'placeholder' => 'Title',
            ],
            'description' => [
                'label' => 'Description',
                'placeholder' => 'Description',
            ],
            'location' => [
                'label' => 'Location',
                'placeholder' => 'Location',
            ],
            'price' => [
                'label' => 'Price',
                'placeholder' => 'Price',
            ],
            'start_date' => [
                'label' => 'Start date',
                'placeholder' => 'Start date',
            ],
            'end_date' => [
                'label' => 'End date',
                'placeholder' => 'End date',
            ],
            'max_participants' => [
                'label' => 'Max participants',
                'placeholder' => 'Max participants',
            ],
        ],
    ],
    'categoryTour' => [
        'itemTitle' => 'Category Tour',
        'collectionTitle' => 'Category Tour',
        'inputs' => [
            'category_id' => [
                'label' => 'Category id',
                'placeholder' => 'Category id',
            ],
            'tour_id' => [
                'label' => 'Tour id',
                'placeholder' => 'Tour id',
            ],
        ],
    ],
    'categories' => [
        'itemTitle' => 'Category',
        'collectionTitle' => 'Categories',
        'inputs' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Name',
            ],
            'description' => [
                'label' => 'Description',
                'placeholder' => 'Description',
            ],
        ],
    ],
];
