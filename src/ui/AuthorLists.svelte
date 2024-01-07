<script>

import { afterUpdate } from 'svelte';
import {router,Route} from 'tinro';

import Tab, { Icon, Label } from '@smui/tab';
import TabBar from '@smui/tab-bar';
import Button from '@smui/button';
import Paper, { Content } from '@smui/paper';

import AccessDenied from './AccessDenied.svelte';
import AuthorListsAPS from './AuthorListsAPS.svelte';
import AuthorListsARXIV from './AuthorListsARXIV.svelte';
import AuthorListsIOP from './AuthorListsIOP.svelte';

import { auth } from '../store.js';

export let meta;

let tabs = [
    { "label": "LaTeX APS", "icon": "view_list", "mode": "/aps" },
    { "label": "LaTeX IOP", "icon": "view_list", "mode": "/iop" },
    { "label": "ARXIV", "icon": "view_list", "mode": "/arxiv" }
];

let active = tabs.find( t => meta.url.endsWith( t.mode ) ) || tabs[0];
const tab_change = (t) => {
	if ( t ) {
		router.goto( '/authorlists' + t.mode );
	}
}

afterUpdate( () => {
    active = tabs.find( t => meta.url.endsWith( t.mode ) ) || tabs[0];
});

</script>

{#if $auth['grants']['authorlists-view']}
<TabBar tabs={tabs} let:tab bind:active>
    <Tab {tab} on:click={() => tab_change(tab)}>
        <Icon class="material-icons">{tab.icon}</Icon>
        <Label>{tab.label}</Label>
    </Tab>
</TabBar>

<Paper>
	<Route path="/aps"> <AuthorListsAPS /> </Route>
	<Route path="/arxiv"> <AuthorListsARXIV /> </Route>
	<Route path="/iop"> <AuthorListsIOP /> </Route>
	<Route fallback> <AuthorListsAPS /> </Route>
</Paper>
{:else}
	<AccessDenied />
{/if}

