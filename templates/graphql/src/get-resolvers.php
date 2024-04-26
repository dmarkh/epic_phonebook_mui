<?php

function get_resolvers() {
    $resolvers = [
        'Query' => [
            'echo' => function( $root, $args, $context, $info ) {
                return $args['message'];
            },
			'members' => function( $root, $args, $context, $info ) {
				return get_filters( $context['members'], ( $context['variables'] && $context['variables']['filters'] ) ? $context['variables']['filters'] : [] );
			},
			'institutions' => function( $root, $args, $context, $info ) {
				return get_filters( $context['institutions'], ( $context['variables'] && $context['variables']['filters'] ) ? $context['variables']['filters'] : [] );
			},
			'member' => function( $root, $args, $context, $info ) {
				foreach($context['members'] as $k => $v ) {
					if ( isset($v['orcid_id']) && $v['orcid_id'] == $args['orcid'] ) {
						return $v;
					}
				}
				return NULL;
			},
			'institution' => function( $root, $args, $context, $info ) {
				foreach($context['institutions'] as $k => $v ) {
					if ( isset($v['ror_id']) && $v['ror_id'] == $args['rorid'] ) {
						return $v;
					}
				}
				return NULL;
			}
        ],
		'Institution' => [
			'members' => function( $root, $args, $context, $info ) {
				return array_filter( $context['members'], fn($m) => $m['institution_id'] == $root['id'] );
			}
		],
        'Member' => [
            'institution' => function( $root, $args, $context, $info ) {
                return $context['institutions'][ $root['institution_id'] ];
            }
        ]
    ];
	return $resolvers;
}