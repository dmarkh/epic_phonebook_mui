<script>

import { onMount } from 'svelte';
import LinearProgress from '@smui/linear-progress';
import Fab, { Label, Icon } from '@smui/fab';

import { getInstitutions, getInstitutionFields } from '../utils/pnb-api.js';
import { convertInstitutions } from '../utils/pnb-convert.js';
import { sortConvertedInstitutions } from '../utils/pnb-sort.js';

import { getMembers, getMemberFields } from '../utils/pnb-api.js';
import { convertMembers } from '../utils/pnb-convert.js';
import { sortConvertedMembers } from '../utils/pnb-sort.js';

import { find_field_id, find_field_name } from '../utils/pnb-search.js';
import { strtotime } from '../utils/strtotime.js';
import { non_breaking_space } from '../utils/non-breaking-space.js';

import FileSaver from '../utils/FileSaver.js';

let author_list_data = '';

const saveAuthorListFile = () => {
    var blob = new Blob([ author_list_data ], {type: "text/plain;charset=utf-8"});
    FileSaver.saveAs(blob, "author-list-arxiv-" + ( new Date().toISOString().slice(0, 10) ) + ".txt");
}

const getAuthorListARXIV = async () => {
	let result = '';

    let institutions = await getInstitutions();
    let ifields = await getInstitutionFields();
    let convertedInstitutions = await convertInstitutions( institutions, ifields );
    sortConvertedInstitutions( convertedInstitutions );

    let members = await getMembers();
    let mfields = await getMemberFields();
    let convertedMembers = await convertMembers( members, mfields );
    sortConvertedMembers( convertedMembers );

	let now = Math.round(+new Date()/1000); // unixtime

	let field, ifield, inst_id, f_leave_date = find_field_id( mfields, 'date_leave'),
            f_is_author = find_field_id( mfields, 'is_author'),
            f_mem_latex_last_name = find_field_id( mfields, 'name_latex'),
            f_mem_last_name = find_field_id( mfields, 'name_last'),
            f_mem_initials = find_field_id( mfields, 'name_initials'),
            f_inst_id = find_field_id( mfields, 'institution_id'),
            f_inst_full_name = find_field_id( ifields, 'name_full'),
            f_inst_latex_name = find_field_id( ifields, 'name_latex'),
            f_inst_city = find_field_id( ifields, 'city'),
            f_inst_postcode = find_field_id( ifields, 'postcode'),
            f_inst_country = find_field_id( ifields, 'country');

	let inst_latex_name, inst_full_name, country_name, affiliation, affiliations = {},
            inst_list = [], mem_list = [], member_full;

        for ( let i in members ) {
            // is active member, author?
            field = members[i].fields;

            if ( !field || members[i].status !== 'active' ) { continue; }
            if ( field[ f_leave_date ] !== undefined &&
                 field[ f_leave_date ] !== '0000-00-00 00:00:00' &&
                 field[ f_leave_date ] !== '' &&
                 strtotime( field[ f_leave_date ] ) < now ) {
              continue;
            }
            if ( field[ f_is_author ] == 'n' ) { continue; }

            // has institution, belongs to active institution?
            inst_id = field[ f_inst_id ];
            if ( inst_id === undefined || inst_id === 0 ||
                 institutions[ inst_id ] === undefined ||
                 institutions[ inst_id ]['status'] !== 'active' ) { continue; }
            // full member name
            member_full = ( field[ f_mem_initials ] ? field[ f_mem_initials ] : '' ) +
                          ( ( field[ f_mem_latex_last_name ] && field[ f_mem_latex_last_name ].length > 1 ) ?
                          field[ f_mem_latex_last_name ] : field[ f_mem_last_name ] );
            mem_list.push( non_breaking_space( member_full ) );
        }

        // sort members
        mem_list = mem_list.sort( function(a, b) {
            return a.toLowerCase() > b.toLowerCase();
        });

	result = mem_list.join(', ');

	author_list_data = result;

	return result;
}

</script>

{#await getAuthorListARXIV()}
    <LinearProgress indeterminate />
{:then data}
{data}

<div class="save-button">
    <Fab color="primary" on:click={() => { saveAuthorListFile(); }} extended>
        <Icon class="material-icons">save</Icon>
        <Label>DOWNLOAD</Label>
    </Fab>
</div>
{/await}

<style>
.save-button {
    position: absolute;
    bottom: 2vmin;
    right: 2vmin;
}
</style>