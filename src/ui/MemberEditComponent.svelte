<script>

import LinearProgress from '@smui/linear-progress';
import Paper, { Content } from '@smui/paper';
import Select, { Option } from '@smui/select';
import IconButton from '@smui/icon-button';
import Fab, { Label, Icon } from '@smui/fab';
import Textfield from '@smui/textfield';
import HelperText from '@smui/textfield/helper-text';
import CharacterCounter from '@smui/textfield/character-counter';

import { downloadMember } from '../utils/pnb-download.js';

export let memberId;
export let institutionId;
export let recordUpdated;

let title = false, subtitle = false;
let institution_ids_sorted = [],
	country_ids_sorted = [];
let preedit_field_values  = {},
	postedit_field_values = {};

const fetchMember = async () => {
    let data = [];
    let m = await downloadMember( memberId, institutionId );
    institution_ids_sorted = m.institution_ids_sorted;
   	country_ids_sorted = m.country_ids_sorted;
	if ( memberId && m.cmember ) {
		title = m.cmember.name_first + ' ' + m.cmember.name_last;
	} else {
		title = 'NEW MEMBER';
	}
	if ( m.cinstitution ) {
	    subtitle = m.cinstitution.name_full || 'INSTITUTION NOT SET';
	} else {
		subtitle = 'INSTITUTION NOT SET';
	}
    for ( const id of m.member_fields_ordered ) {
   	    preedit_field_values[ id ] = m.member.fields[id] || '';
       	postedit_field_values[ id ] = m.member.fields[id] || '';
        data.push({
   	        id: parseInt(id),
       	    field: m.member_fields[id],
           	value: m.member.fields[id],
	        cvalue: m.cmember[ m.member_fields[id].name_fixed ],
       	    group: m.member_groups[ m.member_fields[id].group ].name_full
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
		recordUpdated( memberId, changes, postedit_field_values );
	}
}

</script>

{#await fetchMember() }

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

{:else if item.field.name_fixed == 'institution_id'}
    <Select 
		key={(id) => `${id ? id : ''}`}
		bind:value={postedit_field_values[ item.id ]}
        style="width: 100%;"
        label="{item.field.name_desc}"
    >
      {#each institution_ids_sorted as inst (inst[0]) }
        <Option value={inst[0]}>{inst[1]}</Option>
      {/each}
    </Select>

{:else if item.field.name_fixed == 'country'}
    <Select bind:value={postedit_field_values[ item.id ]}
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
{#if memberId}
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