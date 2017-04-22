# combinator
A simple counting API

# Developing

## Prerequisites

All future sections in this "Developing" section expect that the Docker Compose containers are running. To get the dev environment running, run `docker-compose up --build` from the project root.

## Running tests

Tests are run via the tests/run.sh script, which should be run from the project root. Valid options are `--all`, `--behavior`, and `--unit`.

Tests are run in Docker containers. Environment variables for testing are passed to the containers from the `tests/.env` file, which should contain the correct variables to allow testing against the Docker Compose defined containers.
