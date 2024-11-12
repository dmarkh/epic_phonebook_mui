#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url http://127.0.0.1/phonebook-mui/client/graphql/index.php \
    --data '{ "query": "query { members{id,name_first,name_last,email,institution{id,name_full,name_short},groups{name,category,role}} }" }' | json_reformat
