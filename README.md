# WP-CLI Plugins API

[![Build Status](https://travis-ci.org/miya0001/wp-cli-plugins-api.svg?branch=master)](https://travis-ci.org/miya0001/wp-cli-plugins-api)


This is a WP-CLI command for getting plugin information form WordPress.org Plugin API.

* `wp plugins-api author <author>` - Get a list of plugins for specific author.
* `wp plugins-api browse <browse>` - Get a list of plugins for popular/new/updated/top-rated.
* `wp plugins-api info <slug>` - Get a plugin information specific plugin.

```
$ wp plugins-api author miyauchi
+---------------------------------+---------+--------+----------+--------+-------------+
| name                            | version | tested | requires | rating | downloaded  |
+---------------------------------+---------+--------+----------+--------+-------------+
| Nginx Cache Controller          | 3.1.0   | 4.0.1  | 3.4      | 100.0  |      33,423 |
| Simple Map                      | 2.2.0   | 4.0.1  | 3.3      | 100.0  |      61,506 |
| Content Bootstrap               | 0.7.0   | 4.0.1  | 3.4      | 100.0  |       2,715 |
| oEmbed Gist                     | 1.6.1   | 4.0.1  | 3.5.2    | 100.0  |       3,733 |
| Posts from a Category Widget    | 1.0.1   | 4.0.1  | 3.4      | 100.0  |       8,784 |
| Child Pages Shortcode           | 1.9.1   | 4.0.1  | 3.4      |  95.6  |      43,401 |
| WP Total Hacks                  | 1.9.0   | 4.0.1  | 3.5      |  99.4  |     173,521 |
+---------------------------------+---------+--------+----------+--------+-------------+
30 plugins. 449,591 downloads.
```

## System Requirements

* PHP >=5.3
* wp-cli >=0.15.0

If you need support for wp-cli < 0.15.0, please use the 1.1.x branch.

## Installing

See documnentation.

[https://github.com/wp-cli/wp-cli/wiki/Community-Packages](https://github.com/wp-cli/wp-cli/wiki/Community-Packages)
