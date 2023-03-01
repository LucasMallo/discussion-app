Requirements
------------

- Web Project for Nette 3.1 requires PHP 8.0


Installation
------------

Run `composer install`

Database
---------
Setup connection to database in config/local.neon file.
Run SQL queries in database.sql - Creates user `tester` with password `demo` and couple of demo posts. 


Web Server Setup
----------------

The simplest way to get started is to start the built-in PHP server in the root directory of your project:

	php -S localhost:8000 -t www

Then visit `http://localhost:8000` in your browser to see the welcome page.

For Apache or Nginx, setup a virtual host to point to the `www/` directory of the project and you
should be ready to go.

**It is CRITICAL that whole `app/`, `config/`, `log/` and `temp/` directories are not accessible directly
via a web browser. See [security warning](https://nette.org/security-warning).**
