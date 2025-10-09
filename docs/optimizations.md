# Drupal and Mukurtu Optimizations

View execution time and memory usage for each page load:<br>
Admin Menu > Configuration > Development > Devel settings

Check "Display page timer" and "Display memory usage"

Click "Save configuration"

## Page Caching and CSS/JS Aggregation
Admin Menu > Configuration > Development > Performance

**Caching**

Check the box to "Cache pages for anonymous users"

Set "Minimum cache lifetime" to 1 hour

Set "Expiration of cached pages" to 1 day

**Bandwidth Optimization**

Check all the boxes here

These changes provide a noticeable performance improvement for guest viewing!

## dblog Module

This module was previously known as "watchdog" and its database table is still
named that. It is enabled by default to capture all website logging.

### Empty Bloated DB Table

Our production Mukurtu site was generating so many deprecation warnings etc
that it filled our `/var/lib/mysql` partition for MariaDB and prevented the
database from starting. Greg was able to recover enough disk space from the
partition by removing some old backup files to get MariaDB to start. Running
`drush cc all` afterwards was able to recover more disk space to buy time for
attempts at remediation. Attempting to empty the table by
`drush watchdog:delete all` were unsuccessful and started causing a MariaDB file
`/var/lib/mysql/ibdata1` to start growing quickly. Research indicated it's not
possible to regain storage used by this file without deleting and reimporting
all database tables, so this process was cancelled before it completely filled
the partition again. Reading the code found that internally this uses the
`TRUNCATE` command which is supposed to be the most efficient way to empty a
database table and reset its autoincrement value. But with this approach
seeming like a recipe for disastar that would re-fill the table, other options
were researched. It was found that re-creating the table anew with a different
name, renaming the original, and then renaming the new table with the original's
name would work. This approach worked, and deleting the large table after the
new one was in place recovered the disk storage.

Retrieve the SQL to re-create the watchdog table.
Copy the output and enter with a different table name, `watchdognew`.
Rename the tables. Then drop the old table.

```sql
USE genoa;

SHOW CREATE TABLE watchdog;

CREATE TABLE watchdognew ...

RENAME TABLE watchdog TO watchdogold, watchdognew TO watchdog;

DROP TABLE watchdogold;
```

Now the dblog module and the "watchdog" table can be used again. The cron
maintenance task will clear the table down to an amount configured on the admin
page "Configuration > Development > Logging and errors",
i.e. `/admin/config/development/logging` again as well. This had failed while
the table was enormous.

### Disable dblog Module

To save the extra storage wear and CPU cycles, the dblog module can be disabled
until needed to actually debug errors etc.

Go to the admin page "Modules", i.e. `/admin/modules`, search for "log",
toggle off the "dblog" module, and click Save in the lower left.

## Prevent 404 console / log spam

```bash
cd /var/local/www/mukurtu/(site)
mkdir master/sites/all/modules/custom/features/ma_core/js
echo '// Empty file to prevent 404 log / console bloat' \
  > master/sites/all/modules/custom/features/ma_core/js/bootstrap_tooltips_over_select2_widget.js

mkdir master/sites/all/themes/bootstrap/fonts
echo ' ' > master/sites/all/themes/bootstrap/fonts/glyphicons-halflings-regular.ttf
```

## Restrict entity_delete_log

`/admin/config/system/entity-delete-log`

De-select all record types except User records for logging deletion and click
Save.

We aren't using audit logs of records deleted. Over the course of a few years
this table had grown to take up as much space as the rest of the database.

To empty the table completely, run this command:

```sql
USE genoa;

DELETE FROM entity_delete_log;
```

## Remove DHAN Node Records

There are extraneous content items of type Digital Heritage Admin Notification.
They are automatically created for every item uploaded and imported, effectively
doubling the number of node records in the database.

These can be removed via SQL to reduce noise in browsing content in the site
and possibly have a minor speed benefit to accessing uploaded item node records.

```sql
USE genoa;

DELETE FROM node WHERE type='dhan';
```

## PHP

### APC Settings
[Drupal
documentation](https://www.drupal.org/docs/7/caching-to-improve-performance/opcode-caching)

Installed these additional packages just in case they help:

`sudo yum install install php72-php-pecl-apcu-bc php72-php-pecl-apcu-devel`

`vim /etc/opt/remi/php72/php.d/90-mukurtu.ini`:
```ini
apc.shm_size = 128M
apc.ttl = 3600
```

Didn't seem to have a noticeable effect on performance, but will leave for now.

### realpatch_cache
[Drupal
documentation](https://www.drupal.org/docs/7/managing-site-performance/tuning-phpini-for-drupal)

Tested output of size in phpinfo page and never saw value over 300K. PHP 7.2's
default value is 4M, which seems adequate.

Increase TTL value to 3600, one hour

`vim /etc/opt/remi/php72/php.d/90-mukurtu.ini`:

```ini
realpath_cache_ttl = 3600
```

Didn't seem to have a noticeable effect on performance, but will leave for now.

### Zend OPcache
`sudo yum install php72-php-opcache`

Default settings match the [recommended
values](https://www.php.net/manual/en/opcache.installation.php#opcache.installation.recommended)
except for `opcache.revalidate_freq`

`vim /etc/opt/remi/php72/php.d/90-mukurtu.ini`:

```ini
opcache.revalidate_freq = 60
```

This package provided noticeable performance improvement!

## Further Research
Some reading indicates that PHP deployment via
[php-fpm](https://cwiki.apache.org/confluence/display/HTTPD/PHP-FPM) rather than
mod_fcgid may be more performant, at least partially because it is supposed to
allow all PHP processes to share internal caching

Here are some links to potential further research into optimization:

- [db_maintenance module](https://www.drupal.org/project/db_maintenance)
  - Previous experience with the OPTIMIZE command for MariaDB informs to be
    skeptical this process will lead to noticeable improvements in performance
- [Memcache module](https://www.drupal.org/project/memcache/)
  - This or Varnish could probably improve performance but complicate the
    deployment of the site in general
- [Authcache module](https://www.drupal.org/project/authcache)
  - Appears tricky customization would be required to see performance benefits
- [MariaDB
  Optimizations](https://www.drupal.org/docs/7/managing-site-performance/optimizing-mysql)
  - Some of these may be fruitful in tweaking MariaDB config
- [Caching
  Resources](https://www.drupal.org/docs/7/managing-site-performance-and-scalability/caching-to-improve-performance/caching-overview)
  - This has been reviewed to pick out specifics which looked like low-hanging
    fruit, but there are more resources on caching and optimization

