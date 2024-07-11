## Welcome to Mapamy!

Mapamy is a platform where you can create maps with a collection of pins. You can add pins to your maps and share them with others. You can also view maps created by other users.

This repository contains the backend code for Mapamy, in case you want to help out with the development of the platform.

## Setup

You need to have the following installed on your machine:

- [DDEV](https://ddev.com/)
- [Docker](https://www.docker.com/)

Once you are ready to go, start the DDEV environment by running:

```
ddev start
```

Then install composer packages. Composer is already provided with DDEV, so just do:

```
ddev composer install
```

### Environment Variables

This project relies on environment variables to run. You can create a `.env` file in the root of the project to set these variables. Use the `.env.example` file as a template.

## Database Setup

The first time you set up this project, you will have to enable the PostGIS extension in the database:

Access the database using the following command:

```
ddev ssh
psql -U db -d db
```

Run the following command in the database:

```sql
CREATE EXTENSION IF NOT EXISTS postgis;
```

Then, everytime you start the project, you will have to run the following command to sync any potential changes in the database:

```
ddev exec vendor/bin/phinx migrate
```

This command will run the migrations using Phinx.

## Install required node modules

To install the required node modules, run:

```
ddev exec npm install
```

## Build files

You also need to build your js and css assets. To do this, run:

````
ddev exec npm run webpack
```
