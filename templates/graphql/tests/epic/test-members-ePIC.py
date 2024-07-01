import requests
import json

url = "https://phonebook.sdcc.bnl.gov/graphql/ePIC/"
body = """
{
  members{ id, orcid_id, name_first, name_last, email
    institution{ id, ror_id, name_full, name_short }
  }
}
"""
response = requests.post(url=url, json={"query": body}) 
if response.status_code == 200:
    print( json.dumps(response.json()) )
