## Welcome to Mapamy!

_Mapamy_ is a platform where you can create maps with a collection of pins and interesting descriptions. Add pins to your maps and share them with others, or just view maps created by other users.

This repository contains the backend code for _Mapamy_, in case you want to help out with the development of the platform.

## Setup for the first time

You need to have the following installed on your machine:

- [DDEV](https://ddev.com/)
- [Docker](https://www.docker.com/)

**Note**: feel free to work on a Windows machine, but Linux will make your life easier.

Once you are ready to go, start the DDEV environment by running the following command in the project root directory:

```
ddev start
```

Then install composer packages. Composer is already provided with DDEV, so just do:

```
ddev composer install
```

### Environment Variables

This project relies on environment variables to run. You can create a `.env` file in the root of the project to set these variables. Use the `.env.example` file as a template.

You can leave the sendgrid API key empty, and it will default to use the native php mail() function, so you can catch emails with DDEV mailpit.

Run the following command to open the mailpit interface:

```
ddev mailpit
```

### Database Setup

The first time you set up this project, you will also have to enable the PostGIS extension in the database:

Access the database using the following command:

```
ddev ssh
psql -U db -d db
```

Run the following command in the database:

```sql
CREATE EXTENSION IF NOT EXISTS postgis;
```

Then you will have to run the following command to set up the database structure:

```
ddev exec vendor/bin/phinx migrate
```

This command will run the migrations using Phinx.

### Install required node modules

To install the required node modules, run:

```
ddev exec npm install
```

### Build files

You also need to build your js and css assets. To do this, run:

```
ddev exec npm run webpack
```

## Running the project after the first time

After you have set up the project for the first time, you can run the following command to start the DDEV environment:

```
ddev start
```

Update any potential composer packages:

```
ddev composer update
```

Run any migrations that may have been added since the last time you set up the project:

```
ddev exec vendor/bin/phinx migrate
```

Then run webpack to build the assets:

```
ddev exec npm run webpack
```