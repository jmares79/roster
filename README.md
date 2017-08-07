# Roster Bots

This project is based on the code challenge provided as a test for a remote Sr PHP dev position.
It consists of a REST API crated with the [Symfony framework](https://symfony.com/)

## Objective

Develop the a game called Roster Bots. It consists of create a league of sport bots team. Each one have  attribute scores (Speed, Strength, Agility) loaded in points.

The total sum of the speed, strength, and agility attributes is calculated as the "total attribute score" for each
player bot.

The league has mandated that the total attribute score of each of your player bots can not exceed 100 points,
and no two players can have the same score, otherwise your team is disqualified from league play.

The league has also implemented a salary cap. Each team's roster can not exceed 175 points.

> The salary calculation was not explicit in the exercise description. For now, it's now being checked. After the deployment to a production server, it will be added for completion


## Structure of the project

The main structure is obviously based in the one provided by Symfony, using the internal development server provided by PHP and powered by MySQL DBMS.

However, the project was created and uploaded to my personal Heroku account (more on that below)

The structure is a single Symfony bundle (_RosterBundle_), that handles a controller (_RosterController_), 2 entities (_Bot_ & _League_), 2 services (CommonBotGenerator & CommonLeagueGenerator), along with some interfaces and custom exceptions.

The code was created to follow [SOLID principles](https://en.wikipedia.org/wiki/SOLID_(object-oriented_design)) as much as possible.

Basically, the structure is created as follows:

1. An User request any route that is annotated in the header of Controller methods
2. The Controller sends the request through the corresponding service or returns an appropiate response if needed.
3. The service, implementing a certain interface handles the request and sends back the response
4. Controller returns the response

As a note, keep in mind that for creating a bot, __a league has to be created first__, as no bot can be without belonging to a certain league.

### Main classes

- > RosterController: It controls all the flux of data, for saving, retrieving both _Bot_ & _League_ data
- > CommonBotGenerator: Handles the creation and management for bots
- > CommonLeagueGenerator: Handles the creation and management for a league
- > Entity\Bot: Bot entity data
- > Entity\League: League entity data

In Symfony, entities are needed to manage the data model via Doctrine ORM, check the documentation for using the console and Dcotrine for more details.

### Interfaces

- BotGeneratorInterface
- LeagueGeneratorInterface

Those interfaces were created in order to following an Open/Closed strategy of adding/changing functionality to the project.

If for some reason the generation of any entity is not the desired, the project can be easily modified, as follows:

1. Create a new service for a new algorithm/way of doing things
2. Implement the needed method provided in the Interface
3. Change the old service to the new service in the call within the controller or
4. Create a Strategy Pattern to modify on the fly (NOT provided)

### Installation

1. Clone the repo from this repository
2. Execute `composer install` for vendor dependencies, once the repo was succesfully cloned.
3. Set your database credentials accordingly in parameters.yml.
4. Create a connection called __roster__ (or any name you like), as stated in `parameters.yml`, and start  MySQL service.
5. Execute `php bin\console doctrine:database:create` for the physical creation of the database.
6. Execute `php bin\console doctrine:schema:create` for the physical creation of the database schema.
7. Execute `php bin\console server:run` for a development server

### Usage

As this is an API, use a REST Client (I use [Postman](https://www.getpostman.com/)), and in the URL enter:

`https:\\<local.server.domain>:<port>\<route>` where <route> is any annotated route in RosterController.

- `GET /bot/{id}` Returns a bot by his id
- `POST /bot/{leagueId}` Creates a new Bot for a certain League
- `GET /league/{id}` Returns a league by Id
- `POST /league` Generates a new valid league, that will be neccesary to hold a team

### Tests

Some tests were created using PHPUnit framework.

- RosterControllerTest: It test a GET request to a getBotAction. It checks that the response structure comply with the needed one.

For that Controller, the missed GET to a League is almost exactly the same.

- CommonBotGeneratorTest & CommonLeagueGeneratorTest: Both tests the services provided for managing of the core app. In both cases a `function setUp()` method is implemented to mock a `Doctrine\ORM\EntityManager` class and a `RosterBundle\Entity\<XXXX>` class, depending on the test.

Then, the required generator was instantiated and their responses validated with the correct ones.

## Heroku

The project was deployed in a personal Heroku appplication.

In case the examiner intend to do that, the steps are the following (some already performed)

1. Create a heroku account
2. Download and install Heroku Toolbelt
3. Clone the repo to a desired folder
4. Execute `heroku login`.
5. Execute `heroku create`. This will create a random-named app in your personal account
6. Execute `heroku addons:add cleardb:ignite` to install MySQL extensions
7. Execute `heroku config:get CLEARDB_DATABASE_URL` to echo DDBB parameters in a connection string format.
8. Copy each of the parameters to `parameters_prod.yml` file
9. Execute `heroku run php bin/console doctrine:database:create` to create the remote DDBB
10. Execute `heroku run php bin/console doctrine:schema:update --force` to create the remote DDBB schema
11. Execute `git push heroku master`. This will deploy the app and install the project in the new app
8. Execute `heroku open`. This will launch a new tab with the app

#### Heroku troubleshooting

I had some issues regarding the database creation. One of them was that when deploying an app, symfony uses config_prod.yml to set the new parameters for production env.

For solving that, I created a `parameters_prod.yml` with the values of my personal project hosted. A `.dist` also attached.
In `config_prod.yml` the final configuration is:

```imports:
    - { resource: config.yml }
    - { resource: parameters_prod.yml }
```



