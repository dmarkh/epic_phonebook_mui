<script>
import Snackbar, { Label as SnackbarLabel, Actions as SnackbarActions } from '@smui/snackbar';
import IconButton from '@smui/icon-button';
import Paper from '@smui/paper';
import Button, { Label as ButtonLabel } from '@smui/button';
import Textfield from '@smui/textfield';
import Icon from '@smui/textfield/icon';
import LinearProgress from '@smui/linear-progress';

import { auth } from '../store.js';
import { sleep } from '../utils/sleep.js';
import { authenticate } from '../utils/authenticate.js';

let login = '',
	pass  = '',
	pass_visibility = false,
	logging_in = false;

let snackbarError;

const useGuestAccess = async () => {
	logging_in = true;

	let data = await authenticate('guest', 'guest');
	if ( data.token && data.grants && data.role ) {
		$auth = { ...data, user: 'guest' };
	} else {
		snackbarError.open()
	}

	logging_in = false;
}

const togglePassVisibility = () => {
	pass_visibility = !pass_visibility;
}

const doLogin = async () => {

	logging_in = true;

	let data = await authenticate( login, pass );
	if ( data.token && data.grants && data.role ) {
		$auth = { ...data, user: login };
	} else {
		snackbarError.open()
	}

	logging_in = false;
}

</script>

<div class="pnb-auth-wrapper">
	{#if !logging_in}
		<div class="pnb-auth-container">
			<Paper color="primary" style="text-align: center;" elevation={8}>
				<div style="text-align: center; padding: 5vmin;" class="mdc-typography--headline5">
					{window.pnb.title}
				</div>
				<p style="text-align: center;">
					<Textfield variant="filled" bind:value={login} label="LOGIN" style="width: 80%;">
						<Icon class="material-icons" slot="leadingIcon">account_circle</Icon>
					</Textfield>
				</p>
				<p style="text-align: center;">
					{#if pass_visibility === true }
						<Textfield variant="filled" bind:value={pass} label="PASSWORD" style="width: 80%;">
							<Icon class="material-icons" slot="leadingIcon">key</Icon>
							<Icon class="material-icons" slot="trailingIcon" on:click={() => { togglePassVisibility(); }}>visibility_off</Icon>
						</Textfield>
					{:else}
						<Textfield variant="filled" bind:value={pass} type="password" label="PASSWORD" style="width: 80%;">
							<Icon class="material-icons" slot="leadingIcon">key</Icon>
							<Icon class="material-icons" slot="trailingIcon" on:click={() => { togglePassVisibility(); }}>visibility</Icon>
						</Textfield>
					{/if}
				</p>
				<p>
					<Button on:click={ async () => { await doLogin(); }} color="secondary" variant="raised">
						<ButtonLabel>LOGIN</ButtonLabel>
					</Button>
				</p>
			</Paper>
			{#if window.pnb['allow-guest-access']}
				<br />
				<Paper color="primary" style="text-align: center;" elevation={8}>
					<div>
						<Button on:click={() => { useGuestAccess(); }} color="secondary" variant="raised">
							<ButtonLabel>USE GUEST ACCESS</ButtonLabel>
						</Button>
					</div>
				</Paper>
			{/if}
		</div>
	{:else}
		<div class="pnb-auth-container">
			<Paper color="primary" style="text-align: center;" elevation={8}>
				<div style="text-align: center; padding: 5vmin;" class="mdc-typography--headline5">
					PLEASE WAIT
				</div>
				<LinearProgress indeterminate />
			</Paper>
		</div>
	{/if}

<Snackbar bind:this={snackbarError}>
  <SnackbarLabel>
	AUTHENTICATION FAILED. TRY AGAIN.
  </SnackbarLabel>
  <SnackbarActions>
    <IconButton class="material-icons" title="Dismiss">close</IconButton>
  </SnackbarActions>
</Snackbar>

</div>

<style>
.pnb-auth-wrapper {
	position: absolute;
	top: 0; left: 0;
	width: 100vw;
	height: 100vh;
	border: 0;
	margin: 0;
	padding: 0;
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	background-color: #777;
}

.pnb-auth-container {
	min-width: 400px;
}

</style>