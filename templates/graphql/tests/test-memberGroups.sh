#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url http://127.0.0.1/phonebook-mui/client/graphql/index.php \
    --data '{ "query": "query { memberGroups(orcid: \"1234-1234-1234-1234\") {name,category,role} }" }' | json_reformat
