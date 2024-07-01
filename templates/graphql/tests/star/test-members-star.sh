#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url https://phonebook.sdcc.bnl.gov/graphql/star/ \
    --data '{ "query": "query { members{id,name_first,name_last,email,orcid_id} }" }' | json_reformat
