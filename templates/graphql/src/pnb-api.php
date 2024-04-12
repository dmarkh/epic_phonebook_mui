<?php

function get_institutions() {
	$cnf =& ServiceConfig::Instance();
	$db =& ServiceDb::Instance('phonebook_api');
	$db_name = $cnf->Get('phonebook_api','database');

	$query = 'SELECT * FROM `'.$db_name.'`.`institutions` WHERE `status` = "active"';
	$inst = $db->Query($query);

	$institutions = array();
	foreach($inst as $k => $v) {
		$institutions[$v['id']]['status'] = isset($v['status']) ? $v['status'] : '';
		$institutions[$v['id']]['status_change_date'] = isset($v['status_change_date']) ? $v['status_change_date'] : '';
		$institutions[$v['id']]['status_change_reason'] = isset($v['status_change_reason']) ? $v['status_change_reason'] : '';
		$institutions[$v['id']]['last_update'] = isset($v['last_update']) ? $v['last_update'] : '';
		$institutions[$v['id']]['join_date'] = isset($v['join_date']) ? $v['join_date'] : '';
	}

	$query = 'SELECT * FROM `'.$db_name.'`.`institutions_fields`';
	$fields_res = $db->Query($query);
	$fields = array();
	$fields_fn = array();
	$fields_map = array();
	$inst_field_id = 0;
	foreach($fields_res as $k => $v) {
		$fields_map[ $v['id'] ] = $v['name_fixed'];

		if ( !empty( $v['options'] ) ) {
			$tmp = explode(',', $v['options']);
			$tmp3 = [];
			foreach ($tmp as $k2 => $v2 ) {
				$tmp2 = explode(':', $v2);
				$tmp3[ $tmp2[0] ] = trim( $tmp2[1] );
			}
			if ( !empty($tmp3) ) {
				$v['options'] = $tmp3;
			}
		}

		$fields[ $v['id'] ] = $v;
		$fields_fn[ $v['name_fixed'] ] = $v;
	}

	$institutions_fields = array();

	foreach( array('string','int','date','text') as $k => $v) {
		$query = 'SELECT * FROM `'.$db_name.'`.`institutions_data_'.$v.'s`';
		$res = $db->Query($query);
		if ( empty($res) ) { continue; }
 		foreach($res as $k2 => $v2) {
			if ($v == 'int') { $v2['value'] = intval($v2['value']); }
			if ( !isset( $institutions_fields[ $v2['institutions_id'] ]['encoded'] ) ) { $institutions_fields[ $v2['institutions_id'] ]['encoded'] = []; }
			if ( !isset( $institutions_fields[ $v2['institutions_id'] ]['decoded'] ) ) { $institutions_fields[ $v2['institutions_id'] ]['decoded'] = []; }
			if ( is_array( $fields[ $v2['institutions_fields_id'] ]['options'] ) ) {
				$institutions_fields[ $v2['institutions_id'] ]['encoded'][ $v2['institutions_fields_id'] ] = $fields[ $v2['institutions_fields_id'] ]['options'][ $v2['value'] ];
				$institutions_fields[ $v2['institutions_id'] ]['decoded'][ $fields_map[ $v2['institutions_fields_id'] ] ] = $fields[ $v2['institutions_fields_id'] ]['options'][ $v2['value'] ];
			} else {
				$institutions_fields[ $v2['institutions_id'] ]['encoded'][ $v2['institutions_fields_id'] ] = $v2['value'];
				$institutions_fields[ $v2['institutions_id'] ]['decoded'][ $fields_map[ $v2['institutions_fields_id'] ] ] = $v2['value'];
			}
			if ( !isset( $institutions_fields[ $v2['institutions_id'] ]['decoded'][ 'id' ] ) ) {
				$institutions_fields[ $v2['institutions_id'] ]['decoded'][ 'id' ] = $v2['institutions_id'];
			}
		}
	}

	foreach( $institutions_fields as $k => $v ) { // $k = institution_id
		foreach( $fields as $k2 => $v2 ) { // $k2 = field id, $v2 = field descriptor
			if ( isset( $v['encoded'][ $k2 ] ) ) { continue; }
			if ( is_array( $v2['options'] ) ) {
				$institutions_fields[$k]['encoded'][ $k2 ] = $v2['options'][ ( array_keys($v2['options']) )[0] ];
				$institutions_fields[$k]['decoded'][ $fields_map[$k2] ] = $v2['options'][ ( array_keys($v2['options']) )[0] ];
			} else {
				$defval = false;
				switch( $v2['type'] ) {
					case 'int':
						$defval = 0;
						break;
					case 'string':
					case 'text':
						$defval = '';
						break;
					case 'date':
						$defval = '0000-00-00';
						break;
					default:
						$defval = '';
						break;
				}
				$institutions_fields[$k]['encoded'][ $k2 ] = $defval;
				$institutions_fields[$k]['decoded'][ $fields_map[$k2] ] = $defval;
			}
		}
	}

	foreach( $institutions_fields as $k => $v ) {
		if ( !isset( $institutions[$k] ) ) { continue; }
		$institutions[$k]['fields_encoded'] = $v['encoded'];
		$institutions[$k]['fields_decoded'] = $v['decoded'];
	}

	return $institutions;
}

