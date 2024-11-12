#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url http://127.0.0.1/phonebook-mui/client/graphql/index.php \
    --data '{ "query": "query { institution(rorid: \"5\") {id,ror_id,name_full,name_short} }" }' | json_reformat
