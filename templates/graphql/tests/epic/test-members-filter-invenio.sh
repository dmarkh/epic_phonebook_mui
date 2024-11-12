#!/bin/sh

query='{ "query": "query { members{id,name_first,name_last,email,institution{id,name_full,name_short},groups{name,category,role},igroups{name,category,role}} }","variables": { "filters": [ { "field": "name_last", "op": "fuzzy", "val": "Steinberg" } ] } }'

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url https://phonebook.sdcc.bnl.gov/graphql/ePIC/ \
    --data "$query" | json_reformat
