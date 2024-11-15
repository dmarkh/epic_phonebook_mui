<?php

function get_roles() {
	return [
        'GUEST' => [
			'groups-view' => 1,
            'access-phonebook' => 1,
            'authorlists-view' => 1,
            'institutions-view' => 1,
            'representatives-view' => 1,
            'members-view' => 1,
            'descriptors-view' => 1,
            'fields-public-view' => 1
        ],
        'EDITOR' => [
            'access-phonebook' => 1,
            'authorlists-view' => 1,
            'representatives-view' => 1,
            'members-view' => 1,
            'members-create' => 1,
            'members-edit' => 1,
            'members-history' => 1,
            'institutions-view' => 1,
            'institutions-create' => 1,
            'institutions-edit' => 1,
            'institutions-history' => 1,
            'fields-public-view' => 1,
            'fields-private-view' => 1
        ],
        'ADMIN' => [
			'documents-view' => 1,
			'tasks-view' => 1,
			'events-view' => 1,
			'documents-create' => 1,
			'tasks-create' => 1,
			'events-create' => 1,
			'documents-edit' => 1,
			'tasks-edit' => 1,
			'events-edit' => 1,
			'documents-history' => 1,
			'tasks-history' => 1,
			'events-history' => 1,
            'access-phonebook' => 1,
            'authorlists-view' => 1,
            'representatives-view' => 1,
            'groups-view' => 1,
            'groups-create' => 1,
            'groups-edit' => 1,
            'members-view' => 1,
            'members-create' => 1,
            'members-edit' => 1,
            'members-history' => 1,
            'members-bulk-import' => 1,
            'members-bulk-update' => 1,
            'institutions-view' => 1,
            'institutions-create' => 1,
            'institutions-edit' => 1,
            'institutions-history' => 1,
            'institutions-bulk-import' => 1,
            'institutions-bulk-update' => 1,
            'descriptors-view' => 1,
            'descriptors-edit' => 1,
            'fields-public-view' => 1,
            'fields-private-view' => 1,
            'fields-admin-view' => 1
        ],
		'CLI' => [
            'access-phonebook' => 1,
            'representatives-view' => 1,
            'members-view' => 1,
            'members-create' => 1,
            'members-edit' => 1,
            'members-history' => 1,
            'institutions-view' => 1,
            'institutions-create' => 1,
            'institutions-edit' => 1,
            'institutions-history' => 1,
            'descriptors-view' => 1,
            'fields-public-view' => 1,
            'fields-private-view' => 1,
            'fields-admin-view' => 1
		]
    ];
}

function get_accounts() {
    return [
        'guest' => [
            'pass' => 'guest',
            'role' => 'GUEST',
            'token' => '***'
        ],
        'admin' => [
            'pass' => 'epic2030',
            'role' => 'ADMIN',
            'token' => '***'
        ],
        'cli' => [
            'pass' => 'cli2030',
            'role' => 'CLI',
            'token' => '***'
        ]
    ];
}

function get_token() {
	$headers = apache_request_headers();
	$token = false;
	if ( isset($headers['Authorization']) ) {
    	$headers = trim( $headers['Authorization'] );
		if ( preg_match('/Bearer\s(\S+)/', $headers, $matches) ) {
            $token = $matches[1];
        }
    }
	if ( $token === false ) {
		if ( !empty( $_GET['token'] ) ) {
			$token = $_GET['token'];
		} else if ( !empty( $_POST['token'] ) ) {
			$token = $_POST['token'];
		}
	}
	return $token;
}

function authenticate() {

	$token = get_token();
	$roles = get_roles();
	$auth = get_accounts();
	$login = empty($_POST['login']) ? 'N/A' : $_POST['login'];
	$pass  = empty($_POST['pass']) ? 'N/A' : $_POST['pass'];

	if ( !empty($token) ) {

		foreach( $auth as $k => $account ) {
			if ( $account['token'] === $token ) { return true; }
		}

	} else if ( !empty($login) && !empty($pass) ) {

		if ( !empty( $auth[ $login ] ) && $auth[ $login ]['pass'] === $pass ) {
        	$res = [
		    	'token' => $auth[ $login ]['token'],
            	'role' => $auth[ $login ]['role'],
         		'grants' => $roles[ $auth[ $login ]['role'] ]
        	];
			return $res;
		}
	}

	return false;
}

