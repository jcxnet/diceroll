# Dice roll
Simple dice roll game write in PHP

This project requires `docker-compose` to run.

## Prerequisites
Before you begin, make sure you have the following installed on your system:
- [Docker](https://www.docker.com)
- [Docker Compose](https://docs.docker.com/compose/)

## Installation
To get started, clone this repository and navigate to the project directory:
~~~
git clone https://github.com/jcxnet/diceroll.git
cd diceroll
~~~

Next, build the Docker containers for the project:
~~~
docker-compose build
~~~

## Usage

To start the project, run the following command:
~~~
docker-compose up
~~~

This will start the project and all of its dependencies. You should now be able to access the project at http://localhost:8080 or the relevant port specified in the docker-compose.yml file.

## Stopping the project
To stop the project, press `CTRL+C` in the terminal where the project is running. This will stop the containers, but they will still exist on your system.

To completely remove the containers and delete all data, run the following command:

~~~
docker-compose down
~~~
This will stop and remove the containers, as well as any volumes that were created.

### Further reading
For more information on using `docker-compose`, see the [official documentation](https://docs.docker.com/compose/).