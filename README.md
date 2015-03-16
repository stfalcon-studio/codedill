# Codedill

Web service for creating study tasks for developers and evaluating solutions anonymously.

> *Currently in development. Things may change or break until a solid release has been announced.*

[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/stfalcon-studio/codedill.svg?style=flat-square)](https://scrutinizer-ci.com/g/stfalcon-studio/codedill/)
[![Build Status](https://img.shields.io/travis/stfalcon-studio/codedill.svg?style=flat-square)](https://travis-ci.org/stfalcon-studio/codedill)
[![Codecov](https://img.shields.io/codecov/c/github/stfalcon-studio/codedill.svg?style=flat-square)](https://codecov.io/github/stfalcon-studio/codedill?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/stfalcon-studio/codedill.svg?style=flat-square)](https://packagist.org/packages/stfalcon-studio/codedill)
[![Latest Stable Version](https://img.shields.io/packagist/v/stfalcon-studio/codedill.svg?style=flat-square)](https://packagist.org/packages/stfalcon-studio/codedill)
[![License](https://img.shields.io/packagist/l/stfalcon-studio/codedill.svg?style=flat-square)](https://packagist.org/packages/stfalcon-studio/codedill)
[![Dependency Status](https://www.versioneye.com/user/projects/54fab47b4f31084fdc00062f/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/54fab47b4f31084fdc00062f)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/5f832d0d-da76-4d27-b748-239c4e79a711.svg?style=flat-square)](https://insight.sensiolabs.com/projects/5f832d0d-da76-4d27-b748-239c4e79a711)
[![HHVM](https://img.shields.io/hhvm/stfalcon-studio/codedill.svg?style=flat-square)](http://hhvm.h4cc.de/package/stfalcon-studio/codedill)
[![Gitter](https://img.shields.io/badge/gitter-join%20chat-brightgreen.svg?style=flat-square)](https://gitter.im/stfalcon-studio/codedill?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Requirements

* PHP 5.4 *and later*
* Symfony 2.6 *and later*
* Doctrine 2.4 *and later*
* Node.JS
* Bower
* GitHub application

## Installation

#### Install Composer

```bash
$ curl -s https://getcomposer.org/installer | php
```
    
#### Install Node.js and Bower

Because we are using `SpBowerBundle` for managing assets you have to install required Node.js and Bower for it.

```bash
$ sudo apt-get install node
$ npm install -g bower
```
       
#### Create project via Composer

```bash
$ composer.phar create-project -s dev stfalcon-studio/codedill codedill
```

`-s dev` means non-stable version, until we make first stable release.

#### Check your system configuration

Before you begin, make sure that your local system is properly configured for Symfony2.
To do this, execute the following:

```bash
$ php app/check.php
```

If you got any warnings or recommendations, fix them before moving on.

##### Requirements

* PHP needs to be a minimum version of PHP 5.4.*
* JSON needs to be enabled
* ctype needs to be enabled
* curl needs to be enabled
* Your PHP.ini needs to have the date.timezone setting
* Intl needs to be installed with ICU 4+
* APC 3.0.17+ (or another opcode cache needs to be installed)

#### Setting up permissions for directories `app/cache/` and `app/logs`

```bash
$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
````

#### Change DBAL settings, create DB, update it and load fixtures

Change DBAL setting if your need in `app/config/config.yml`, `app/config/config_dev.yml` or
`app/config/config_test.yml`. After that execute the following:

```bash
$ ./console doctrine:database:create
$ ./console doctrine:migrations:migrate
$ ./console doctrine:fixtures:load
```

You can set `test` environment for command if you add `--env=test` to it.

#### Create new application on GitHub
 
Open <a href="https://github.com/settings/applications/new" target="_blank">https://github.com/settings/applications/new</a>

```
Application name:           Codedill
Homepage URL:               http://codedill.localhost/app_dev.php
Authorization callback URL: http://codedill.localhost/app_dev.php/auth/check-github
```
    
Press the button "Register application".

Use the newly generated `Client ID` and `Client Secret` parameters for your application.  

---

That's all. Enjoy "Codedill" and send feedback ^_^
