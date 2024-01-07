<script>
import LinearProgress from '@smui/linear-progress';
import Paper, { Content } from '@smui/paper';
import Radio from '@smui/radio';
import FormField from '@smui/form-field';
import Select, { Option } from '@smui/select';
import Textfield from '@smui/textfield';
import HelperText from '@smui/textfield/helper-text';
import IconButton from '@smui/icon-button';
import Fab, { Label, Icon } from '@smui/fab';

import { getMemberFields, getMemberFieldgroups } from '../utils/pnb-api.js';
import { orderKeys } from '../utils/pnb-download.js';
import { find_field_id } from '../utils/pnb-search.js';

let allany = 'all';

let fields = false,
	fieldgroups = false,
	fields_ordered = false;

let field_ids = {},
	field_names = {};

let filter_options = [
	{ "option": "all", "label": "Match ALL criteria" },
	{ "option": "any", "label": "Match ANY criteria" }
];

let filters = [
	{ "field": "name_last", "op": "notempty", "value": "" }
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

let display_fields = JSON.parse(JSON.stringify(window.pnb['filter-members']['display-fields'])),
	sort_fields = JSON.parse(JSON.stringify(window.pnb['filter-members']['sort-fields']));

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

const apply_filters = () => {
	console.log('applying filters');
	console.log( 'filters', filters );
	console.log( 'display_fields', display_fields );
	console.log( 'sort_fields', sort_fields );
}

let init = async () => {
	fields = await getMemberFields();
	fieldgroups = await getMemberFieldgroups();
	for( const [k,v] of Object.entries(fields) ) {
		field_ids[ v.name_fixed ] = v.id;
		field_names[ v.id ] = v.name_fixed;
	}
	fields_ordered = orderKeys( fields, (a,b) => a.group == b.group ? ( a.weight - b.weight ) : fieldgroups[a.group].weight - fieldgroups[b.group].weight );
}

</script>

{#await init()}
	<LinearProgress indeterminate />
{:then}
<div style="text-align: center;" class="mdc-typography--headline4">FILTER MEMBERS</div>
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
        <Option value={fields[field_id].name_fixed}>{fields[field_id].name_desc}</Option>
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
      <Icon class="material-icons">search</Icon>
    <Label>APPLY FILTERS</Label>
    </Fab>
</div>

{/await}

<style>
.apply-filters-button {
    position: absolute;
    bottom: 2vmin;
    right: 2vmin;
}
</style>