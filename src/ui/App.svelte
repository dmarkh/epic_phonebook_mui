<script>

import {meta, router, Route} from 'tinro';

router.base( window.pnb.basepath );

switch ( window.pnb.router ) {
	case 'hash':
		router.mode.hash();
		break;
	case 'memory':
		router.mode.memory();
		break;
	default:
}

import { onMount } from 'svelte';
import { get } from 'svelte/store';
import { fade } from 'svelte/transition';
import { auth, status, screen, themeMode } from '../store.js';

import Drawer, { AppContent, Content, Subtitle } from '@smui/drawer';
import List, { Item, Text, Graphic, Separator, Subheader } from '@smui/list';
import TopAppBar, { Row, Section, Title } from '@smui/top-app-bar';
import IconButton from '@smui/icon-button';

import Menu from '@smui/menu';
import Button, { Label as ButtonLabel } from '@smui/button';

import Representatives from './Representatives.svelte';

import Group from './Group.svelte';
import Groups from './Groups.svelte';
import GroupNew from './GroupNew.svelte';

import Institution from './Institution.svelte';
import Institutions from './Institutions.svelte';
import InstitutionNew from './InstitutionNew.svelte';
import InstitutionsHistory from './InstitutionsHistory.svelte';

import InstitutionsFilter from './InstitutionsFilter.svelte';
import InstitutionsBulkImport from './InstitutionsBulkImport.svelte';
import InstitutionsBulkUpdate from './InstitutionsBulkUpdate.svelte';

import Member from './Member.svelte';
import Members from './Members.svelte';
import MemberNew from './MemberNew.svelte';
import MembersHistory from './MembersHistory.svelte';

import MembersFilter from './MembersFilter.svelte';
import MembersBulkImport from './MembersBulkImport.svelte';
import MembersBulkUpdate from './MembersBulkUpdate.svelte';

import MemberField from './MemberField.svelte';
import MemberFieldgroup from './MemberFieldgroup.svelte';
import MemberFields from './MemberFields.svelte';
import MemberFieldgroups from './MemberFieldgroups.svelte';

import Document from './Document.svelte';
import Documents from './Documents.svelte';
import DocumentField from './DocumentField.svelte';
import DocumentFields from './DocumentFields.svelte';
import DocumentNewField from './DocumentNewField.svelte';
import DocumentEditField from './DocumentEditField.svelte';
import DocumentNew from './DocumentNew.svelte';
import DocumentsFilter from './DocumentsFilter.svelte';

import Task from './Task.svelte';
import Tasks from './Tasks.svelte';
import TaskField from './TaskField.svelte';
import TaskFields from './TaskFields.svelte';
import TaskNewField from './TaskNewField.svelte';
import TaskEditField from './TaskEditField.svelte';
import TaskNew from './TaskNew.svelte';
import TasksFilter from './TasksFilter.svelte';

import Event from './Event.svelte';
import Events from './Events.svelte';
import EventField from './EventField.svelte';
import EventFields from './EventFields.svelte';
import EventNewField from './EventNewField.svelte';
import EventEditField from './EventEditField.svelte';
import EventNew from './EventNew.svelte';
import EventsFilter from './EventsFilter.svelte';

import InstitutionField from './InstitutionField.svelte';
import InstitutionFields from './InstitutionFields.svelte';
import InstitutionNewField from './InstitutionNewField.svelte';
import InstitutionEditField from './InstitutionEditField.svelte';

import InstitutionFieldgroup from './InstitutionFieldgroup.svelte';
import InstitutionFieldgroups from './InstitutionFieldgroups.svelte';
import InstitutionNewFieldgroup from './InstitutionNewFieldgroup.svelte';
import InstitutionEditFieldgroup from './InstitutionEditFieldgroup.svelte';

import MemberNewField from './MemberNewField.svelte';
import MemberNewFieldgroup from './MemberNewFieldgroup.svelte';
import MemberEditField from './MemberEditField.svelte';
import MemberEditFieldgroup from './MemberEditFieldgroup.svelte';

import WorldMap from './WorldMap.svelte';
import Stats from './Stats.svelte';

import AuthorLists from './AuthorLists.svelte';
import AuthLogin from './AuthLogin.svelte';
import NotFound from './NotFound.svelte';

