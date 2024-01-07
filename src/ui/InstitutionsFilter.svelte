<script>

import {router, Route} from 'tinro';

import LinearProgress from '@smui/linear-progress';
import Paper, { Content } from '@smui/paper';
import Radio from '@smui/radio';
import FormField from '@smui/form-field';
import Select, { Option } from '@smui/select';
import Textfield from '@smui/textfield';
import HelperText from '@smui/textfield/helper-text';
import IconButton from '@smui/icon-button';
import Fab, { Label as FabLabel, Icon as FabIcon } from '@smui/fab';
import DataTable, { Head, Body, Row, Cell, Label, SortValue, Pagination } from '@smui/data-table';

import { getInstitutions, getInstitutionFields, getInstitutionFieldgroups } from '../utils/pnb-api.js';
import { convertInstitutions } from '../utils/pnb-convert.js';
import { orderKeys } from '../utils/pnb-download.js';
import { find_field_id } from '../utils/pnb-search.js';

import { screen, institution_id } from '../store.js';

let showfiltered = false;
let allany = 'all';

let institutions = false,
	filtered_institutions = false,
	fields = false,
	fieldgroups = false,
	fields_ordered = false;

let field_ids = {},
	field_names = {};

let filter_options = [
	{ "option": "all", "label": "Match ALL criteria" },
	{ "option": "any", "label": "Match ANY criteria" }
];

let filters = [
	{ "field": "name_full", "op": "notempty", "value": "" }
];

let operations = [
	{ "name": "equals to", "value": "equals" },
	{ "name": "does not equal to", "value": "notequals" },
	{ "name": "contains", "value": "contains" },
	{ "name": "does not contain", "value": "notcontains" },
	{ "name": "starts with", "value": "startswith" },
	{ "name": "ends with", "value": "endswith" },
	{ "name": "is empty", "value": "empty" },
	{ "name": "is not empty", "value": "notempty" }
];

let display_fields = JSON.parse(JSON.stringify( window.pnb['filter-institutions']['display-fields'] )),
	sort_fields = JSON.parse(JSON.stringify( window.pnb['filter-institutions']['sort-fields'] ));

const remove_filter = (idx) => {
	if ( idx >= 0 ) {
		filters.splice(idx, 1);
		filters = filters;
	}
}

const add_filter = (idx) => {
	filters = [ ...filters, { "field": "name_full", "op": "notempty", "value": "" } ];
}

const remove_display_field = (idx) => {
	if ( idx >= 0 ) {
		display_fields.splice(idx, 1);
		display_fields = display_fields;
	}
}

const add_display_field = (idx) => {
	display_fields = [ ...display_fields, "name_full" ];
}

const remove_sort_field = (idx) => {
	if ( idx >= 0 ) {
		sort_fields.splice(idx, 1);
		sort_fields = sort_fields;
	}
}

const add_sort_field = (idx) => {
	sort_fields = [ ...sort_fields, "name_full" ];
}

const apply_filters = async () => {
	filtered_institutions = {};
	for ( const [k,v] of Object.entries( institutions ) ) {
		let pass = false, cpass,
			flds = v.fields;
		for ( const f of filters ) {
			switch( f.op ) {
				case 'empty':
					cpass = ( flds[f.field] && typeof flds[f.field] === 'string' && flds[f.field].length == 0 ) || flds[f.field] === undefined;
					break;
				case 'notempty':
					cpass =  ( flds[f.field] && typeof flds[f.field] === 'string' && flds[f.field].length == 0 ) || flds[f.field] === undefined;
					break;
				case 'equals':
					cpass = flds[f.field] && (
						( typeof flds[f.field] !== 'string' && flds[f.field] == f.value )
							||
						( typeof flds[f.field] === 'string' && flds[f.field].toLowerCase() == f.value.toLowerCase() ) );
					break;
				case 'notequals':
					cpass = flds[f.field] && (
						( typeof flds[f.field] !== 'string' && flds[f.field] != f.value )
							||
						( typeof flds[f.field] === 'string' && flds[f.field].toLowerCase() != f.value.toLowerCase() ) );
					break;
				case 'contains':
					cpass = flds[f.field] && typeof flds[f.field] === 'string' && flds[f.field].toLowerCase().includes( f.value.toLowerCase() );
					break;
				case 'notcontains':
					cpass = flds[f.field] && typeof flds[f.field] === 'string' && !flds[f.field].toLowerCase().includes( f.value.toLowerCase() );
					break;
				case 'startswith':
					cpass = flds[f.field] && typeof flds[f.field] === 'string' && flds[f.field].toLowerCase().startsWith( f.value.toLowerCase() );
					break;
				case 'endswith':
					cpass = flds[f.field] && typeof flds[f.field] === 'string' && flds[f.field].toLowerCase().endsWith( f.value.toLowerCase() );
					break;
				default:
					console.log('ERROR, unknown filter: ' + f.op );
					break;
			}
			pass = pass || cpass;
			if ( allany === 'all' && cpass === false ) {
				pass = false; break;
			} else if (	allany === 'any' && cpass === true ) {
				pass = true; break;
				break;
			}
		}
		if ( pass === true ) {
			filtered_institutions[ k ] = v;
		}
	}
	filtered_institutions = await convertInstitutions( filtered_institutions, fields );

	console.log( 'fields', fields, field_ids );

	// TODO: sort institutions by sort_fields

	showfiltered = true;
}

