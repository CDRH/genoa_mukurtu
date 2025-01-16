
A couple initial things to try when troubleshooting Mukurtu are restarting
Apache and running `drush cc all`. Beyond that, one must look for hints in
Apache logs and in output from the dblog module with `drush watchdog:show`.

## Search API Facet Errors

Soon after we had disabled the dblog module, we saw errors on any page
interacting with items from the database. After re-enabling the dblog module,
we saw this error message:

```
Error: Class name must be a valid object or a string in
FacetapiAdapter->getFacetSettingsGlobal()
```

Web searches led to trying `drush search-api-index search` which showed:

```
Invalid index_id or no indexes present. Listing all indexes: [error]

 Id  Name                Index               Server                Type  Status   Limit 
 8   Default node index  default_node_index  Search API DB Server  Node  enabled  50
```

But no clear remedy was found.

All admin pages seemed to work, but digging into search-related pages eventually
found one that was erroring: Configuration > Search and metadata > Search API >
Default node index > Facets (tab in upper right),
i.e. `/admin/config/search/search_api/index/default_node_index/facets`

Upon re-enabling dblog to see if this page was producing different error
messages than others, the page then no longer failed to load with an error.
After this, the original problem could no longer be recreated either.
Seems like code that runs for this page load fixed the problem.
