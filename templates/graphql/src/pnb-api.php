<?php

function get_groups() {
  $cnf =& ServiceConfig::Instance();
  $db =& ServiceDb::Instance('phonebook_api');
  $db_name = $cnf->Get('phonebook_api','database');

  $query = 'SELECT * FROM `'.$db_name.'`.`groups` WHERE `status` = "active"';
  $grp = $db->Query($query);

  $groups = array();
  foreach( $grp as $k => $v ) {
    $group = [ ...$v ];

    $query = 'SELECT COUNT(*) AS mcnt FROM `'.$db_name.'`.`groups_members` WHERE `group_id` = '.intval( $v['id'] );
    $mcnt = $db->Query($query);
    $group['member-count'] = $mcnt['mcnt'][0];

    $query = 'SELECT COUNT(*) as gcnt FROM `'.$db_name.'`.`groups` WHERE `parent` = '.intval( $v['id'] );
    $gcnt = $db->Query($query);
    $group['group-count'] = $gcnt['gcnt'][0];

    $groups[ $v['id'] ] = $group;
  }
  return $groups;
}

function get_groups_members_roles() {
  $cnf =& ServiceConfig::Instance();
  $db =& ServiceDb::Instance('phonebook_api');
  $db_name = $cnf->Get('phonebook_api','database');

  $members = [];
  $groups  = [];

  $query = 'SELECT group_id, member_id, role_id FROM `'.$db_name.'`.`groups_members`';
  $map = $db->Query($query);
  foreach( $map as $k => $v ) {
	if ( !isset($members[ $v['member_id'] ]) ) { $members[ $v['member_id'] ] = []; }
	$members[ $v['member_id'] ][] = [ 'group_id' => $v['group_id'], 'role_id' => $v['role_id'] ];
	if ( !isset( $groups[ $v['group_id'] ] ) ) { $groups[ $v['group_id'] ] = []; }
	$groups[ $v['group_id'] ][] = $v['member_id'];
  }

  return [ 'members' => $members, 'groups' => $groups ];
}

function get_groups_roles() {
  $cnf =& ServiceConfig::Instance();
  $db =& ServiceDb::Instance('phonebook_api');
  $db_name = $cnf->Get('phonebook_api','database');

  $query = 'SELECT * FROM `'.$db_name.'`.`groups_roles` WHERE 1';
  $res = $db->Query($query);

  $roles = [];

  // group_id, role_id => role_name
  foreach( $res as $k => $v ) {
	if ( !isset( $roles[ $v['group_id'] ] ) ) { $roles[ $v['group_id'] ] = []; }
	$roles[ $v['group_id'] ][ $v['id'] ] = $v['role'];
  }
  return $roles;
}

function get_events() {
	$cnf =& ServiceConfig::Instance();
	$db =& ServiceDb::Instance('phonebook_api');
	$db_name = $cnf->Get('phonebook_api','database');

	$query = 'SELECT * FROM `'.$db_name.'`.`events` WHERE `status` = "active"';
	$evt = $db->Query($query);

	$events = array();
	foreach($evt as $k => $v) {
		$events[$v['id']]['status'] = isset($v['status']) ? $v['status'] : '';
		$events[$v['id']]['status_change_date'] = isset($v['status_change_date']) ? $v['status_change_date'] : '';
		$events[$v['id']]['status_change_reason'] = isset($v['status_change_reason']) ? $v['status_change_reason'] : '';
		$events[$v['id']]['last_update'] = isset($v['last_update']) ? $v['last_update'] : '';
	}

	$query = 'SELECT * FROM `'.$db_name.'`.`events_fields`';
	$fields_res = $db->Query($query);
	$fields = array();
	$fields_fn = array();
	$fields_map = array();
	$evt_field_id = 0;
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

	$events_fields = array();

	foreach( array('string','int','date','text') as $k => $v) {
		$query = 'SELECT * FROM `'.$db_name.'`.`events_data_'.$v.'s`';
		$res = $db->Query($query);
		if ( empty($res) ) { continue; }
 		foreach($res as $k2 => $v2) {
			if ($v == 'int') { $v2['value'] = intval($v2['value']); }
			if ( !isset( $events_fields[ $v2['events_id'] ]['encoded'] ) ) { $events_fields[ $v2['events_id'] ]['encoded'] = []; }
			if ( !isset( $events_fields[ $v2['events_id'] ]['decoded'] ) ) { $events_fields[ $v2['events_id'] ]['decoded'] = []; }
			if ( is_array( $fields[ $v2['events_fields_id'] ]['options'] ) ) {
				$events_fields[ $v2['events_id'] ]['encoded'][ $v2['events_fields_id'] ] = $fields[ $v2['events_fields_id'] ]['options'][ $v2['value'] ];
				$events_fields[ $v2['events_id'] ]['decoded'][ $fields_map[ $v2['events_fields_id'] ] ] = $fields[ $v2['events_fields_id'] ]['options'][ $v2['value'] ];
			} else {
				$events_fields[ $v2['events_id'] ]['encoded'][ $v2['events_fields_id'] ] = $v2['value'];
				$events_fields[ $v2['events_id'] ]['decoded'][ $fields_map[ $v2['events_fields_id'] ] ] = $v2['value'];
			}
			if ( !isset( $events_fields[ $v2['events_id'] ]['decoded'][ 'id' ] ) ) {
				$events_fields[ $v2['events_id'] ]['decoded'][ 'id' ] = $v2['events_id'];
			}
		}
	}

	foreach( $events_fields as $k => $v ) { // $k = event_id
		foreach( $fields as $k2 => $v2 ) { // $k2 = field id, $v2 = field descriptor
			if ( isset( $v['encoded'][ $k2 ] ) ) { continue; }
			if ( is_array( $v2['options'] ) ) {
				$events_fields[$k]['encoded'][ $k2 ] = $v2['options'][ ( array_keys($v2['options']) )[0] ];
				$events_fields[$k]['decoded'][ $fields_map[$k2] ] = $v2['options'][ ( array_keys($v2['options']) )[0] ];
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
				$events_fields[$k]['encoded'][ $k2 ] = $defval;
				$events_fields[$k]['decoded'][ $fields_map[$k2] ] = $defval;
			}
		}
	}

	foreach( $events_fields as $k => $v ) {
		if ( !isset( $events[$k] ) ) { continue; }
		$events[$k]['fields_encoded'] = $v['encoded'];
		$events[$k]['fields_decoded'] = $v['decoded'];
	}

	return $events;
}