function get_members() {
	$cnf =& ServiceConfig::Instance();
	$db =& ServiceDb::Instance('phonebook_api');
	$db_name = $cnf->Get('phonebook_api','database');

	$query = 'SELECT * FROM `'.$db_name.'`.`members` WHERE `status` = "active"';
	$mem = $db->Query($query);

	$members = array();
	foreach($mem as $k => $v) {
		$members[$v['id']]['status'] = $v['status'];
		$members[$v['id']]['status_change_date'] = isset($v['status_change_date']) ? $v['status_change_date'] : '';
		$members[$v['id']]['status_change_reason'] = isset($v['status_change_reason']) ? $v['status_change_reason'] : '';
		$members[$v['id']]['last_update'] = isset($v['last_update']) ? $v['last_update'] : '';
		$members[$v['id']]['join_date'] = isset($v['join_date']) ? $v['join_date'] : '';
	}

	$query = 'SELECT * FROM `'.$db_name.'`.`members_fields`';
	$fields_res = $db->Query($query);
	$fields = array();
	$fields_fn = array();
	$fields_map = array();
	$inst_field_id = 0;
	foreach($fields_res as $k => $v) {
		$fields_map[ $v['id'] ] = $v['name_fixed'];

		if ( !empty( $v['options'] ) ) {
			$tmp = explode(',', $v['options']);
			$tmp3 = [];
			foreach ($tmp as $k2 => $v2 ) {
				$tmp2 = explode(':', $v2);
				$tmp3[ $tmp2[0] ] = trim( $tmp2[1] );
			}
			if ( !empty($tmp3) ) {
				$v['options'] = $tmp3;
			}
		}

		$fields[ $v['id'] ] = $v;
		$fields_fn[ $v['name_fixed'] ] = $v;
		if ($v['name_fixed'] == 'institution_id') { $inst_field_id = intval($v['id']); }
	}

	$members_fields = array();

	foreach( array('string','int','date','text') as $k => $v) {
		$query = 'SELECT * FROM `'.$db_name.'`.`members_data_'.$v.'s`';
		$res = $db->Query($query);
		if ( empty($res) ) { continue; }

 		foreach($res as $k2 => $v2) {
			if ($v == 'int') { $v2['value'] = intval($v2['value']); }
			if ( !isset( $members_fields[ $v2['members_id'] ]['encoded'] ) ) { $members_fields[ $v2['members_id'] ]['encoded'] = []; }
			if ( !isset( $members_fields[ $v2['members_id'] ]['decoded'] ) ) { $members_fields[ $v2['members_id'] ]['decoded'] = []; }

			if ( is_array( $fields[ $v2['members_fields_id'] ]['options'] ) ) {
				$members_fields[ $v2['members_id'] ]['encoded'][ $v2['members_fields_id'] ] = $fields[ $v2['members_fields_id'] ]['options'][ $v2['value'] ];
				$members_fields[ $v2['members_id'] ]['decoded'][ $fields_map[ $v2['members_fields_id'] ] ] = $fields[ $v2['members_fields_id'] ]['options'][ $v2['value'] ];
			} else {
				$members_fields[ $v2['members_id'] ]['encoded'][ $v2['members_fields_id'] ] = $v2['value'];
				$members_fields[ $v2['members_id'] ]['decoded'][ $fields_map[ $v2['members_fields_id'] ] ] = $v2['value'];
			}
			if ( !isset( $members_fields[ $v2['members_id'] ]['decoded'][ 'id' ] ) ) {
				$members_fields[ $v2['members_id'] ]['decoded'][ 'id' ] = $v2['members_id'];
			}
		}
	}

    foreach( $members_fields as $k => $v ) {
        foreach( $fields as $k2 => $v2 ) {
            if ( isset( $v['encoded'][ $k2 ] ) ) { continue; }
            if ( is_array( $v2['options'] ) ) {
                $members_fields[$k]['encoded'][ $k2 ] = $v2['options'][ ( array_keys($v2['options']) )[0] ];
                $members_fields[$k]['decoded'][ $fields_map[$k2] ] = $v2['options'][ ( array_keys($v2['options']) )[0] ];
            } else {
                $defval = false;
                switch( $v2['type'] ) {
                    case 'int':
                        $defval = 0;
                        break;
                    case 'string':
                    case 'text':
                        $defval = '';
                        break;
                    case 'date':
                        $defval = '0000-00-00';
                        break;
                    default:
                        $defval = '';
                        break;
                }
                $members_fields[$k]['encoded'][ $k2 ] = $defval;
                $members_fields[$k]['decoded'][ $fields_map[$k2] ] = $defval;
            }
        }
    }

	foreach( $members_fields as $k => $v ) {
		if ( !isset( $members[$k] ) ) { continue; }
		$members[$k]['fields_encoded'] = $v['encoded'];
		$members[$k]['fields_decoded'] = $v['decoded'];
	}

	return $members;
}

