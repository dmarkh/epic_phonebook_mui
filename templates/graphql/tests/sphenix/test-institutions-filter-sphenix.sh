#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url https://phonebook.sdcc.bnl.gov/graphql/sphenix/ \
    --data '{ "query": "query { institutions{id,name_full,name_short,members{id,name_first,name_last,email}} }", "variables": { "filters": [ { "field": "name_full", "op": "contains", "val": "laboratory" } ] } }' | json_reformat
