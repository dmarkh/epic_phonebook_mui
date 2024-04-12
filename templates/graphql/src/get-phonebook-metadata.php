<?php

function get_phonebook_metadata() {
	$metadata = [
		'member_fields'			=> get_members_fields(),
		'institution_fields'	=> get_institutions_fields()
	];
	return $metadata;
}