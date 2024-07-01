<script>

import { writable } from 'svelte/store';
import { onDestroy } from 'svelte';

import {router, Route} from 'tinro';

import DataTable, { Head, Body, Row, Cell, Label, SortValue, Pagination } from '@smui/data-table';
import IconButton from '@smui/icon-button';
import Button, { Label as ButtonLabel, Icon as ButtonIcon } from '@smui/button';
import Select, { Option } from '@smui/select';
import LinearProgress from '@smui/linear-progress';
import Paper from '@smui/paper';

import AccessDenied from './AccessDenied.svelte';

import { getDocuments, getDocumentFields } from '../utils/pnb-api.js';
import { convertDocuments } from '../utils/pnb-convert.js';
import { screen, document_id, document_mode } from '../store.js';
import { auth } from '../store.js';

import Textfield from '@smui/textfield';
import Icon from '@smui/textfield/icon';
import HelperText from '@smui/textfield/helper-text';

let items = [];
let filteredItems = [];

let sort = 'name';
let sortDirection = 'ascending';

let currentPage = 0;
let rowsPerPage = 25;

$: start = currentPage * rowsPerPage;
$: end   = start + rowsPerPage;
$: slice = items.slice( start, end );
$: lastPage = Math.max(Math.ceil( items.length / rowsPerPage) - 1, 0);

$: if (currentPage > lastPage) {
	currentPage = lastPage;
}

const downloadDocuments = async () => {
    let docs = await getDocuments( 'full', currentPage, rowsPerPage );
    let items = await convertDocuments( docs );
	slice = items.slice(currentPage,rowsPerPage);
    return slice;
}

const handleRowClick = ( e ) => {
	$document_mode = 'view';
	$document_id = e.target.dataset.entryId;
	$screen = 'document';
	router.goto('/document/' + $document_id + '/view');
}

onDestroy(() => {});

</script>

{#if $auth['grants']['documents-view']}

<div style="text-align: center;" class="mdc-typography--headline4">DOCUMENTS</div>

{#await downloadDocuments()}

<LinearProgress indeterminate />

{:then}

<Paper>
<DataTable table$aria-label="Institution List" style="width: 100%;"
  on:SMUIDataTableRow:click={handleRowClick}
>
	<Head>
		<Row>
			{#each window.pnb.documents as doc}
			<Cell columnId="name_full" style="text-align: {doc.align}; width: {doc.width};">
				<Label>{doc.title}</Label>
			</Cell>
			{/each}
		</Row>
	</Head>
	<Body>
    {#each slice as item (item.id)}
      <Row data-entry-id="{item.id}">
		{#each window.pnb.documents as doc}
        <Cell style="text-align: {doc.align}; width: {doc.width};">
			{item[ doc.field ] || ''}
		</Cell>
		{/each}
      </Row>
    {/each}
	</Body>
  <Pagination slot="paginate">
    <svelte:fragment slot="rowsPerPage">
      <Label>Rows Per Page</Label>
      <Select variant="outlined" bind:value={rowsPerPage} noLabel>
        <Option value={10}>10</Option>
        <Option value={25}>25</Option>
        <Option value={100}>100</Option>
      </Select>
    </svelte:fragment>
    <svelte:fragment slot="total">
      {start + 1}-{end} of {items.length}
    </svelte:fragment>

    <IconButton
      class="material-icons"
      action="first-page"
      title="First page"
      on:click={() => (currentPage = 0)}
      disabled={currentPage === 0}>first_page</IconButton
    >
    <IconButton
      class="material-icons"
      action="prev-page"
      title="Prev page"
      on:click={() => currentPage--}
      disabled={currentPage === 0}>chevron_left</IconButton
    >
    <IconButton
      class="material-icons"
      action="next-page"
      title="Next page"
      on:click={() => currentPage++}
      disabled={currentPage === lastPage}>chevron_right</IconButton
    >
    <IconButton
      class="material-icons"
      action="last-page"
      title="Last page"
      on:click={() => (currentPage = lastPage)}
      disabled={currentPage === lastPage}>last_page</IconButton
    >
  </Pagination>

</DataTable>
</Paper>
{/await}

{:else}
	<AccessDenied />
{/if}

<style>

</style>