#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url https://phonebook.sdcc.bnl.gov/graphql/ePIC/ \
    --data '{ "query": "query { members{id,orcid_id,name_first,name_last,email,institution{id,ror_id,name_full,name_short}} }" }' | json_reformat
