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