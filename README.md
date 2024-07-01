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

PostgreSQL 15 with PostGIS extension 3

To set up the database, run the following SQL commands:

```sql
CREATE EXTENSION IF NOT EXISTS postgis;

CREATE TABLE maps (
  id SERIAL PRIMARY KEY,
  user_id INTEGER NOT NULL,
  name VARCHAR(255) NOT NULL,
  slug VARCHAR(120) NOT NULL,
  description TEXT NOT NULL
);

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  provider VARCHAR(255) NOT NULL,
  provider_id VARCHAR(255) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL,
  token TEXT NOT NULL
);

CREATE TABLE pins (
  id SERIAL PRIMARY KEY,
  map_id INTEGER NOT NULL,
  name VARCHAR(255) NOT NULL,
  slug VARCHAR(120) NOT NULL,
  description TEXT NOT NULL,
  location GEOGRAPHY(POINT, 4326) NOT NULL,
  FOREIGN KEY (map_id) REFERENCES maps(id) ON DELETE CASCADE
);

ALTER TABLE maps ADD FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;