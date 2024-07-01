#!/bin/sh

curl -s \
	--header "Content-Type: application/json" \
	--request POST \
	--url http://127.0.0.1/phonebook-mui/client/graphql/index.php \
	--data '{ "query": "{ __schema { types { kind, name, possibleTypes { name } } } }" }' | json_reformat
