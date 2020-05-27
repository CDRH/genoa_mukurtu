# Drupal and Mukurtu Optimizations

- [Page Caching and CSS/JS Aggregation](#page-caching-and-css-js-aggregation)
- [PHP](#php)
  - [APC Settings](#apc-settings)
  - [realpath_cache](#realpath_cache)
  - [Zend OPcache](#zend-opcache)
- [Further Research](#further-research)

Packages for install have already been integrated into [Mukurtu install
documentation](https://github.com/CDRH/CDRH-General/wiki/Mukurtu).

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

