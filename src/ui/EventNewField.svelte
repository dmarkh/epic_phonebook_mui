<script>

import PleaseWait from './PleaseWait.svelte';
import AccessDenied from './AccessDenied.svelte';

import LinearProgress from '@smui/linear-progress';
import Fab, { Label, Icon } from '@smui/fab';
import Paper, { Content } from '@smui/paper';
import Select, { Option } from '@smui/select';
import Textfield from '@smui/textfield';
import HelperText from '@smui/textfield/helper-text';

import { sleep } from '../utils/sleep.js';
import { auth } from '../store.js';
import { getEventFields, createEventField } from '../utils/pnb-api.js';

import {router, Route} from 'tinro';

let pleaseWait = false, subtitle = '';
let preedit_field_values  = {},
    postedit_field_values = {};

const fetchData = async() => {
	let names = [
		{ 'name': 'name_fixed', 'editable': 1, 'value': '' },
		{ 'name': 'name_desc', 'editable': 1, 'value': '' },
		{ 'name': 'weight', 'editable': 1, 'value': '1' },
		{ 'name': 'type', 'editable': 1, 'value': 'string', 'options': [ ['string','STRING'], ['int','INTEGER'], ['date', 'DATE'], ['text', 'TEXT'] ] },
		{ 'name': 'options', 'editable': 1, 'value': '' },
		{ 'name': 'size_min', 'editable': 1, 'value': '1' },
		{ 'name': 'size_max', 'editable': 1, 'value': '255' },
		{ 'name': 'hint_short', 'editable': 1, 'value': '' },
		{ 'name': 'hint_full', 'editable': 1, 'value': '' },
		{ 'name': 'is_required', 'editable': 1, 'value': 'n', 'options': [ ['y','YES'], ['n','NO'] ] },
		{ 'name': 'is_enabled', 'editable': 1, 'value': 'y', 'options': [ ['y','YES'], ['n','NO'] ] }
	];
	let fields = await getEventFields();
	for ( const v of names ) {
		postedit_field_values[ v.name ] = v.value;
		if ( !v.value && v.options && v.options.length ) {
			v.value = v.options[0][0];
		}
	}

	return names;
}

const updateRecord = async () => {
	pleaseWait = 'ADDING NEW EVENT FIELD, PLEASE WAIT';

	let changes = Object.entries( postedit_field_values );

    let data = { };
	for ( const v of changes ) {
		data[ v[0] ] = v[1];
	}

	console.log( 'data', data );

	let rc = await createEventField( data );

	await sleep(1000);
	router.goto('/event-field/' + rc.id + '/view');
	pleaseWait = false;
}

</script>

{#if $auth['grants']['descriptors-edit']}

{#await fetchData()}
	<LinearProgress indeterminate />

{:then data}
    <div style="text-align: center;" class="mdc-typography--headline4">NEW EVENT FIELD DESCRIPTOR</div>
	<div style="text-align: center;" class="mdc-typography--subtitle1">{subtitle}</div>
<Paper>
	<table width="100%">
	{#each data as item, idx (idx)}
		<tr>
			<td>
			{#if item.editable}
				{#if item.options}
					<Select
						bind:value={postedit_field_values[ item.name ]}
						style="width: 100%;"
						label="{item.name}"
					>
						{#each item.options as opt (opt[0]) }
							<Option value={opt[0]}>{opt[1]}</Option>
						{/each}
					</Select>
				{:else}
					<Textfield bind:value={ postedit_field_values[ item.name ] }
						style="width: 100%;"
						helperLine$style="width: 100%;"
						label="{item.name}"
					>
					<svelte:fragment slot="helper">
						<HelperText>{item.name}</HelperText>
					</svelte:fragment>
					</Textfield>
				{/if}

			{/if}
			</td>
		</tr>
	{/each}
	</table>

	<div class="save-button">
    	<Fab color="primary" on:click={() => { updateRecord(); }} extended>
	      <Icon class="material-icons">save</Icon>
		    <Label>CREATE RECORD</Label>
	    </Fab>
	</div>
</Paper>
{/await}

	{#if pleaseWait}
		<PleaseWait text="{pleaseWait}" />
	{/if}

{:else}
	<AccessDenied />
{/if}

<style>
.save-button {
    position: absolute;
    bottom: 2vmin;
    right: 2vmin;
}
</style>