import { keepalive } from '../utils/pnb-api.js';
import { show_stop_and_warn } from '../store.js';

let account_menu;
let keepalive_id = false;

show_stop_and_warn.subscribe( (val) => {
	if ( val === true ) {
		clearInterval(keepalive_id);
		keepalive_id = false;
	}
});

const toggleTheme = () => {
	if ( $themeMode === 'light' ) {
		$themeMode = 'dark';
	} else {
		$themeMode = 'light';
	}
}

let descriptors_open = false;

const doLogout = () => {
	$auth = { token: "", role: "", grants: {} };
	router.goto('/');
}

const toggleStatus = () => {
	$status = $status == 'active' ? 'inactive' : 'active';
}

onMount(() => {
	if ( !keepalive_id ) {
		keepalive_id = setInterval( async () => {
			if ( !$show_stop_and_warn ) {
				let data = await keepalive();
				console.log( 'keepalive: ' + JSON.stringify(data) );
			}
		}, window.pnb['keepalive-interval']*1000 );
	}
});

</script>


<svelte:head>
  {#if $themeMode === 'dark'}
    <link rel="stylesheet" href="smui-dark.css" />
  {:else}
    <link rel="stylesheet" href="smui.css" />
  {/if}
</svelte:head>

{#if $show_stop_and_warn}

<div class="dimmer"></div>
<div class="stop-and-warn flex-center">
	<p>PHONEBOOK: SESSION EXPIRED</p>
	<p>
		<Button on:click={() => { window.location.reload(); }} color="secondary" variant="raised">
        	<ButtonLabel>RELOAD PAGE</ButtonLabel>
    	</Button>
	</p>
</div>

{:else}

	<div id="viewport">

{#if !$auth['role']}

	<AuthLogin />

{:else}

	<div class="flexy">
		<div class="top-app-bar-container flexor">
			<TopAppBar variant="static" color="primary">
				<Row>
					<Section>
						<IconButton class="material-icons" on:click={() => { $screen = 'stats'; router.goto('/'); }}>menu</IconButton>
						<Title>{window.pnb.title}</Title>
					</Section>
					<Section align="end" toolbar>
					{#if $themeMode === 'light'}
						<IconButton class="material-icons" aria-label="Dark Mode" on:click={() => { toggleTheme(); }}>dark_mode</IconButton>
					{:else}
						<IconButton class="material-icons" aria-label="Light Mode" on:click={() => { toggleTheme(); }}>light_mode</IconButton>
					{/if}

					<IconButton class="material-icons" aria-label="Account" on:click={() => { account_menu.setOpen(true) }}>
						account_circle
						<Menu bind:this={account_menu} anchorCorner="BOTTOM_LEFT">
							<List>
								<Item>
									<Graphic class="material-icons" aria-hidden="true">person</Graphic>
									<Text>{$auth.user}</Text>
								</Item>
								<Item>
									<Graphic class="material-icons" aria-hidden="true">group</Graphic>
									<Text>{$auth.role}</Text>
								</Item>
								<Separator />
								<Item on:SMUI:action={() => ( doLogout() )}>
									<Graphic class="material-icons" aria-hidden="true">logout</Graphic>
									<Text>LOGOUT</Text>
								</Item>
								{#if $auth['grants']['members-edit']}
									{#if $status === 'active'}
										<Item on:SMUI:action={() => ( toggleStatus() )}>
											<Graphic class="material-icons" aria-hidden="true">toggle_on</Graphic>
											<Text>SHOW INACTIVE RECORDS</Text>
										</Item>
									{:else}
										<Item on:SMUI:action={() => ( toggleStatus() )}>
											<Graphic class="material-icons" aria-hidden="true">toggle_off</Graphic>
											<Text>SHOW ACTIVE RECORDS</Text>
										</Item>
									{/if}
								{/if}
								<Item>
									<Graphic class="material-icons" aria-hidden="true">construction</Graphic>
									<Text>BUILD: {window.pnb['build-date']}</Text>
								</Item>
							</List>
						</Menu>
					</IconButton>
					</Section>
				</Row>
			</TopAppBar>
			<div class="flexor-content">

		<div class="drawer-container">
			<Drawer color="secondary">
				<Content>
					<List>
						<Item href="/stats" on:click={() => { $screen = 'stats'; }} activated={$screen === 'stats'}>
								<Graphic class="material-icons" aria-hidden="true">query_stats</Graphic>
								<Text>STATISTICS</Text>
						</Item>
						<Item href="/representatives" on:click={() => { $screen = 'representatives'; }} activated={$screen === 'representatives'}>
								<Graphic class="material-icons" aria-hidden="true">group</Graphic>
								<Text>REPRESENTATIVES</Text>
						</Item>
						<Item href="/worldmap" on:click={() => { $screen = 'worldmap'; }} activated={$screen === 'worldmap'}>
							<Graphic class="material-icons" aria-hidden="true">map</Graphic>
							<Text>WORLD MAP</Text>
						</Item>
{#if $auth['grants']['authorlists-view']}
						<Item href="/authorlists" on:click={() => { $screen = 'authorlists'; }} activated={$screen === 'authorlists'}>
							<Graphic class="material-icons" aria-hidden="true">portrait</Graphic>
							<Text>AUTHOR LISTS</Text>
						</Item>
{/if}
						<Separator />
{#if $auth['grants']['institutions-view']}
						<details open>
						<summary class="mdc-deprecated-list-group__subheader">
							INSTITUTIONS
						</summary>
						<Item href="/institutions" on:click={() => { $screen = 'institutions'; }} activated={$screen === 'institutions' || $screen === 'institution' }>
							<Graphic class="material-icons" aria-hidden="true">public</Graphic>
							<Text>INSTITUTIONS</Text>
						</Item>
						<Item href="/filter-institutions" on:click={() => { $screen = 'institutionsfilter'; }} activated={$screen === 'institutionsfilter' }>
							<Graphic class="material-icons" aria-hidden="true">view_list</Graphic>
							<Text>FILTER INSTITUTIONS</Text>
						</Item>
	{#if $auth['grants']['institutions-create']}
						<Item href="/new-institution" on:click={() => { $screen = 'institutionnew'; }} activated={$screen === 'institutionnew' }>
							<Graphic class="material-icons" aria-hidden="true">add_circle</Graphic>
							<Text>ADD NEW INSTITUTION</Text>
						</Item>
	{/if}
	{#if $auth['grants']['institutions-history']}
						<Item href="/institutions-history" on:click={() => { $screen = 'institutionshistory'; }} activated={$screen === 'institutionshistory' }>
							<Graphic class="material-icons" aria-hidden="true">view_list</Graphic>
							<Text>INSTITUTIONS HISTORY</Text>
						</Item>
	{/if}
						</details>
						<Separator />
{/if}

{#if $auth['grants']['members-view']}
						<details open>
						<summary class="mdc-deprecated-list-group__subheader">
							MEMBERS
						</summary>
						<Item href="/members" on:click={() => { $screen = 'members'; }} activated={$screen === 'members' || $screen === 'member' }>
							<Graphic class="material-icons" aria-hidden="true">group</Graphic>
							<Text>MEMBERS</Text>
						</Item>
						<Item href="/filter-members" on:click={() => { $screen = 'membersfilter'; }} activated={$screen === 'membersfilter'}>
							<Graphic class="material-icons" aria-hidden="true">view_list</Graphic>
							<Text>FILTER MEMBERS</Text>
						</Item>
	{#if $auth['grants']['members-create']}
						<Item href="/new-member" on:click={() => { $screen = 'membernew'; }} activated={$screen === 'membernew'}>
							<Graphic class="material-icons" aria-hidden="true">add_circle</Graphic>
							<Text>ADD NEW MEMBER</Text>
						</Item>
	{/if}
	{#if $auth['grants']['members-history']}
						<Item href="/members-history" on:click={() => { $screen = 'membershistory'; }} activated={$screen === 'membershistory'}>
							<Graphic class="material-icons" aria-hidden="true">view_list</Graphic>
							<Text>MEMBERS HISTORY</Text>
						</Item>
	{/if}
						</details>
						<Separator />
{/if}

{#if $auth['grants']['groups-view']}
						<details open>
						<summary class="mdc-deprecated-list-group__subheader">
							GROUPS
						</summary>
						<Item href="/groups" on:click={() => { $screen = 'groups'; }} activated={$screen === 'groups' || $screen === 'group' }>
							<Graphic class="material-icons" aria-hidden="true">group</Graphic>
							<Text>GROUPS</Text>
						</Item>
	{#if $auth['grants']['groups-create']}
						<Item href="/new-group" on:click={() => { $screen = 'groupnew'; }} activated={$screen === 'groupnew'}>
							<Graphic class="material-icons" aria-hidden="true">add_circle</Graphic>
							<Text>ADD NEW GROUP</Text>
						</Item>
	{/if}
						</details>
						<Separator />
{/if}

{#if $auth['grants']['documents-view']}
						<details open>
						<summary class="mdc-deprecated-list-group__subheader">
							DOCUMENTS
						</summary>
						<Item href="/documents" on:click={() => { $screen = 'documents'; }} activated={$screen === 'documents' || $screen === 'documents' }>
							<Graphic class="material-icons" aria-hidden="true">group</Graphic>
							<Text>DOCUMENTS</Text>
						</Item>
						<Item href="/filter-documents" on:click={() => { $screen = 'documentsfilter'; }} activated={$screen === 'documentsfilter'}>
							<Graphic class="material-icons" aria-hidden="true">view_list</Graphic>
							<Text>FILTER DOCUMENTS</Text>
						</Item>
	{#if $auth['grants']['documents-create']}
						<Item href="/new-document" on:click={() => { $screen = 'documentnew'; }} activated={$screen === 'documentnew'}>
							<Graphic class="material-icons" aria-hidden="true">add_circle</Graphic>
							<Text>ADD NEW DOCUMENT</Text>
						</Item>
	{/if}
						</details>
						<Separator />
{/if}

{#if $auth['grants']['tasks-view']}
						<details open>
						<summary class="mdc-deprecated-list-group__subheader">
							TASKS
						</summary>
						<Item href="/tasks" on:click={() => { $screen = 'tasks'; }} activated={$screen === 'tasks' }>
							<Graphic class="material-icons" aria-hidden="true">task</Graphic>
							<Text>TASKS</Text>
						</Item>
						<Item href="/filter-tasks" on:click={() => { $screen = 'tasksfilter'; }} activated={$screen === 'tasksfilter'}>
							<Graphic class="material-icons" aria-hidden="true">view_list</Graphic>
							<Text>FILTER TASKS</Text>
						</Item>
	{#if $auth['grants']['tasks-create']}
						<Item href="/new-task" on:click={() => { $screen = 'tasknew'; }} activated={$screen === 'tasknew'}>
							<Graphic class="material-icons" aria-hidden="true">add_task</Graphic>
							<Text>ADD NEW TASK</Text>
						</Item>
	{/if}
						</details>
						<Separator />
{/if}

{#if $auth['grants']['events-view']}
						<details open>
						<summary class="mdc-deprecated-list-group__subheader">
							EVENTS
						</summary>
						<Item href="/events" on:click={() => { $screen = 'events'; }} activated={$screen === 'events' || $screen === 'events' }>
							<Graphic class="material-icons" aria-hidden="true">group</Graphic>
							<Text>EVENTS</Text>
						</Item>
						<Item href="/filter-events" on:click={() => { $screen = 'eventsfilter'; }} activated={$screen === 'eventsfilter'}>
							<Graphic class="material-icons" aria-hidden="true">view_list</Graphic>
							<Text>FILTER EVENTS</Text>
						</Item>
	{#if $auth['grants']['events-create']}
						<Item href="/new-event" on:click={() => { $screen = 'eventnew'; }} activated={$screen === 'eventnew'}>
							<Graphic class="material-icons" aria-hidden="true">add_circle</Graphic>
							<Text>ADD NEW EVENT</Text>
						</Item>
	{/if}
						</details>
						<Separator />
{/if}

{#if $auth['grants']['descriptors-view']}
						<details open>
						<summary class="mdc-deprecated-list-group__subheader">
							DESCRIPTORS
						</summary>
						<Item href="/institution-fields" on:click={() => { $screen = 'institutionfields'; }} activated={$screen === 'institutionfields'}>
							<Graphic class="material-icons" aria-hidden="true">add</Graphic>
							<Text>INSTITUTION FIELDS</Text>
						</Item>
						<Item href="/member-fields" on:click={() => { $screen = 'memberfields'; }} activated={$screen === 'memberfields'}>
							<Graphic class="material-icons" aria-hidden="true">add</Graphic>
							<Text>MEMBER FIELDS</Text>
						</Item>
						<Item href="/institution-field-groups" on:click={() => { $screen = 'institutionfieldgroups'; }} activated={$screen === 'institutionfieldgroups'}>
							<Graphic class="material-icons" aria-hidden="true">add</Graphic>
							<Text>INSTITUTION FIELDGROUPS</Text>
						</Item>
						<Item href="/member-field-groups" on:click={() => { $screen = 'memberfieldgroups'; }} activated={$screen === 'memberfieldgroups'}>
							<Graphic class="material-icons" aria-hidden="true">add</Graphic>
							<Text>MEMBER FIELDGROUPS</Text>
						</Item>
						<Item href="/document-fields" on:click={() => { $screen = 'documentfields'; }} activated={$screen === 'documentfields'}>
							<Graphic class="material-icons" aria-hidden="true">add</Graphic>
							<Text>DOCUMENT FIELDS</Text>
						</Item>
						<Item href="/task-fields" on:click={() => { $screen = 'taskfields'; }} activated={$screen === 'taskfields'}>
							<Graphic class="material-icons" aria-hidden="true">add</Graphic>
							<Text>TASK FIELDS</Text>
						</Item>
						<Item href="/event-fields" on:click={() => { $screen = 'eventfields'; }} activated={$screen === 'eventfields'}>
							<Graphic class="material-icons" aria-hidden="true">add</Graphic>
							<Text>EVENT FIELDS</Text>
						</Item>
						</details>
						<Separator />
{/if}
					</List>
				</Content>
			</Drawer>
			<AppContent class="app-content">
				<main class="main-content">
					{#key $status}
					<Route path="/"> <Stats /> </Route>
					<Route path="/stats"> <Stats /> </Route>
					<Route path="/representatives"> <Representatives /> </Route>
					<Route path="/worldmap"> <WorldMap /> </Route>
					<Route path="/authorlists/*" let:meta> <AuthorLists {meta} /> </Route>

					<Route path="/documents"> <Documents /> </Route>
					<Route path="/document/:id/*" let:meta> <Document {meta} /> </Route>
					<Route path="/new-document"> <DocumentNew /> </Route>
					<Route path="/document-field/:id/*" let:meta> <DocumentField {meta} /> </Route>
					<Route path="/document-fields"> <DocumentFields /> </Route>
					<Route path="/document-new-field"> <DocumentNewField /> </Route>
					<Route path="/document-edit-field/:id/*" let:meta> <DocumentEditField {meta} /> </Route>
					<Route path="/filter-documents"> <DocumentsFilter /> </Route>

					<Route path="/tasks"> <Tasks /> </Route>
					<Route path="/task/:id/*" let:meta> <Task {meta} /> </Route>
					<Route path="/new-task"> <TaskNew /> </Route>
					<Route path="/task-field/:id/*" let:meta> <TaskField {meta} /> </Route>
					<Route path="/task-fields"> <TaskFields /> </Route>
					<Route path="/task-new-field"> <TaskNewField /> </Route>
					<Route path="/task-edit-field/:id/*" let:meta> <TaskEditField {meta} /> </Route>
					<Route path="/filter-tasks"> <TasksFilter /> </Route>

					<Route path="/events"> <Events /> </Route>
					<Route path="/event/:id/*" let:meta> <Event {meta} /> </Route>
					<Route path="/new-event"> <EventNew /> </Route>
					<Route path="/event-field/:id/*" let:meta> <EventField {meta} /> </Route>
					<Route path="/event-fields"> <EventFields /> </Route>
					<Route path="/event-new-field"> <EventNewField /> </Route>
					<Route path="/event-edit-field/:id/*" let:meta> <EventEditField {meta} /> </Route>
					<Route path="/filter-events"> <EventsFilter /> </Route>

					<Route path="/new-institution"> <InstitutionNew /> </Route>
					<Route path="/institution/:id/*" let:meta> <Institution {meta} /> </Route>
					<Route path="/institution-edit-field/:id/*" let:meta> <InstitutionEditField {meta} /> </Route>
					<Route path="/institution-edit-fieldgroup/:id/*" let:meta> <InstitutionEditFieldgroup {meta} /> </Route>
					<Route path="/institutions"> <Institutions /> </Route>
					<Route path="/institutions-history"> <InstitutionsHistory /> </Route>
					<Route path="/institutions-bulk-import"> <InstitutionsBulkImport /> </Route>
					<Route path="/institutions-bulk-update"> <InstitutionsBulkUpdate /> </Route>
					<Route path="/filter-institutions"> <InstitutionsFilter /> </Route>
					<Route path="/institution-fields"> <InstitutionFields /> </Route>
					<Route path="/institution-field-groups"> <InstitutionFieldgroups /> </Route>
					<Route path="/institution-new-field"> <InstitutionNewField /> </Route>
					<Route path="/institution-new-fieldgroup"> <InstitutionNewFieldgroup /> </Route>
					<Route path="/institution-field/:id/*" let:meta> <InstitutionField {meta} /> </Route>
					<Route path="/institution-fieldgroup/:id/*" let:meta> <InstitutionFieldgroup {meta} /> </Route>

					<Route path="/new-member"> <MemberNew /> </Route>
					<Route path="/member/:id/*" let:meta> <Member {meta} /> </Route>
					<Route path="/member-edit-field/:id/*" let:meta> <MemberEditField {meta} /> </Route>
					<Route path="/member-edit-fieldgroup/:id/*" let:meta> <MemberEditFieldgroup {meta} /> </Route>
					<Route path="/members"> <Members /> </Route>
					<Route path="/members-history"> <MembersHistory /> </Route>
					<Route path="/members-bulk-import"> <MembersBulkImport /> </Route>
					<Route path="/members-bulk-update"> <MembersBulkUpdate /> </Route>
					<Route path="/filter-members"> <MembersFilter /> </Route>
					<Route path="/member-fields"> <MemberFields /> </Route>
					<Route path="/member-field-groups"> <MemberFieldgroups /> </Route>
					<Route path="/member-new-field"> <MemberNewField /> </Route>
					<Route path="/member-new-fieldgroup"> <MemberNewFieldgroup /> </Route>
					<Route path="/member-field/:id/*" let:meta> <MemberField {meta} /> </Route>
					<Route path="/member-fieldgroup/:id/*" let:meta> <MemberFieldgroup {meta} /> </Route>

					<Route path="/groups"> <Groups /> </Route>
					<Route path="/new-group"> <GroupNew /> </Route>
					<Route path="/group/:id/*" let:meta> <Group {meta} /> </Route>

					{/key}
				</main>
			</AppContent>
		</div>

			</div>
		</div>
	</div>
{/if}
	</div>

{/if}

<style>

  .top-app-bar-container {
    width: 100%;
    overflow: auto;
    display: inline-block;
  }

  .flexy {
    display: flex;
    flex-wrap: wrap;
	width: 100vw;
	height: 100vh;
	overflow: hidden;
  }

  .flexor {
    display: inline-flex;
    flex-direction: column;
	overflow: hidden;
  }

  .drawer-container {
    position: relative;
    display: flex;
    height: calc(100vh - 64px);
    width: 100vw;
    border: 1px solid var(--mdc-theme-text-hint-on-background, rgba(0, 0, 0, 0.1));
    overflow: hidden;
    z-index: 0;
  }

  * :global(.app-content) {
    flex: auto;
    overflow: auto;
    position: relative;
    flex-grow: 1;
  }


  .main-content {
    overflow: auto;
    padding: 16px;
    height: 100%;
    box-sizing: border-box;
  }

  .dimmer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #000C;
  }

  .stop-and-warn {
	position: absolute;
	width: 50vmin;
	height: 30vmin;
	top: 50%;
	left: 50%;
	transform: translate(-50%,-50%);
	background-color: #F99;
	color: #000;
	font-size: 2vmin;
	padding: 2vmin;
	border-radius: 2vmin;
	outline: 0.5vmin solid #FFF;
  }

 .flex-center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
 }

</style>