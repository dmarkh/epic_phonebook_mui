<?php

# 
# Export current member list in MS Excel format. 
#
# fields, sort - required options
#
# /members/excel/fields:[1,2,3..N]/sort:[F1,F2]
#
# Institutions: active, members: all
# sort: field ids to sort: F1 first, F2 second
#

include_once('./include/xlsxwriter.class.php');

function cmp($a, $b)
{
	$r = strcasecmp($a[0], $b[0]);
	if ($r == 0) {
		$r = strcasecmp($a[2], $b[2]);
	}
    return $r;
}

function members_excelx_handler($params) {

  $cnf =& ServiceConfig::Instance();
  $db =& ServiceDb::Instance('phonebook_api');
  $db_name = $cnf->Get('phonebook_api','database');

  if (empty($params['fields']) || empty($params['sort'])) { return json_encode(false); }
  $wherestatus = '';
  $params['mflag'] = intval($params['mflag']);
  if ($params['mflag'] == 1) {
	$wherestatus = ' WHERE `status` = "active"';
  } else if ( $params['mflag'] == 2) {
	$wherestatus = ' WHERE `status` = "inactive"';
  }

  $req_fields = explode(',', $params['fields']);
  $sort = explode(',', $params['sort']);

  $fields = get_members_fields();

  $query = 'SELECT * FROM `'.$db_name.'`.`institutions` WHERE `status` = "active"';
  $inst = $db->Query($query);

  $query = 'SELECT * FROM `'.$db_name.'`.`members`'.$wherestatus;
  $mem = $db->Query($query);

  $inst_fields = array();
  foreach(array('string','int','date','text') as $k => $v) {
    $query = 'SELECT * FROM `'.$db_name.'`.`institutions_data_'.$v.'s`';
    $res = $db->Query($query);
    if (empty($res)) continue;
    foreach($res as $k2 => $v2) {
        if ($v == 'int') { $v2['value'] = intval($v2['value']); }
        $inst_fields[$v2['institutions_id']][$v2['institutions_fields_id']] = $v2['value'];
    }
  }

  $mem_fields = array();
  foreach(array('string','int','date','text') as $k => $v) {
    $query = 'SELECT * FROM `'.$db_name.'`.`members_data_'.$v.'s`';
    $res = $db->Query($query);
    if (empty($res)) continue;
    foreach($res as $k2 => $v2) {
        if ($v == 'int') { $v2['value'] = intval($v2['value']); }
        $mem_fields[$v2['members_id']][$v2['members_fields_id']] = $v2['value'];
    }
  }

  $out = array();
  $header = array();
  foreach($req_fields as $k => $v) {
	$header[] = strtoupper($fields[$v]['name_desc']);
  }
  $header = array($header);

  foreach($mem as $k => $m) {
	$data = array();
	foreach($req_fields as $k2 => $fld) {
		$val = '';
		if (isset($mem_fields[$m['id']][$fld])) {
			$val = $mem_fields[$m['id']][$fld];
		}
		if ($fields[$fld]['name_fixed'] == 'date_joined' && empty($val)) { 
			$val = $m['join_date'];
		} else if ($fields[$fld]['name_fixed'] == 'date_leave') { 

		} else if ($fields[$fld]['name_fixed'] == 'institution_id') {
			$val = $inst_fields[$val][1];
		}
		$data[$fld] = $val;
	}
	$out[] = $data;
  }

  if (!empty($sort[0]) && in_array($sort[0], $req_fields)) {
  	usort($out, function($a, $b) use ($sort) {
    		$r = strcasecmp($a[$sort[0]], $b[$sort[0]]);
		    if ($r == 0 && !empty($sort[1])) {
    		    $r = strcasecmp($a[$sort[1]], $b[$sort[1]]);
	    	}
	    	return $r;
		}
	);
  }

  $out = array_merge($header, $out);

  $writer = new XLSXWriter();
  $writer->writeSheet($out);

  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="collaboration-'.date('Y-m-d').'-'.time().'.xlsx"');
  header('Cache-Control: max-age=0');

  echo $writer->writeToString();

}
