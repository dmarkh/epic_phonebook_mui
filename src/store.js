
import { writable } from 'svelte/store';
import { get } from 'svelte/store';
import localForage from 'localforage';

export const screen = writable('stats');
export const themeMode = writable('light');
export const serviceURI = window.pnb.service; // 'https://127.0.0.1/phonebook-mui/service/';

export const member_id = writable(false);
export const institution_id = writable(false);

export const status = writable('active'); // active, inactive

export const institution_mode = writable('view'); // view, history, edit
export const member_mode = writable('view'); // view, history, edit

export const auth = writable(
	{ token: "", role: "", grants: {} }
);