function get_documents() {
	$cnf =& ServiceConfig::Instance();
	$db =& ServiceDb::Instance('phonebook_api');
	$db_name = $cnf->Get('phonebook_api','database');

	$query = 'SELECT * FROM `'.$db_name.'`.`documents` WHERE `status` = "active"';
	$doc = $db->Query($query);

	$documents = array();
	foreach($doc as $k => $v) {
		$documents[$v['id']]['status'] = isset($v['status']) ? $v['status'] : '';
		$documents[$v['id']]['status_change_date'] = isset($v['status_change_date']) ? $v['status_change_date'] : '';
		$documents[$v['id']]['status_change_reason'] = isset($v['status_change_reason']) ? $v['status_change_reason'] : '';
		$documents[$v['id']]['last_update'] = isset($v['last_update']) ? $v['last_update'] : '';
	}

	$query = 'SELECT * FROM `'.$db_name.'`.`documents_fields`';
	$fields_res = $db->Query($query);
	$fields = array();
	$fields_fn = array();
	$fields_map = array();
	$doc_field_id = 0;
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

	$documents_fields = array();

	foreach( array('string','int','date','text') as $k => $v) {
		$query = 'SELECT * FROM `'.$db_name.'`.`documents_data_'.$v.'s`';
		$res = $db->Query($query);
		if ( empty($res) ) { continue; }
 		foreach($res as $k2 => $v2) {
			if ($v == 'int') { $v2['value'] = intval($v2['value']); }
			if ( !isset( $documents_fields[ $v2['documents_id'] ]['encoded'] ) ) { $documents_fields[ $v2['documents_id'] ]['encoded'] = []; }
			if ( !isset( $documents_fields[ $v2['documents_id'] ]['decoded'] ) ) { $documents_fields[ $v2['documents_id'] ]['decoded'] = []; }
			if ( is_array( $fields[ $v2['documents_fields_id'] ]['options'] ) ) {
				$documents_fields[ $v2['documents_id'] ]['encoded'][ $v2['documents_fields_id'] ] = $fields[ $v2['documents_fields_id'] ]['options'][ $v2['value'] ];
				$documents_fields[ $v2['documents_id'] ]['decoded'][ $fields_map[ $v2['documents_fields_id'] ] ] = $fields[ $v2['documents_fields_id'] ]['options'][ $v2['value'] ];
			} else {
				$documents_fields[ $v2['documents_id'] ]['encoded'][ $v2['documents_fields_id'] ] = $v2['value'];
				$documents_fields[ $v2['documents_id'] ]['decoded'][ $fields_map[ $v2['documents_fields_id'] ] ] = $v2['value'];
			}
			if ( !isset( $documents_fields[ $v2['documents_id'] ]['decoded'][ 'id' ] ) ) {
				$documents_fields[ $v2['documents_id'] ]['decoded'][ 'id' ] = $v2['documents_id'];
			}
		}
	}

	foreach( $documents_fields as $k => $v ) { // $k = document_id
		foreach( $fields as $k2 => $v2 ) { // $k2 = field id, $v2 = field descriptor
			if ( isset( $v['encoded'][ $k2 ] ) ) { continue; }
			if ( is_array( $v2['options'] ) ) {
				$documents_fields[$k]['encoded'][ $k2 ] = $v2['options'][ ( array_keys($v2['options']) )[0] ];
				$documents_fields[$k]['decoded'][ $fields_map[$k2] ] = $v2['options'][ ( array_keys($v2['options']) )[0] ];
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
				$documents_fields[$k]['encoded'][ $k2 ] = $defval;
				$documents_fields[$k]['decoded'][ $fields_map[$k2] ] = $defval;
			}
		}
	}

	foreach( $documents_fields as $k => $v ) {
		if ( !isset( $documents[$k] ) ) { continue; }
		$documents[$k]['fields_encoded'] = $v['encoded'];
		$documents[$k]['fields_decoded'] = $v['decoded'];
	}

	return $documents;
}

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

function get_events_fields() {
    $cnf =& ServiceConfig::Instance();
    $db =& ServiceDb::Instance('phonebook_api');
    $db_name = $cnf->Get('phonebook_api','database');
    $query = 'SELECT * FROM `'.$db_name.'`.`events_fields` WHERE 1  ORDER BY `weight` ASC';

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

function get_documents_fields() {
    $cnf =& ServiceConfig::Instance();
    $db =& ServiceDb::Instance('phonebook_api');
    $db_name = $cnf->Get('phonebook_api','database');
    $query = 'SELECT * FROM `'.$db_name.'`.`documents_fields` WHERE 1  ORDER BY `weight` ASC';

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

