#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url https://phonebook.sdcc.bnl.gov/graphql/star/ \
    --data '{ "query": "query { members{id,name_first,name_last,email,institution{id,name_full,name_short}} }", "variables": { "filters": [ { "field": "name_first", "op": "fuzzy", "val": "tomas" } ] } }' | json_reformat
