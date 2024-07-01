#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url https://phonebook.sdcc.bnl.gov/graphql/sphenix/ \
    --data '{ "query": "query { member(orcid: \"0000-0002-7952-918X\") {id,orcid_id,name_first,name_last,email,institution{id,ror_id,name_full,name_short}} }" }' | json_reformat