let init = async () => {
	institutions = await getInstitutions();
	fields = await getInstitutionFields();
	fieldgroups = await getInstitutionFieldgroups();
	for( const [k,v] of Object.entries(fields) ) {
		field_ids[ v.name_fixed ] = v.id;
		field_names[ v.id ] = v.name_fixed;
	}
	fields_ordered = orderKeys( fields, (a,b) => a.group == b.group ? ( a.weight - b.weight ) : fieldgroups[a.group].weight - fieldgroups[b.group].weight );
}

const handleRowClick = ( e ) => {
    $institution_id = e.target.dataset.entryId;
    $screen = 'institution';
    router.goto('/institution/' + $institution_id + '/view');
}

</script>

{#if showfiltered == false}

{#await init()}
	<LinearProgress indeterminate />
{:then}
<div style="text-align: center;" class="mdc-typography--headline4">FILTER INSTITUTIONS</div>
<Paper>
<p>FILTERS</p>
<div>
  {#each filter_options as option}
    <FormField>
      <Radio bind:group={allany} value={option.option} touch />
      <span slot="label">{option.label}</span>
    </FormField>
  {/each}
</div>

<div>
<table style="width: 100%;">
{#each filters as filter, i (i)}
<tr>
<td>
    <Select bind:value={filters[i].field} label="FIELD" variant="outlined" style="width: 100%;">
      {#each fields_ordered as field_id}
        <Option value={fields[field_id].id}>{fields[field_id].name_desc}</Option>
      {/each}
    </Select>
</td>
<td>
    <Select bind:value={filters[i].op} label="OPERATION" variant="outlined" style="width: 100%;">
      {#each operations as operation}
        <Option value={operation.value}>{operation.name}</Option>
      {/each}
    </Select>
</td>
<td>
    <Textfield bind:value={filters[i].value} label="VALUE" variant="outlined" style="width: 100%;"/>
</td>
<td style="width: 5%;">
	<IconButton class="material-icons" on:click={() => { add_filter(i) }} size="button">add</IconButton>
</td>
<td style="width: 5%;">
	<IconButton class="material-icons" on:click={() => { remove_filter(i); }} size="button">remove</IconButton>
</td>
</tr>
{/each}
</table>
</div>

</Paper>
<br />
<Paper>
<table style="width: 100%;">
<tr>
<td style="width: 50%; vertical-align: top;">
<p>DISPLAY FIELDS</p>
<table style="width: 100%;">
{#each display_fields as field, i (i)}
<tr>
<td>
    <Select bind:value={field} label="FIELD" variant="outlined" style="width: 100%;">
      {#each fields_ordered as field_id}
        <Option value={fields[field_id].name_fixed}>{fields[field_id].name_desc}</Option>
      {/each}
    </Select>
</td>
<td style="width: 5%;">
	<IconButton class="material-icons" on:click={() => { add_display_field(i) }} size="button">add</IconButton>
</td>
<td style="width: 5%;">
	<IconButton class="material-icons" on:click={() => { remove_display_field(i); }} size="button">remove</IconButton>
</td>
</tr>
{/each}
</table>

</td>
<td style="width: 50%; vertical-align: top;">
<p>SORT FIELDS (ORDER MATTERS)</p>
<table style="width: 100%;">
{#each sort_fields as field, i (i)}
<tr>
<td>
    <Select bind:value={field} label="FIELD" variant="outlined" style="width: 100%;">
      {#each fields_ordered as field_id}
        <Option value={fields[field_id].name_fixed}>{fields[field_id].name_desc}</Option>
      {/each}
    </Select>
</td>
<td style="width: 5%;">
	<IconButton class="material-icons" on:click={() => { add_sort_field(i) }} size="button">add</IconButton>
</td>
<td style="width: 5%;">
	<IconButton class="material-icons" on:click={() => { remove_sort_field(i); }} size="button">remove</IconButton>
</td>
</tr>
{/each}
</table>

</td>
</tr>
</table>

</Paper>

<div class="apply-filters-button">
    <Fab color="primary" on:click={() => { apply_filters(); }} extended>
      <FabIcon class="material-icons">search</FabIcon>
    <FabLabel>APPLY FILTERS</FabLabel>
    </Fab>
</div>

{/await}

{:else}
	<div style="text-align: center;" class="mdc-typography--headline4">FILTERED INSTITUTIONS:</div>

<Paper>
<DataTable table$aria-label="Institution List" style="width: 100%;"
  sortable
  on:SMUIDataTableRow:click={handleRowClick}
>
    <Head>
        <Row>
            {#each display_fields.map( df => { return { "title": fields[ field_ids[df] ].name_desc, "field": df, "align": "left", "width": "unset" }; }) as inst}
            <Cell columnId="name_full" style="text-align: {inst.align}; width: {inst.width};">
                <Label>{inst.title}</Label>
                <IconButton class="material-icons">arrow_upward</IconButton>
            </Cell>
            {/each}
        </Row>
    </Head>
    <Body>
    {#each filtered_institutions as item (item.id)}
      <Row data-entry-id="{item.id}">
        {#each display_fields.map( df => { return { "title": df, "field": df, "align": "left", "width": "unset" }; }) as inst }
        <Cell style="text-align: {inst.align}; width: {inst.width};">
            {#if inst.field === 'country' && item['country_code']}
            <img src="images/flags_iso_3166/24/{item['country_code'].toLowerCase()}.png" style="vertical-align: text-bottom;"/>
            {/if}
            {item[ inst.field ] || ''}
        </Cell>
        {/each}
      </Row>
    {/each}
    </Body>
</DataTable>
</Paper>
{/if}

<style>
.apply-filters-button {
    position: absolute;
    bottom: 2vmin;
    right: 2vmin;
}
</style>