function get_institutions_fields() {
    $cnf =& ServiceConfig::Instance();
    $db =& ServiceDb::Instance('phonebook_api');
    $db_name = $cnf->Get('phonebook_api','database');
    $query = 'SELECT t1.* FROM `'.$db_name.'`.`institutions_fields` t1, `'.$db_name.'`.`institutions_fields_groups` t2 WHERE t1.group = t2.id  ORDER BY t2.weight ASC, t1.`weight` ASC';

    $res = $db->Query($query);
    $fields = array();

    foreach($res as $k => $v) {

		if ( !empty( $v['options'] ) ) {
			$tmp = explode(',', $v['options']);
			$tmp3 = [];
			foreach ($tmp as $k2 => $v2 ) {
				$tmp2 = explode(':', $v2);
				$tmp3[ $tmp2[0] ] = trim( $tmp2[1] );
			}
			if ( !empty($tmp3) ) {
				$v['options'] = $tmp3;
			}
		}

        $fields[$v['id']] = $v;
    }

    return $fields;
}

function get_members_fields() {
    $cnf =& ServiceConfig::Instance();
    $db =& ServiceDb::Instance('phonebook_api');
    $db_name = $cnf->Get('phonebook_api','database');
    $query = 'SELECT t1.* FROM `'.$db_name.'`.`members_fields` t1, `'.$db_name.'`.`members_fields_groups` t2 WHERE t1.group = t2.id ORDER BY t2.weight ASC, t1.`weight` ASC';
    $res = $db->Query($query);
    $fields = array();
    foreach($res as $k => $v) {

		if ( !empty( $v['options'] ) ) {
			$tmp = explode(',', $v['options']);
			$tmp3 = [];
			foreach ($tmp as $k2 => $v2 ) {
				$tmp2 = explode(':', $v2);
				$tmp3[ $tmp2[0] ] = trim( $tmp2[1] );
			}
			if ( !empty($tmp3) ) {
				$v['options'] = $tmp3;
			}
		}

        $fields[$v['id']] = $v;
    }
    return $fields;
}

