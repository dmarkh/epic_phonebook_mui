<script>

import {meta, router, Route} from 'tinro';

import MemberEditComponent from './MemberEditComponent.svelte';
import AccessDenied from './AccessDenied.svelte';
import PleaseWait from './PleaseWait.svelte';

import { screen } from '../store.js';

import { createMember } from '../utils/pnb-api.js';
import { sleep } from '../utils/sleep.js';
import { auth } from '../store.js';

let pleaseWait = false;

const recordUpdated = async ( memberId, changes, field_values ) => {
    pleaseWait = 'ADDING NEW MEMBER, PLEASE WAIT';

    let data = {
        "status": "active",
        "fields": Object.fromEntries(Object.entries( field_values ).filter(([_, v]) => v !== '' && v !== undefined && v !== null ))
    };
    let rc = await createMember( data );
    await sleep(1000);
    $screen = 'members';

    if ( rc ) {
        router.goto('/member/' + rc.id + '/view' );
    }

    pleaseWait = false;
}

</script>

{#if $auth['grants']['members-edit']}
	<MemberEditComponent memberId={false} institutionId={false} recordUpdated={recordUpdated} />
	{#if pleaseWait}
    	<PleaseWait text="{pleaseWait}" />
	{/if}
{:else}
	<AccessDenied />
{/if}
