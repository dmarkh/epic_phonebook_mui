<?php

function get_schema( $metadata ) {
	// $metadata = [ 'member_fields' => [], 'institution_fields' => [] ]
$schema = 
'schema {
	query: Query
}

type Query {
	echo(message: String!): String!
	members: [Member]
	institutions: [Institution]
}

type Institution {
	id: ID!
	members: [Member!]'."\n";
	foreach( $metadata['institution_fields'] as $k => $v ) {
		switch( $v['type'] ) {
			case 'int':
				$schema .= "\t".$v['name_fixed'].': Int'."\n";
				break;
			case 'string':
			case 'text':
				$schema .= "\t".$v['name_fixed'].': String'."\n";
				break;
			case 'date':
				$schema .= "\t".$v['name_fixed'].': String'."\n";
				break;
			default:
				break;
		}
	}
$schema .= '}

type Member {
	id: ID!
	institution: Institution!'."\n";

	foreach( $metadata['member_fields'] as $k => $v ) {
		switch( $v['type'] ) {
			case 'int':
				$schema .= "\t".$v['name_fixed'].': Int'."\n";
				break;
			case 'string':
			case 'text':
				$schema .= "\t".$v['name_fixed'].': String'."\n";
				break;
			case 'date':
				$schema .= "\t".$v['name_fixed'].': String'."\n";
				break;
			default:
				break;
		}
	}

$schema .= '}'."\n";

	return $schema;
}