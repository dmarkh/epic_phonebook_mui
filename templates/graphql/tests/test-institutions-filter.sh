#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url http://127.0.0.1/phonebook-mui/client/graphql/index.php \
    --data '{ "query": "query { institutions{id,name_full,name_short,members{id,name_first,name_last,email}} }", "variables": { "filters": [ { "field": "name_full", "op": "contains", "val": "laboratory" } ] } }' | json_reformat
