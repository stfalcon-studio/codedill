# Codedill

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/stfalcon-studio/codedill?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

## Installation DEV environment

### a) Check your System Configuration

Before you begin, make sure that your local system is properly configured
for Symfony2. To do this, execute the following:

    $ ./app/check.php

If you get any warnings or recommendations, fix these now before moving on.

**Requirements**

* PHP needs to be a minimum version of PHP 5.4.*
* JSON needs to be enabled
* ctype needs to be enabled
* curl needs to be enabled
* Your PHP.ini needs to have the date.timezone setting
* Intl needs to be installed with ICU 4+
* APC 3.0.17+ (or another opcode cache needs to be installed)


### b) Change the permissions of the "app/cache/" and "app/logs" directories so that the web server can write into it.

    $ chmod 0777 app/cache/ app/logs

### c) Install NodeJS

    (http://konradpodgorski.com/blog/2014/06/22/how-to-install-node-js)

    $ sudo apt-get install node

### d) Installing Bower

    $ npm install -g bower

### e) Install Composer

    $ curl -s https://getcomposer.org/installer | php

### f) Install the Vendor Libraries

    $ ./composer.phar install

### g) Change DBAL settings, create DB, update it and load fixtures

Change DBAL setting in `app/config/config.yml`, `app/config/config_dev.yml` or
`app/config/config_test.yml`. After that execute the following:

    $ ./console doctrine:database:create
    $ ./console doctrine:migrations:migrate
    $ ./console doctrine:fixtures:load

You can set environment `test` for command if you add `--env=test` to it.

### h) Register your application in GitHub
 
Open https://github.com/settings/applications/new

    * Application name:           CodeDill
    * Homepage URL:               http://codedill.work
    * Authorization callback URL: http://codedill.work/auth/check-github
    
Press the button "Register application"

Use the newly generated `Client ID` and `Client Secret` parameters    
