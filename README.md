# Laravel API
API responsible for applying the intelligence and business rules 
of the Laravel Restful project.

## Installation

### Clone

Execute the following command to get the latest version of the project:

```terminal
$ git clone --recursive git@github.com:rafaelmilanibarbosa/laravel-api.git laravel-api
```

### Set permissions

Execute the following commands to set the write permission on the cache folder:

```terminal
$ cd laravel-api
$ sudo chmod -R 777 storage bootstrap/cache
```

## Docker

### Docker environment variables

Copy and change docker variables according to your environment:

```terminal
$ cd laradock
$ cp env-example .env
```

### Create and start containers

```terminal
$ docker-compose up -d nginx php-fpm postgres
```

### Go to the workspace

Enter the Workspace container, to execute commands like (Artisan, Composer, PHPUnit, …):

```terminal
$ docker-compose exec --user=laradock workspace bash
```

Alternatively, for Windows PowerShell users: execute the following command to enter any running container:

```terminal
$ docker exec -it --user=laradock {workspace-container-id} bash
```

### Install and configure the project

```terminal
/var/www$ composer install
/var/www$ cp .env.example .env
/var/www$ php artisan key:generate
/var/www$ php artisan migrate
/var/www$ php artisan passport:install
```

### Create a new user

```terminal
/var/www$ php artisan tinker
>>> $user = new Modules\User\Entities\User;
>>> $user->first_name = 'Your Firstname';
>>> $user->last_name = 'Your Lastname';
>>> $user->email = 'mail@domain.com';
>>> $user->is_superuser = true;
>>> $user->is_staff = true;
>>> $user->password = 'yourpass';
>>> $user->save();
>>> exit
```

Exit the workspace

```terminal
/var/www$ exit
```

Full documentation for Laradock can be found on the [Laradock website](http://laradock.io/).

## Hosts

Update the file of hosts, in systems based in Linux or MacOS usually in:

```terminal
/etc/hosts
```

Add the follow line:

```terminal
127.0.0.1       laravel-api.test
```

The base address of RESTful API is 
[http://laravel-api.test](http://laravel-api.test)

## Permissions and roles

### Map routes and titles by route name

On each module you need to add a permissions entry in the settings file

Example path:

```
modules/Example/Config/config.php
```

Permissions entry example:

```php
'permissions' => [
    ['name' => 'examples.index', 'title' => 'List examples'],
    ['name' => 'examples.show', 'title' => 'Show example'],
    ['name' => 'examples.store', 'title' => 'Create example'],
    ['name' => 'examples.update', 'title' => 'Update example'],
    ['name' => 'examples.destroy', 'title' => 'Delete example'],
],
```

### Synchronize the permissions with the database

Execute the following command to synchronize the permissions with the database:

```terminal
$ php artisan permission:sync
```

Alternatively you can make a post request to the endpoint by superusers:

POST /permissions/sync

Execute the following command to migrate the permissions with the database:

```terminal
$ php artisan permission:migrate
```

Execute the following command to reset and re-migrate all permissions with the database:

```terminal
$ php artisan permission:refresh
```

### Roles

The roles resource can be accessed via RESTful only by superusers in the endpoint:

```
/roles
```

Request body:

````rest
{
	"name": "Supervisor",
	"guard_name": "web",
	"permissions": ["users.store", "users.update"]
}
````

### Roles and permission to users

Create and edit users passing roles and permissions by superusers in the endpoint:

```
/users
```

Request body:

```rest
{
    "roles": ["writer", "reader"],
    "permissions": ["users.destroy", "users.index"]
}
```

## Status

Status module provides resources to handle current status of system items

Status available is in path:

```
modules/Status/Config/config.php
```

Execute the following command to migrate the status from config:

```terminal
$ php artisan status:migrate
```

Execute the following command to synchronize the status from config:

```terminal
$ php artisan status:sync
```

Execute the following command to show the status of each status:

```terminal
$ php artisan status:status
```
