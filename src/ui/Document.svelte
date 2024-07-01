<script>

import { afterUpdate } from 'svelte';
import {router, Route} from 'tinro';

import Tab, { Icon, Label } from '@smui/tab';
import TabBar from '@smui/tab-bar';
import Button from '@smui/button';
import Paper, { Content } from '@smui/paper';

import DocumentHistory from './DocumentHistory.svelte';
import DocumentEdit from './DocumentEdit.svelte';
import DocumentView from './DocumentView.svelte';
import DocumentNew from './DocumentNew.svelte';

import { auth } from '../store.js';
import { document_id, document_mode } from '../store.js';

export let meta;

let tabs = [
	{ "label": "view", "icon": "view_list", "mode": "/view" },
];

if ( $auth['grants']['documents-edit'] ) {
	tabs = [ ...tabs,
		{ "label": "edit", "icon": "edit", "mode": "/edit" }
	];
}
if ( $auth['grants']['documents-history'] ) {
	tabs = [ ...tabs,
		{ "label": "history", "icon": "history", "mode": "/history" }
	];
}

let active = tabs.find( t => meta.url.endsWith( t.mode ) ) || tabs[0];
if ( meta.params.id ) {
	$document_id = meta.params.id;
}

const tab_change = (t) => {
	if ( t ) {
		router.goto('/document/' + meta.params.id + t.mode);
	}
}

afterUpdate( () => {
	active = tabs.find( t => meta.url.endsWith( t.mode ) ) || tabs[0];
});

</script>

<TabBar tabs={tabs} let:tab bind:active>
	<Tab {tab} on:click={() => tab_change(tab)}>
		<Icon class="material-icons">{tab.icon}</Icon>
		<Label>{tab.label}</Label>
	</Tab>
</TabBar>

	<Route path="/view"> <DocumentView /> </Route>
	<Route path="/edit"> <DocumentEdit /> </Route>
	<Route path="/history"> <DocumentHistory /> </Route>

	<Route fallback> <DocumentView /> </Route>

<style>

</style>