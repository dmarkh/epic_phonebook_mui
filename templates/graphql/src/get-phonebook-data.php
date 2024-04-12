<?php

function get_phonebook_data() {
	$data = [
		'members' => [],
		'institutions' => []
	];
	$m = get_members();
	$i = get_institutions();
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
	return $data;
}
