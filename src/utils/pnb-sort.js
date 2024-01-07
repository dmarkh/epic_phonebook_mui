
export const sortConvertedInstitutions = ( items ) => {
	items.sort( ( a, b ) => {
        const nameA = a.name_full.toLowerCase();
        const nameB = b.name_full.toLowerCase();
        if ( nameA < nameB ) { return -1; }
        else if (nameA > nameB) { return 1; }
        return 0;
    });
}

export const sortConvertedMembers = ( items ) => {
	items.sort( ( a, b ) => {
        const nameA = a.name_last.toLowerCase();
        const nameB = b.name_last.toLowerCase();
        if ( nameA < nameB ) { return -1; }
        else if (nameA > nameB) { return 1; }
		const lnameA = a.name_first.toLowerCase();
		const lnameB = b.name_first.toLowerCase();
		if ( lnameA < lnameB ) { return -1; }
		else if ( lnameA > lnameB ) { return 1; }
        return 0;
    });
}

