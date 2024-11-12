#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url https://phonebook.sdcc.bnl.gov/graphql/ePIC/ \
    --data '{ "query": "query { memberGroups(orcid: \"0009-0004-6729-4397\") {name,category,role}, invenioGroups(orcid: \"0009-0004-6729-4397\") {name,category,role} }" }' | json_reformat
