# Silex Environment ServiceProvider

[![Build Status](https://travis-ci.org/frostieDE/silex-environment-serviceprovider.svg?branch=master)](https://travis-ci.org/frostieDE/silex-environment-serviceprovider)
[![Code Climate](https://codeclimate.com/github/frostieDE/silex-environment-serviceprovider/badges/gpa.svg)](https://codeclimate.com/github/frostieDE/silex-environment-serviceprovider)

ServiceProvider for Silex which empowers use of environments like prod, dev etc.
Environments can be changed using an environment variable.

## Installation

```
$ composer require frostiede/silex-environment-serviceprovider
```

Afterwards, register the ServiceProvider:

```php
$app->register(new EnvironmentServiceProvider());
```

## Usage

You can now use `$app['env']` to get the current environment. Also, you can use `$app['cli']`
to detect whether the current application is invoked by command line (in this case, it is set
to `true`, `false` otherwise).

### CLI

When invoking any command from CLI (e.g. using the Command extension), you should prepend the
target environment:

```
$ APP_ENV=dev php bin/console your:command
```

### Webserver

Create two separate PHP endpoint files (`index.php` and `dev.php`) and set your environment variable
according to the file. For example, `dev.php` should contain `putenv("APP_ENV=dev")` to make all
requests from `dev.php` run in dev-environment.

**Note:** Ensure `dev.php` is not accessible in production! 

## Configuration

You can set the environment variable which this extension evaluates. As default,
`APP_ENV` is used but you change it to whatever you want using the constructor:

```php
$app->register(new EnvironmentServiceProvider('ENV'));
```

# Contribution

Any help is welcomed. Feel free to create issues and merge requests :-)

# License

MIT License