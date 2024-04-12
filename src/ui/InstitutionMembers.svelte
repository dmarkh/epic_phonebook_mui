<script>

import {meta, router, Route} from 'tinro';

import DataTable, { Head, Body, Row, Cell, Label, SortValue, Pagination } from '@smui/data-table';
import IconButton from '@smui/icon-button';
import Select, { Option } from '@smui/select';
import LinearProgress from '@smui/linear-progress';

import { getInstitution, getInstitutionFields, getInstitutionFieldgroups } from '../utils/pnb-api.js';
import { convertInstitution } from '../utils/pnb-convert.js';

import { getMembers, getMemberFields } from '../utils/pnb-api.js';
import { convertMembers, addInstitutionsToConvertedMembers } from '../utils/pnb-convert.js';
import { sortConvertedMembers } from '../utils/pnb-sort.js';

import { institution_id } from '../store.js';

import { screen, member_id, member_mode } from '../store.js';

let title = '', subtitle = '';

const downloadInstitution = async ( id ) => {
    let data = [];
    let idata = await getInstitution( id );
    let ifields = await getInstitutionFields();
    let igroups = await getInstitutionFieldgroups();
    let cidata = await convertInstitution( idata );
    title = cidata.name_full;
	subtitle = cidata.country || 'COUNTRY NOT SET';

    let mem = await getMembers();
    let items = await convertMembers( mem );
	items = items.filter( m => m.institution_id == $institution_id );
    sortConvertedMembers( items );

	return items;
}

const handleRowClick = ( e ) => {
    $member_mode = 'view';
    $member_id = e.target.dataset.entryId;
    $screen = 'member';
	router.goto('/member/' + $member_id + '/view');
}

</script>

{#await downloadInstitution( $institution_id )}

<LinearProgress indeterminate />

{:then data}

<div style="text-align: center;" class="mdc-typography--headline4">{title}</div>
<div style="text-align: center;" class="mdc-typography--subtitle1">{subtitle}</div>

<DataTable table$aria-label="Member List" style="width: 100%;"
  on:SMUIDataTableRow:click={handleRowClick}
>
    <Head>
        <Row>
            <Cell columnId="member_role" style="width: 25%; text-align: center;">
                <Label>MEMBER ROLE</Label>
            </Cell>
            <Cell columnId="name_first" style="width: 25%; text-align: right;">
                <Label>FIRST NAME</Label>
            </Cell>
            <Cell columnId="name_last" style="width: 25%; text-align: left;">
                <Label>LAST NAME</Label>
            </Cell>
            <Cell columnId="email" style="width: 25%; text-align: center;">
                <Label>EMAIL</Label>
            </Cell>
        </Row>
    </Head>
    <Body>
    {#each data as item (item.id)}
      <Row data-entry-id="{item.id}">
        <Cell style="width: 25%; text-align: center;">{item.member_role || ''}</Cell>
        <Cell style="width: 25%; text-align: right;">{item.name_first || ''}</Cell>
        <Cell style="width: 25%; text-align: left;">{item.name_last || ''}</Cell>
        <Cell style="width: 25%; text-align: center;">{item.email || ''}</Cell>
      </Row>
    {/each}
    </Body>
</DataTable>

{/await}

<style>

</style>