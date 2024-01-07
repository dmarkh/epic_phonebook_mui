<?php

function get_roles() {
	return [
        'GUEST' => [
            'access-phonebook' => 1,
            'authorlists-view' => 1,
            'institutions-view' => 1,
            'members-view' => 1,
            'descriptors-view' => 1,
            'fields-public-view' => 1
        ],
        'ADMIN' => [
            'access-phonebook' => 1,
            'authorlists-view' => 1,
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
            'pass' => '',
            'role' => 'GUEST',
            'token' => ''
        ],
        'admin' => [
            'pass' => '',
            'role' => 'ADMIN',
            'token' => ''
        ],
        'cli' => [
            'pass' => '',
            'role' => 'CLI',
            'token' => ''
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
	$login = $_POST['login'];
	$pass = $_POST['pass'];

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

