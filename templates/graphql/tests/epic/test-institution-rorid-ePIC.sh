#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url https://phonebook.sdcc.bnl.gov/graphql/ePIC/ \
    --data '{ "query": "query { institution(rorid: \"https://ror.org/05qghxh33\") {id,ror_id,name_full,name_short} }" }' | json_reformat
