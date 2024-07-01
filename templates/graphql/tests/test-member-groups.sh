#!/bin/sh

curl -s \
    --header "Content-Type: application/json" \
    --request POST \
    --url http://127.0.0.1/phonebook-mui/client/graphql/index.php \
    --data '{ "query": "query { member(orcid: \"8888-8888-8888-8888\") {id,orcid_id,name_first,name_last,email,groups{name,category,role},institution{id,ror_id,name_full,name_short}} }" }' | json_reformat
