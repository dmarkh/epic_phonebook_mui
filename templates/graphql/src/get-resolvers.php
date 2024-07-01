<?php

function get_resolvers() {
    $resolvers = [
        'Query' => [
            'echo' => function( $root, $args, $context, $info ) {
                return $args['message'];
            },
			'events' => function( $root, $args, $context, $info ) {
				return get_filters( $context['events'], ( $context['variables'] && $context['variables']['filters'] ) ? $context['variables']['filters'] : [] );
			},
			'documents' => function( $root, $args, $context, $info ) {
				return get_filters( $context['documents'], ( $context['variables'] && $context['variables']['filters'] ) ? $context['variables']['filters'] : [] );
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
			},
			'groups' => function( $root, $args, $context, $info ) {
				$res = [];
				foreach( $context['groups'] as $k => $v ) {
					$group = $v;
					$group['roles'] = [];
					foreach( $context['groups_roles'][ $v['id'] ] as $k2 => $v2 ) {
						$group['roles'][] = $v2;
					}
					$res[] = $group;
				}
				return $res;
			},
			'memberGroups' => function( $root, $args, $context, $info ) {
				$member = false;
				foreach($context['members'] as $k => $v ) {
					if ( isset($v['orcid_id']) && $v['orcid_id'] == $args['orcid'] ) {
						$member = $v;
						break;
					}
				}
				if ( !$member ) { return [ [ 'id' => 0, 'name' => 'no-member-found', 'category' => 'n/a', 'role' => '', 'roles' => [] ] ]; }
				$groups = $context['groups_members_roles']['members'][ $member['id'] ];
				$res = [];
				foreach( $groups as $k => $v ) {
					$res[] = [
						'id' => $v['group_id'],
						'name' => $context['groups'][ $v['group_id'] ]['name'],
						'category' => $context['groups'][ $v['group_id'] ]['category'],
						'role' => $context['groups_roles'][ $v['group_id'] ][ $v['role_id'] ],
						'roles' => []
					];
				}

				return $res;
			},
        ],
		'Institution' => [
			'members' => function( $root, $args, $context, $info ) {
				return array_filter( $context['members'], fn($m) => $m['institution_id'] == $root['id'] );
			}
		],
        'Member' => [
            'institution' => function( $root, $args, $context, $info ) {
                return $context['institutions'][ $root['institution_id'] ];
            },
			'groups' => function( $root, $args, $context, $info ) {
				$groups = $context['groups_members_roles']['members'][ $root['id'] ];
				$res = [];
				foreach( $groups as $k => $v ) {
					$res[] = [
						'id' => $v['group_id'],
						'name' => $context['groups'][ $v['group_id'] ]['name'],
						'category' => $context['groups'][ $v['group_id'] ]['category'],
						'role' => $context['groups_roles'][ $v['group_id'] ][ $v['role_id'] ],
						'roles' => []
					];
				}
				return $res;
			}
        ]
    ];
	return $resolvers;
}