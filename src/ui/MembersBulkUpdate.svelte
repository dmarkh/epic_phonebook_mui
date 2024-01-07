<script>

import LinearProgress from '@smui/linear-progress';
import DataTable, { Head, Body, Row, Cell, Label, SortValue, Pagination } from '@smui/data-table';
import Button, { Label as ButtonLabel, Icon as ButtonIcon } from '@smui/button';
import Fab, { Label as FabLabel, Icon as FabIcon } from '@smui/fab';
import Textfield from '@smui/textfield';
import Checkbox from '@smui/checkbox';
import FormField from '@smui/form-field';
import Select, { Option as SelectOption } from '@smui/select';
import Paper from '@smui/paper';

import AccessDenied from './AccessDenied.svelte';

import readXlsxFile from 'read-excel-file';

import { auth } from '../store.js';
import { getMemberFields, getMemberFieldgroups } from '../utils/pnb-api.js';
import { orderKeys } from '../utils/pnb-download.js';

let valueTypeFiles = null,
	fileIsBeingParsed = false,
	fileData = false,
	fieldData = false,
	fieldValues = [];

let skipFirstRow = false;

const importNewData = async () => {
	console.log('...importing new data...');
	console.log( 'field values', fieldValues );
	console.log( 'field data', fieldData );
	console.log( 'skipFirstRow', skipFirstRow );
	console.log( 'file data', fileData );
}

const fetchFields = async () => {
	let fields = await getMemberFields();
	let groups = await getMemberFieldgroups();
	let fields_ordered = orderKeys( fields, (a,b) => a.group == b.group ? ( a.weight - b.weight ) : groups[a.group].weight - groups[b.group].weight );
	return { fields, groups, fields_ordered };
}

const processUploadedFile = async () => {
	fileIsBeingParsed = true;
	if ( !fieldData ) {
		fieldData = await fetchFields();
	}
	let rows = await readXlsxFile(valueTypeFiles[0]);
	for( let i = 0, ilen = rows[0].length; i < ilen; i++ ) {
		fieldValues[i] = "";
	}
	fileIsBeingParsed = false;
	fileData = rows;
}

$: if (valueTypeFiles != null && valueTypeFiles.length) {
	processUploadedFile();
}

</script>

{#if $auth['grants']['members-bulk-update']}

<div style="text-align: center;" class="mdc-typography--headline4">BULK UPDATE FROM <b>XLSX</b>: MEMBERS</div>

<div class="columns">
	<div class="hide-file-ui">
		<Textfield variant="filled" bind:files={valueTypeFiles} label="SELECT XLSX FILE" type="file" accept=".xlsx" />
	</div>
	{#if fileData}
	<div>
	<FormField>
		<Checkbox bind:checked={skipFirstRow} variant="outlined" />
		<span slot="label">SKIP FIRST/HEADER ROW</span>
		</FormField>
	</div>
	{/if}
</div>

{#if fileIsBeingParsed}
	<LinearProgress indeterminate />
{/if}

{#if fileData}
<Paper>
<p>PLEASE SELECT AN APPROPRIATE FIELD NAME FOR EACH COLUMN. NOTE THAT AT LEAST ONE COLUMN SHOULD BE EITHER "ID" (db ID) OR "ORCID".</p>
<DataTable table$aria-label="Imported Data" style="width: 100%;">
    <Head>
        <Row>
            {#each fileData[0] as hdr, idx (idx)}
            <Cell columnId="{idx}">
				<select bind:value={fieldValues[ idx ]} style="width: 20vmin;">
					<option value="">NOT SET</option>
					<option value="__id">ID</option>
				{#each fieldData.fields_ordered as id (id) }
					<option value="{fieldData.fields[id].name_fixed}">{fieldData.fields[id].name_desc}</option>
				{/each}
				</select>
            </Cell>
            {/each}
        </Row>
    </Head>
    <Body>
    {#each fileData as row, idx (idx)}
		{#if !(idx == 0 && skipFirstRow)}
		<Row>
		{#each row as row_data, row_idx ( row_idx ) }
			<Cell>
				{row_data}
			</Cell>
		{/each}
		</Row>
		{/if}
    {/each}
    </Body>
</DataTable>
</Paper>

<div class="save-button">
<Fab color="primary" on:click={() => { importNewData(); }} extended>
	<FabIcon class="material-icons">save</FabIcon>
	<FabLabel>UPDATE EXISTING MEMBERS</FabLabel>
</Fab>
</div>

{/if}

{:else}
	<AccessDenied />
{/if}
<style>
.hide-file-ui :global(input[type='file']::file-selector-button) {
	display: none;
}
.hide-file-ui :global(:not(.mdc-text-field--label-floating) input[type='file']) {
	color: transparent;
}
.columns {
    display: flex;
    flex-wrap: wrap;
    align-items: baseline;
}
.columns > * {
    margin-right: 2vmin;
	margin-bottom: 5vmin;
}
.save-button {
    position: absolute;
    bottom: 2vmin;
    right: 2vmin;
}
</style>