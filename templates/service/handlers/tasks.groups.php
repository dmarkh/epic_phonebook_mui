<?php

function tasks_groups_handler($params) {
  $cnf =& ServiceConfig::Instance();
  $db =& ServiceDb::Instance('phonebook_api');
  $db_name = $cnf->Get('phonebook_api','database');

  if ( !isset($params['id']) ) { return json_encode(false); }

  $query = 'SELECT * FROM `'.$db_name.'`.`tasks_groups` WHERE `task_id` = '.intval($params['id']).';';
  $res = $db->Query($query);

  return json_encode( $res );
}