<script>

import DataTable, { Head, Body, Row, Cell, Label, SortValue, Pagination } from '@smui/data-table';
import IconButton from '@smui/icon-button';
import Select, { Option } from '@smui/select';
import LinearProgress from '@smui/linear-progress';
import Paper from '@smui/paper';

import { getDocument, getDocumentFields } from '../utils/pnb-api.js';
import { convertDocument } from '../utils/pnb-convert.js';

import { getMembers } from '../utils/pnb-api.js';
import { convertMembers } from '../utils/pnb-convert.js';
import { sortConvertedMembers } from '../utils/pnb-sort.js';
import { getEvents } from '../utils/pnb-api.js';
import { convertEvents } from '../utils/pnb-convert.js';
import { find_field_id } from '../utils/pnb-search.js';

import { document_id, auth } from '../store.js';
import { downloadDocument } from '../utils/pnb-download.js';

let title = '', subtitle = '';

let members = false, events = false;
let members_fid, event_fid;

const find_member = ( mid ) => {
    for ( const m of members ) {
        if ( m.id == mid ) { return m.name_first + ' ' + m.name_last; }
    }
    return 'N/A';
}

const find_event = ( eid ) => {
    for ( const e of events ) {
        if ( e.id == eid ) { return e.name; }
    }
    return 'N/A';
}

const fetchDocument = async ( id ) => {

    const mem = await getMembers();
    members = await convertMembers( mem );
    sortConvertedMembers( members );

    const evt = await getEvents();
    events = await convertEvents( evt );
    events = [ { id: 0, name: 'No Event' }, ...events ];

	let data = [],
		i = await downloadDocument( id );

    if ( id && i.cdocument) {
        title = i.cdocument.title || 'N/A';
    }

    members_fid = find_field_id( i.document_fields, 'member_ids' );
    event_fid   = find_field_id( i.document_fields, 'event_id' );

	for ( const id of i.document_fields_ordered ) {
		if ( i.document_fields[ id ].is_enabled != 'y' ) { continue; }
		if ( i.document_fields[ id ].privacy !== 'public' && !( $auth['role'] == 'ADMIN' || $auth['role'] == 'EDITOR' ) ) { continue; }

       	data.push({
           	id: parseInt(id),
            desc: i.document_fields[id].name_desc,
            value: i.cdocument[ i.document_fields[id].name_fixed ] || ''
        });
    }

	return data;
}

</script>

{#await fetchDocument( $document_id )}

<LinearProgress indeterminate />

{:then data}

<div style="text-align: center;" class="mdc-typography--headline4">{title}</div>
<div style="text-align: center;" class="mdc-typography--subtitle1">{subtitle}</div>

<Paper>
<DataTable table$aria-label="Document Data" style="width: 100%;">
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
        <Cell style="width: 70%; white-space: normal;">
            {#if item.id == members_fid}
                { item.value.split(',').reduce( (acc,cur) => { acc.push( find_member(cur) ); return acc; }, [] ).join(', ') }
            {:else if item.id == event_fid}
                { find_event( item.value ) }
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