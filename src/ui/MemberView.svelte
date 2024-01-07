<script>

import DataTable, { Head, Body, Row, Cell, Label, SortValue, Pagination } from '@smui/data-table';
import IconButton from '@smui/icon-button';
import Select, { Option } from '@smui/select';
import LinearProgress from '@smui/linear-progress';
import Paper from '@smui/paper';

import { downloadMember } from '../utils/pnb-download.js';
import { member_id } from '../store.js';

let title = '', subtitle = '';

const fetchMember = async () => {
	let data = [];
	let m = await downloadMember( $member_id );

	title = m.cmember.name_first + ' ' + m.cmember.name_last;
	if ( m.cinstitution && m.cinstitution.name_full ) {
    	subtitle = m.cinstitution.name_full || 'INSTITUTION NOT SET';
	} else {
		subtitle = 'INSTITUTION NOT SET';
	}

	for ( const id of m.member_fields_ordered ) {
		data.push({
			id: parseInt(id),
			desc: m.member_fields[id].name_desc,
			value: ( m.member_fields[id].name_fixed === 'institution_id' && m.cinstitution && m.cinstitution.name_full ) ? m.cinstitution.name_full : ( m.cmember[ m.member_fields[id].name_fixed ] || '' ),
			group: m.member_groups[ m.member_fields[id].group ].name_full
		});
	}

	return data;
}

</script>

{#await fetchMember()}

<LinearProgress indeterminate />

{:then data}

<div style="text-align: center;" class="mdc-typography--headline4">{title}</div>
{#if subtitle}
	<div style="text-align: center;" class="mdc-typography--subtitle1">{subtitle}</div>
{/if}
<Paper>
<DataTable table$aria-label="Member Data" style="width: 100%;">
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