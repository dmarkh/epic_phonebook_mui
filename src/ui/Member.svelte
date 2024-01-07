<script>

import { afterUpdate } from 'svelte';
import {router, Route} from 'tinro';

import Tab, { Icon, Label } from '@smui/tab';
import TabBar from '@smui/tab-bar';
import Button from '@smui/button';
import Paper, { Content } from '@smui/paper';

import { auth } from '../store.js';
import { member_id, member_mode } from '../store.js';

import MemberHistory from './MemberHistory.svelte';
import MemberView from './MemberView.svelte';
import MemberEdit from './MemberEdit.svelte';

export let meta;

let tabs = [
    { "label": "view", "icon": "view_list", "mode": "/view" }
];

if ( $auth['grants']['members-edit'] ) {
	tabs = [ ...tabs,
    	{ "label": "edit", "icon": "edit", "mode": "/edit" }
	];
}
if ( $auth['grants']['members-history'] ) {
	tabs = [ ...tabs,
    	{ "label": "history", "icon": "history", "mode": "/history" }
	];
}

let active = tabs.find( t => meta.url.endsWith( t.mode ) ) || tabs[0];
if ( meta.params.id ) {
    $member_id = meta.params.id;
}
const tab_change = (t) => {
	if ( t ) {
	    router.goto('/member/' + meta.params.id + t.mode);
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

    <Route path="/view"> <MemberView /> </Route>
    <Route path="/edit"> <MemberEdit /> </Route>
    <Route path="/history"> <MemberHistory /> </Route>

    <Route fallback> <MemberView /> </Route>
<style>

</style>