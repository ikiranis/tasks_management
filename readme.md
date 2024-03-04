# Use instructions

## Install

### Clone the repository

### Install dependencies

```
composer install
```

### Create a .env file

```
cp .env.example .env
```

Edit the file

### Set apache/nginx to point to the index.php file

## Usage

On host machine, you must create triggers and audit_trail table. Go to browser and run the following url:

```
https://host_server.ddev.site/syncAPI/createTriggers
```
On local machine run the following url:

```
https://local_server.ddev.site/syncAPI/restoreTables
```
To check DB integrity, run (on local machine again) the following url:

```
https://local_server.ddev.site/syncAPI/checkDB
```
** Be sure that timezones are the same on both servers. **
