<script>

import DataTable, { Head, Body, Row, Cell, Label, SortValue, Pagination } from '@smui/data-table';
import IconButton from '@smui/icon-button';
import Select, { Option } from '@smui/select';
import LinearProgress from '@smui/linear-progress';
import Paper from '@smui/paper';

import { getInstitution, getInstitutionFields, getInstitutionFieldgroups } from '../utils/pnb-api.js';
import { convertInstitution } from '../utils/pnb-convert.js';

import { institution_id, auth } from '../store.js';
import { downloadInstitution } from '../utils/pnb-download.js';

let title = '', subtitle = '';

const fetchInstitution = async ( id ) => {

	let data = [],
		i = await downloadInstitution( id );

    if ( id && i.cinstitution) {
        title = i.cinstitution.name_full || 'N/A';
        subtitle = i.cinstitution.country || 'COUNTRY NOT SET';
    }

	for ( const id of i.institution_fields_ordered ) {
		if ( i.institution_fields[ id ].is_enabled != 'y' ) { continue; }
		if ( i.institution_fields[ id ].privacy !== 'public' && !( $auth['role'] == 'ADMIN' || $auth['role'] == 'EDITOR' ) ) { continue; }

       	data.push({
           	id: parseInt(id),
            desc: i.institution_fields[id].name_desc,
            value: i.cinstitution[ i.institution_fields[id].name_fixed ] || '',
            group: i.institution_groups[ i.institution_fields[id].group ].name_full
        });
    }

	return data;
}

</script>

{#await fetchInstitution( $institution_id )}

<LinearProgress indeterminate />

{:then data}

<div style="text-align: center;" class="mdc-typography--headline4">{title}</div>
<div style="text-align: center;" class="mdc-typography--subtitle1">{subtitle}</div>

<Paper>
<DataTable table$aria-label="Institution Data" style="width: 100%;">
    <Head>
        <Row>
            <Cell columnId="field" style="width: 20%; text-align: left;">
                <Label>FIELD</Label>
            </Cell>
            <Cell columnId="value" style="width: 60%; text-align: left;">
                <Label>VALUE</Label>
            </Cell>
            <Cell columnId="group" style="width: 20%; text-align: left;">
                <Label>GROUP</Label>
            </Cell>
        </Row>
    </Head>
    <Body>
    {#each data as item (item.id)}
      <Row data-entry-id="{item.id}">
        <Cell style="width: 20%; font-weight: bold;">{item.desc}</Cell>
        <Cell style="width: 60%;">{item.value}</Cell>
        <Cell style="width: 20%;">{item.group}</Cell>
      </Row>
    {/each}
    </Body>
</DataTable>
</Paper>

{/await}

<style>

</style>