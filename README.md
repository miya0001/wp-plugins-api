# `wp plugins-api <sub-command>`

[![Build Status](https://travis-ci.org/miya0001/wp-plugins-api.svg?branch=master)](https://travis-ci.org/miya0001/wp-plugins-api)

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
* wp-cli >=0.17.0

## Installing

### Installing without composer.

```
$ mkdir ~/.wp-cli
$ touch ~/.wp-cli/config.yml
$ mkdir ~/.wp-cli/commands
```

Then install.

```
$ cd ~/.wp-cli/commands
$ git clone git@github.com:miya0001/wp-plugins-api.git
```

Then edit the ~/.wp-cli/config.yml file so that it looks like following.

```
require:
- commands/wp-plugins-api/cli.php
```

### Installing with composer.

1. [Setting up the package index](https://github.com/wp-cli/wp-cli/wiki/Community-Packages#setting-up-the-package-index)
1. `php composer.phar require miya0001/wp-plugins-api=dev-master`


See documnentation.

[https://github.com/wp-cli/wp-cli/wiki/Community-Packages](https://github.com/wp-cli/wp-cli/wiki/Community-Packages)

## How to develop

```
$ git clone git@github.com:miya0001/wp-plugins-api.git
$ composer install
```

Then create or edit the ~/.wp-cli/config.yml file so that it looks like this:

```
require:
- /path/to/wp-plugins-api/cli.php
```

### Functional tests

Initialize the testing environment locally.

```
$ WP_CLI_BIN_DIR=/tmp/wp-cli-phar WP_CLI_CONFIG_PATH=/tmp/wp-cli-phar/config.yml bash bin/install-package-tests.sh
```

Then run the tests.

```
$ WP_CLI_BIN_DIR=/tmp/wp-cli-phar WP_CLI_CONFIG_PATH=/tmp/wp-cli-phar/config.yml vendor/bin/behat
```

See also:

* [https://github.com/wp-cli/wp-cli/wiki/Package-Functional-Tests](https://github.com/wp-cli/wp-cli/wiki/Package-Functional-Tests)
* [http://wp-cli.org/commands/scaffold/package-tests/](http://wp-cli.org/commands/scaffold/package-tests/)
