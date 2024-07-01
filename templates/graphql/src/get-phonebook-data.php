<?php

function get_phonebook_data() {
	$data = [
		'members' 		=> [],
		'institutions'	=> [],
		'documents'		=> [],
		'events'		=> []
	];

	$m = get_members();
	$i = get_institutions();
	$d = get_documents();
	$e = get_events();

	$data['groups'] = get_groups();
	$data['groups_members_roles'] = get_groups_members_roles();
	$data['groups_roles'] = get_groups_roles();

	foreach( $m as $k => $v ) {
		// check for institution id - it must present
		if ( !isset( $v['fields_decoded']['institution_id'] ) || intval( $v['fields_decoded']['institution_id'] ) === 0 ) { continue; }
		// check for institution - it must be active
		if ( !isset( $i[ $v['fields_decoded']['institution_id'] ] ) ) { continue; }
		$data['members'][$k] = $v['fields_decoded'];
	}
	foreach( $i as $k => $v ) {
		$data['institutions'][$k] = $v['fields_decoded'];
	}
	foreach( $d as $k => $v ) {
		$data['documents'][$k] = $v['fields_decoded'];
	}
	foreach( $e as $k => $v ) {
		$data['events'][$k] = $v['fields_decoded'];
	}
	return $data;
}