function get_institutions_fieldgroups() {
    $cnf =& ServiceConfig::Instance();
    $db =& ServiceDb::Instance('phonebook_api');
    $db_name = $cnf->Get('phonebook_api','database');
    $query = 'SELECT * FROM `'.$db_name.'`.`institutions_fields_groups` ORDER BY `weight` ASC';
    $res = $db->Query($query);
    $groups = array();
    foreach($res as $k => $v) {
        $groups[$v['id']] = $v;
    }
    return $groups;
}

function get_members_fieldgroups() {
    $cnf =& ServiceConfig::Instance();
    $db =& ServiceDb::Instance('phonebook_api');
    $db_name = $cnf->Get('phonebook_api','database');
    $query = 'SELECT * FROM `'.$db_name.'`.`members_fields_groups` ORDER BY `weight` ASC';
    $res = $db->Query($query);
    $groups = array();
    foreach($res as $k => $v) {
        $groups[$v['id']] = $v;
    }
    return $groups;
}

function convert_members_new_old($new_fixed_name) {
    $map = array(
    'name_first'        => 'FirstName',
    'name_initials'     => 'Initials',
    'name_last'         => 'LastName',
    'name_latex'        => 'LatexLastName',
    'name_unicode'      => 'UnicodeName',
    'inspire_id'        => 'InspireID',
    'address_line_1'    => 'Address1',
    'address_line_2'    => 'Address2',
    'address_line_3'    => 'Address3',
    'city'              => 'City',
    'state'             => 'State',
    'country'           => 'Country',
    'postcode'          => 'PostCode',
    'institution_id'    => 'InstitutionId',
    'email'             => 'EmailAddress',
    'email_alt'         => 'AlternateEmail',
    'phone_home'        => 'Phone',
    'phone_cell'        => 'CellPhone',
    'fax'               => 'Fax',
    'url'               => 'Url',
    'bnl_office'        => 'BnlOffice',
    'bnl_phone_office'  => 'BnlPhone',
    'date_joined'       => 'JoinDate',
    'date_leave'        => 'LeaveDate',
    'is_author'         => 'isAuthor',
    'is_junior'         => 'isJunior',
    'is_shifter'        => 'isShifter',
    'is_expert'         => 'isExpert',
    'is_emeritus'       => 'isEmeritus',
    'expertise'         => 'Expertise',
    'expert_credit'     => 'ExpertCredit'
    );
    if (isset($map[$new_fixed_name])) { return $map[$new_fixed_name]; }
    return '';
}

function convert_institutions_new_old($new_fixed_name) {
    $map = array(
    'name_full'                 => 'InstitutionName',
    'name_short'                => 'Organization',
    'name_group'                => 'GroupName',
    'name_latex'                => 'LatexAffiliation',
    'name_sortby'               => 'NameToSortBy',
    'website_group'             => 'GroupUrl',
    'website_institution'       => 'InstitutionUrl',
    'council_representative'    => 'CouncilRepId',
    'address_line_1'            => 'Address1',
    'address_line_2'            => 'Address2',
    'city'                      => 'City',
    'state'                     => 'State',
    'country'                   => 'Country',
    'postcode'                  => 'PostCode',
    'date_joined'               => 'JoinDate',
    'date_leave'                => 'LeaveDate',
    'associated_id'             => 'AssociatedId',
    'office'                    => 'BnlOffice'
    );
    if (isset($map[$new_fixed_name])) { return $map[$new_fixed_name]; }
    return '';
}

function get_client_ip() {
  if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
    return $_SERVER['HTTP_CLIENT_IP'];
  } elseif ( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
  } elseif ( !empty( $_SERVER['REMOTE_ADDR'] ) ) {
	  return $_SERVER['REMOTE_ADDR'];
	}
	return '';
}

function get_client_user() {
  if ( !empty($headers['OIDC_CLAIM_preferred_username']) ) {
    return $headers['OIDC_CLAIM_preferred_username'];
  } else if ( !empty($_SERVER['REMOTE_USER']) ) {
    return $_SERVER['REMOTE_USER'];
  }
  return '';
}

