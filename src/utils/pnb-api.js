
import { auth, status, serviceURI, show_stop_and_warn } from '../store.js';
import { get } from 'svelte/store';

export const keepalive = async () => {
	if ( get(show_stop_and_warn) ) { return; }

try {
	const url = window.pnb.service + 'keepalive.php';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error"
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}

}

export const getEvent = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/events/get/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getDocument = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/documents/get/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getTask = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/tasks/get/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getInstitution = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/institutions/get/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getMember = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/members/get/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getGroup = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/groups/get/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getGroupRoles = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/groups/roles/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getTaskMembers = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/tasks/members/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getTaskGroups = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/tasks/groups/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getTaskInstitutions = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/tasks/institutions/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getInstitutionHistory = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/institutions/history/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getDocumentHistory = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/documents/history/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getTaskHistory = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/tasks/history/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getEventHistory = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/events/history/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getInstitutionsHistory = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/institutions/history';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getMemberHistory = async ( id ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/members/history/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getMembersHistory = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/members/history';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getInstitutions = async ( details = 'full' ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	// details: name, compact, full - TBD
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/institutions/list/status:' + get(status) + '/details:' + details;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getDocuments = async ( details = 'full', page = 0, rowsPerPage = 25 ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	// details: name, compact, full - TBD
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/documents/list/status:' + get(status) + '/details:' + details + '/page:' + page + '/rows-per-page:' + rowsPerPage;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getTasks = async ( details = 'full', page = 0, rowsPerPage = 25 ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	// details: name, compact, full - TBD
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/tasks/list/status:' + get(status) + '/details:' + details + '/page:' + page + '/rows-per-page:' + rowsPerPage;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getEvents = async ( details = 'full', page = 0, rowsPerPage = 25 ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	// details: name, compact, full - TBD
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/events/list/status:' + get(status) + '/details:' + details + '/page:' + page + '/rows-per-page:' + rowsPerPage;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getMembers = async ( details = 'full' ) => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	// details: name, compact, full
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/members/list/status:' + get(status) + '/details:' + details;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getGroups = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/groups/list/status:' + get(status);
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getInstitutionFields = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/list/object:fields/type:institutions';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getDocumentFields = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/list/object:fields/type:documents';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getTaskFields = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/list/object:fields/type:tasks';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getEventFields = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/list/object:fields/type:events';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getMemberFields = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/list/object:fields/type:members';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getInstitutionFieldgroups = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/list/object:fieldgroups/type:institutions';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: window.pnb && token ? { 'Authorization': 'Bearer ' + token } : {}
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getMemberFieldgroups = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/list/object:fieldgroups/type:members';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const getCountries = async () => {
	if ( get(show_stop_and_warn) ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/countries/list';
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createMemberField = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/create/object:fields/type:members';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createInstitutionField = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/create/object:fields/type:institutions';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createDocumentField = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/create/object:fields/type:documents';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createTaskField = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/create/object:fields/type:tasks';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createEventField = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/create/object:fields/type:events';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createMemberFieldgroup = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/create/object:fieldgroups/type:members';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createInstitutionFieldgroup = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/create/object:fieldgroups/type:institutions';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateMemberFields = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/modify/object:fields/type:members';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateMemberFieldgroups = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/modify/object:fieldgroups/type:members';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateInstitutionFields = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/modify/object:fields/type:institutions';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateDocumentFields = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/modify/object:fields/type:documents';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateTaskFields = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/modify/object:fields/type:tasks';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateEventFields = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/modify/object:fields/type:events';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateInstitutionFieldgroups = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/service/modify/object:fieldgroups/type:institutions';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateMember = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/members/update';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateInstitution = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/institutions/update';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : "" )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateDocument = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/documents/update';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : "" )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateTask = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/tasks/update';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : "" )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const updateEvent = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/events/update';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : "" )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}


export const updateGroup = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/groups/update';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : "" )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createEvent = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/events/create';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : "" )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createDocument = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/documents/create';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : "" )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createTask = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/tasks/create';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : "" )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createMember = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/members/create';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : "" )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createInstitution = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/institutions/create';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const createGroup = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !data ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/groups/create';
	const response = await fetch( url, {
		method: "POST",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
		headers: {
			"Content-Type": "application/json; charset=utf-8",
			"Authorization": ( token ? "Bearer " + token : '' )
		},
		body: JSON.stringify({ data })
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const toggleDocument = async ( id = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !id ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/documents/toggle/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const toggleTask = async ( id = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !id ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/tasks/toggle/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const toggleEvent = async ( id = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !id ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/events/toggle/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const toggleMember = async ( id = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !id ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/members/toggle/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const toggleInstitution = async ( id = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !id ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/institutions/toggle/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const toggleGroup = async ( id = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
	if ( !id ) { return; }
try {
	const token = get(auth)['token'];
	const url = serviceURI + '?q=/groups/toggle/id:' + id;
	const response = await fetch( url, {
		method: "GET",
		cache: "no-cache",
		credentials: "include",
		redirect: "error",
		mode: "cors",
        headers: {
            "Authorization": ( token ? "Bearer " + token : "" )
        }
	});
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
	return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const groupAddMember = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/groups/addmember';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const taskAddMember = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/tasks/addmember';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const taskAddInstitution = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/tasks/addinstitution';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const taskAddGroup = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/tasks/addgroup';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const groupRemoveMember = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/groups/removemember';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const taskRemoveMember = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/tasks/removemember';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const taskRemoveInstitution = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/tasks/removeinstitution';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const taskRemoveGroup = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/tasks/removegroup';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const groupAddRole = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/groups/addrole';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const groupRemoveRole = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/groups/removerole';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const groupUpdateRole = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/groups/updaterole';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}

export const groupUpdateMemberRole = async ( data = false ) => {
	if ( get(show_stop_and_warn) ) { return; }
    if ( !data ) { return; }
try {
    const token = get(auth)['token'];
    const url = serviceURI + '?q=/groups/updatememberrole';
    const response = await fetch( url, {
        method: "POST",
        cache: "no-cache",
        credentials: "include",
        redirect: "error",
        mode: "cors",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "Authorization": ( token ? "Bearer " + token : '' )
        },
        body: JSON.stringify({ data })
    });
	if ( response.status !== 200 ) {
		show_stop_and_warn.set(true);
		return;
	}
    return await response.json();
} catch ( error ) {
	show_stop_and_warn.set(true);
}
}
