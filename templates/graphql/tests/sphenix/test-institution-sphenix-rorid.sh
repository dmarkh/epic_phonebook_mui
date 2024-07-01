#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url https://phonebook.sdcc.bnl.gov/graphql/sphenix/ \
    --data '{ "query": "query { institution(rorid: \"https://ror.org/02ex6cf31\") {id,ror_id,name_full,name_short} }" }' | json_reformat
