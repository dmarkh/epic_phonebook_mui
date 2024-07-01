<script>

import DataTable, { Head, Body, Row, Cell, Label, SortValue, Pagination } from '@smui/data-table';
import IconButton from '@smui/icon-button';
import Select, { Option } from '@smui/select';
import LinearProgress from '@smui/linear-progress';
import Paper from '@smui/paper';

import { getGroup, getGroups } from '../utils/pnb-api.js';

import { getMembers, getMemberFields, getGroupRoles } from '../utils/pnb-api.js';
import { convertMembers, addInstitutionsToConvertedMembers } from '../utils/pnb-convert.js';
import { sortConvertedMembers } from '../utils/pnb-sort.js';

import { group_id, auth } from '../store.js';

let title = '';
let data = {};
let groups = false;
let members = false;
let roles = false;

let members_cache = {};
let groups_cache = {};

const findRole = ( id ) => {
    for ( const role of roles ) {
        if ( role.id == id ) {
            return role.role;
        }
    }
    return '';
}

const findParentGroup = ( id ) => {
	if ( groups_cache[id] ) { return groups_cache[id].name };
	for ( const group of groups ) {
		if ( group.id == id ) {
			groups_cache[id] = group;
			return group.name;
		}
	}
	return '';
}

const findGroup = ( id ) => {
	if ( groups_cache[id] ) { return groups_cache[id]; };
	for ( const group of groups ) {
		if ( group.id == id ) {
			groups_cache[id] = group;
			return group;
		}
	}
	return false;
}

const findMember = ( id ) => {
	if ( members_cache[id] ) { return members_cache[id] };
	for ( const member of members ) {
		if ( member.id == id ) {
			members_cache[id] = member;
			return member;
		}
	}
	return false;
}

const fetchGroup = async () => {
	data = await getGroup( $group_id );
	if ( data.parent || data.groups.length ) {
		// fetch all groups for display purposes
		groups = await getGroups();
	}
	if ( data.members.length ) {
		// fetch all members for display purposes
		let mem = await getMembers();
    	let items = await convertMembers( mem );
    	members = await addInstitutionsToConvertedMembers( items );
	    sortConvertedMembers( members );
	}
	roles = await getGroupRoles( $group_id );
	return data;
}

</script>

{#await fetchGroup()}

<LinearProgress indeterminate />

{:then data}

<div style="text-align: center;" class="mdc-typography--headline4">GROUP: {title}</div>
<Paper>

<DataTable table$aria-label="Group Data" style="width: 100%;">
    <Body>
	{#if findParentGroup( data.parent )}
      <Row data-entry-id="group-parent">
   	    <Cell style="width: 30%; font-weight: bold;">PARENT GROUP</Cell>
       	<Cell style="width: 70%;">{findParentGroup( data.parent )}</Cell>
   	  </Row>
	{/if}
      <Row data-entry-id="group-name">
   	    <Cell style="width: 30%; font-weight: bold;">NAME</Cell>
       	<Cell style="width: 70%;">{data.name} { data.category ? ( '( ' + data.category + ' )' ) : ''}</Cell>
   	  </Row>
      <Row data-entry-id="group-desc">
   	    <Cell style="width: 30%; font-weight: bold;">DESCRIPTION</Cell>
       	<Cell style="width: 70%;">{data.desc}</Cell>
   	  </Row>
      <Row data-entry-id="group-desc">
   	    <Cell style="width: 30%; font-weight: bold;">EMAIL</Cell>
       	<Cell style="width: 70%;">{data.email}</Cell>
   	  </Row>
      <Row data-entry-id="group-privacy">
   	    <Cell style="width: 30%; font-weight: bold;">PRIVACY</Cell>
       	<Cell style="width: 70%;">{data.private == 'yes' ? 'PRIVATE' : 'PUBLIC'}</Cell>
   	  </Row>
    </Body>
</DataTable>

{#if data.groups.length}
<div style="text-align: center;" class="mdc-typography--headline4">SUB-GROUPS</div>
<DataTable table$aria-label="Subgroup Data" style="width: 100%;">
    <Head>
        <Row>
            <Cell columnId="value" style="text-align: center;">
                <Label>NAME</Label>
            </Cell>
            <Cell columnId="group" style="text-align: center;">
                <Label>EMAIL</Label>
            </Cell>
            <Cell columnId="group" style="text-align: center;">
                <Label>PRIVACY</Label>
            </Cell>
        </Row>
    </Head>
    <Body>
	{#each data.groups as group_id ( group_id )}
      <Row data-entry-id="subgroup">
   	    <Cell style="text-align: center;">{findGroup(group_id)['name']} { findGroup(group_id).category ? ( '( ' + findGroup(group_id).category + ')' ) : '' }</Cell>
       	<Cell style="text-align: center;">{findGroup(group_id)['email']}</Cell>
       	<Cell style="text-align: center;">{findGroup(group_id)['private'] == 'yes' ? 'PRIVATE' : 'PUBLIC'}</Cell>
   	  </Row>
	{/each}
    </Body>
</DataTable>
{/if}

{#if roles && roles.length}
<div style="text-align: center;" class="mdc-typography--headline4">GROUP ROLES</div>
<DataTable table$aria-label="Role Data" style="width: 100%;">
    <Head>
        <Row>
            <Cell columnId="value" style="text-align: center;">
                <Label>NAME</Label>
            </Cell>
        </Row>
    </Head>
    <Body>
    {#each roles as role ( role.id )}
      <Row data-entry-id="role">
        <Cell style="text-align: center;">{role.role}</Cell>
      </Row>
    {/each}
    </Body>
</DataTable>
{/if}

{#if data.members.length}
<div style="text-align: center;" class="mdc-typography--headline4">MEMBERS</div>
<DataTable table$aria-label="Member Data" style="width: 100%;">
    <Head>
        <Row>
            <Cell columnId="value" style="text-align: center;">
                <Label>ROLE</Label>
            </Cell>
            <Cell columnId="value" style="text-align: center;">
                <Label>NAME</Label>
            </Cell>
            <Cell columnId="group" style="text-align: center;">
                <Label>EMAIL</Label>
            </Cell>
            <Cell columnId="group" style="text-align: center;">
                <Label>INSTITUTION</Label>
            </Cell>
        </Row>
    </Head>
    <Body>
	{#each data.members as member (member.member_id)}
      <Row data-entry-id="member">
   	    <Cell style="text-align: center;">{findRole(member.role_id)}</Cell>
   	    <Cell style="text-align: center;">{findMember(member.member_id).name_first} {findMember(member.member_id).name_last}</Cell>
       	<Cell style="text-align: center;">{findMember(member.member_id).email}</Cell>
       	<Cell style="text-align: center;">{findMember(member.member_id).institution__name_full}</Cell>
   	  </Row>
	{/each}
    </Body>
</DataTable>
{/if}

</Paper>

{/await}

<style>

</style>