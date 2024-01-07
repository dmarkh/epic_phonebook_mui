<script>

import {meta, router, Route} from 'tinro';

import LinearProgress from '@smui/linear-progress';
import Paper, { Content } from '@smui/paper';
import Select, { Option } from '@smui/select';
import IconButton from '@smui/icon-button';
import Fab, { Label, Icon } from '@smui/fab';
import Textfield from '@smui/textfield';
import HelperText from '@smui/textfield/helper-text';
import CharacterCounter from '@smui/textfield/character-counter';

import { downloadInstitution } from '../utils/pnb-download.js';
import { find_field_id } from '../utils/pnb-search.js';

export let institutionId;
export let recordUpdated;

let title = false, subtitle = false;
let	country_ids_sorted = [],
	country_codes_sorted = [];
let preedit_field_values  = {},
	postedit_field_values = {};
let ifields = {};

const fetchInstitution = async () => {
    let data = [];
    let i = await downloadInstitution( institutionId );
	ifields = i.institution_fields;
   	country_ids_sorted = i.country_ids_sorted;
	country_codes_sorted = i.country_codes_sorted;
	if ( institutionId && i.cinstitution ) {
		title = i.cinstitution.name_full;
	} else {
		title = 'NEW INSTITUTION';
	}
	if ( i.cinstitution ) {
	    subtitle = i.cinstitution.country || 'COUNTRY NOT SET';
	} else {
		subtitle = '';
	}
    for ( const id of i.institution_fields_ordered ) {
   	    preedit_field_values[ id ] = i.institution.fields[id] || '';
       	postedit_field_values[ id ] = i.institution.fields[id] || '';
        data.push({
   	        id: parseInt(id),
       	    field: i.institution_fields[id],
           	value: i.institution.fields[id],
	        cvalue: i.cinstitution[ i.institution_fields[id].name_fixed ],
       	    group: i.institution_groups[ i.institution_fields[id].group ].name_full
        });
   	}
	return data;
}

const updateRecord = () => {
	let changes = [];
    for ( const k of Object.keys(preedit_field_values) ) {
        if ( preedit_field_values[k] != postedit_field_values[k] && !( preedit_field_values[k] == '' && postedit_field_values[k] === undefined ) ) {
			changes.push({ "field_id": k, "pre": preedit_field_values[k], "post": postedit_field_values[k] });
        }
    }
	if ( recordUpdated ) {
		recordUpdated( institutionId, changes, postedit_field_values );
	}
}

const updateField = ( name_from, name_to ) => {
	let from_id = find_field_id( ifields, name_from ),
		to_id = find_field_id( ifields, name_to );
	postedit_field_values[ to_id ] = postedit_field_values[ from_id ];
}

</script>

{#await fetchInstitution() }

<LinearProgress indeterminate />

{:then data}

{#if title}
	<div style="text-align: center;" class="mdc-typography--headline4">{title}</div>
{/if}
{#if subtitle}
    <div style="text-align: center;" class="mdc-typography--subtitle1">{subtitle}</div>
{/if}

<Paper>

{#each data as item (item.id)}
<div>

{#if item.field.decoded_options}
    <Select 
		key={(id) => `${id ? id : ''}`}
		bind:value={postedit_field_values[ item.id ]}
        style="width: 100%;"
        label="{item.field.name_desc}"
    >
      {#each Object.entries(item.field.decoded_options) as [opt_key, opt_val] }
        <Option value={opt_key}>{opt_val}</Option>
      {/each}
    </Select>

{:else if item.field.name_fixed == 'country_code'}
    <Select bind:value={postedit_field_values[ item.id ]}
        style="width: 100%;"
        label="{item.field.name_desc}"
    >
      {#each country_codes_sorted as country_code (country_code[0]) }
        <Option value={country_code[0]}>{country_code[1]}</Option>
      {/each}
    </Select>

{:else if item.field.name_fixed == 'country'}
    <Select bind:value={postedit_field_values[ item.id ]} on:SMUISelect:change={ () => { updateField('country', 'country_code'); } }
        style="width: 100%;"
        label="{item.field.name_desc}"
    >
      {#each country_ids_sorted as country (country[0]) }
        <Option value={country[0]}>{country[1]}</Option>
      {/each}
    </Select>
{:else}
    {#if item.field.type === 'number'}
        <Textfield bind:value={ postedit_field_values[ item.id ] }
            style="width: 100%;"
            helperLine$style="width: 100%;"
            label="{item.field.name_desc}"
            type="number"
        >
          <svelte:fragment slot="helper">
            <HelperText>{item.field.hint_full}</HelperText>
          </svelte:fragment>
        </Textfield>

    {:else if item.field.type === 'date'}
        <Textfield bind:value={ postedit_field_values[ item.id ] }
            style="width: 100%;"
            helperLine$style="width: 100%;"
            label="{item.field.name_desc}"
            type="date"
        >
          <svelte:fragment slot="helper">
            <HelperText>{item.field.hint_full}</HelperText>
          </svelte:fragment>
        </Textfield>
    {:else}
        <Textfield bind:value={ postedit_field_values[ item.id ] }
            style="width: 100%;"
            helperLine$style="width: 100%;"
            label="{item.field.name_desc}"
            input$maxlength={item.field.size_max}
        >
          <svelte:fragment slot="helper">
            <HelperText>{item.field.hint_full}</HelperText>
            <CharacterCounter>0 / {item.field.size_max}</CharacterCounter>
          </svelte:fragment>
        </Textfield>
    {/if}

{/if}

</div>
{/each}

<div class="save-button">
    <Fab color="primary" on:click={() => { updateRecord(); }} extended>
      <Icon class="material-icons">save</Icon>
{#if institutionId}
    <Label>UPDATE RECORD</Label>
{:else}
	<Label>CREATE NEW RECORD</Label>
{/if}
    </Fab>
</div>

</Paper>

{/await}

<style>
.save-button {
    position: absolute;
    bottom: 2vmin;
    right: 2vmin;
}
</style>