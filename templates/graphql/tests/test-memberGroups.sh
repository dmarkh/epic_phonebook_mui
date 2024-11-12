#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url http://127.0.0.1/phonebook-mui/client/graphql/index.php \
    --data '{ "query": "query { memberGroups(orcid: \"0009-0004-6729-4397\") {name,category,role} }" }' | json_reformat
