<?php
return [
    
    'SITE_LOGO' => '/assets/images/banner.png',
    'DEFAULT_DATA' => [
            'ENC_SECRET' => 'enc_customer_id'
    ],
    'TEAMS_FETCHABLE_COLUMNS' => ['id', 'name', 'logo', 'logo_url'],
    'PLAYERS_FETCHABLE_COLUMNS' => ['id', 'first_name', 'last_name', 'photo', 'photo_url'],
    'TEAM_LOGO_UPLOAD_PATH' => public_path() . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR .'images'. DIRECTORY_SEPARATOR . 'team',
    'TEAM_LOGO_PATH' => '/assets/images/team/',
    'PLAYER_PHOTO_UPLOAD_PATH' => public_path() . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR  .'images'. DIRECTORY_SEPARATOR . 'player',
    'PLAYER_PHOTO_PATH' => '/assets/images/player/',
];


