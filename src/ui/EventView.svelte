<script>

import DataTable, { Head, Body, Row, Cell, Label, SortValue, Pagination } from '@smui/data-table';
import IconButton from '@smui/icon-button';
import Select, { Option } from '@smui/select';
import LinearProgress from '@smui/linear-progress';
import Paper from '@smui/paper';

import { getEvent, getEventFields } from '../utils/pnb-api.js';
import { convertEvent } from '../utils/pnb-convert.js';

import { getMembers } from '../utils/pnb-api.js';
import { convertMembers } from '../utils/pnb-convert.js';
import { sortConvertedMembers } from '../utils/pnb-sort.js';
import { find_field_id } from '../utils/pnb-search.js';

import { event_id, auth } from '../store.js';
import { downloadEvent } from '../utils/pnb-download.js';

let title = '', subtitle = '';

let members = false;
let member_ids_fid = false;

const find_member = ( mid ) => {
    for ( const m of members ) {
        if ( m.id == mid ) { return (m.name_first + ' ' + m.name_last); }
    }
    return '';
}

const fetchEvent = async ( id ) => {

    const mem = await getMembers();
    members = await convertMembers( mem );
    sortConvertedMembers( members );


	let data = [],
		i = await downloadEvent( id );

	member_ids_fid = find_field_id( i.event_fields, 'member_ids' );

    if ( id && i.cevent) {
        title = i.cevent.title || 'EVENT';
    }

	for ( const id of i.event_fields_ordered ) {
		if ( i.event_fields[ id ].is_enabled != 'y' ) { continue; }
		if ( i.event_fields[ id ].privacy !== 'public' && !( $auth['role'] == 'ADMIN' || $auth['role'] == 'EDITOR' ) ) { continue; }

       	data.push({
           	id: parseInt(id),
            desc: i.event_fields[id].name_desc,
            value: i.cevent[ i.event_fields[id].name_fixed ] || ''
        });
    }

	return data;
}

</script>

{#await fetchEvent( $event_id )}

<LinearProgress indeterminate />

{:then data}

<div style="text-align: center;" class="mdc-typography--headline4">{title}</div>
<div style="text-align: center;" class="mdc-typography--subtitle1">{subtitle}</div>

<Paper>
<DataTable table$aria-label="Event Data" style="width: 100%;">
    <Head>
        <Row>
            <Cell columnId="field" style="width: 20%; text-align: left;">
                <Label>FIELD</Label>
            </Cell>
            <Cell columnId="value" style="width: 60%; text-align: left;">
                <Label>VALUE</Label>
            </Cell>
        </Row>
    </Head>
    <Body>
    {#each data as item (item.id)}
      <Row data-entry-id="{item.id}">
        <Cell style="width: 30%; font-weight: bold;">{item.desc}</Cell>
        <Cell style="width: 70%;">
			{#if item.id == member_ids_fid}
				{ item.value.split(',').reduce( (acc,cur) => { acc.push( find_member(cur) ); return acc; }, [] ).join(', ') }
			{:else}
				{item.value}
			{/if}
		</Cell>
      </Row>
    {/each}
    </Body>
</DataTable>
</Paper>

{/await}

<style>

</style>