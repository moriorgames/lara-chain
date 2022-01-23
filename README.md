# lara-chain

Lara chain

You only need docker to run this program. Make is a tool to help and simplify some commands.

```
# Build the environment
$ docker-compose build
# Get all containers up and running
$ docker-compose up -d
# Seed the database
$ make seed
# Launch tests
$ make test
# Launch test coverage
$ make cover
# If you want to enter the main docker container based on PHP 8
$ make shell
# From inside the container, Seed the database
$ php artisan db:seed
# From inside the container, launch tests
$ php phars/phpunit.phar --stop-on-failure
# From inside the container, launch code coverage
$ php phars/phpunit.phar --stop-on-failure --coverage-html=coverage
```

# Considerations to build this project

- Created a Laravel project with composer
- I've removed manually unnecessary DEV dependencies by adding a .phar file with the specific PHPunit tool I want to use for development
- I've removed manually some files I consider not necessary for this project because I want to do all the stuff via console with testing (webpack, js, css, etc.).

# Implementations details

On the Use Case get all active users with austrian citizenship there's a lot of decisions to take here.
- I've decided to create a Bounded Context User to make explicit this source code belongs to the feature I want to implement and isolate from the Framework stuff.
- I've tried to implement only what requirements ask. Following strict TDD flow. I do not know how business will evolve, so I will stick only for what I understand from requirements.
- This is the reason why I created a specific function on the Repository with no criteria, of course, if Business needs more functionality, sure it will, I will need to do a refactor of this part.
- Same with the Use Case. The Use Case is very specific, but until, as a developer, I'm not able to know more about Business, I prefer to not take design decisions.
- Right or not, this is my way of doing, never assume requirements :) 
- With the MysqlConnection I'm not happy at all. I'm Trying to avoid Eloquent because I do not remember how to get it up running properly, and I do not want to spend time on this implementation detail.
- Of course, I totally understand that being a part of a team is very useful to have an ORM in place. Eloquent seems a good choice (not my favorite).
- I'm not happy with the Autoincremental ID on the entities, because we are coupling our models/entities with an implementation detail as Autoincrements of Mysql.
- I have a feeling that User model is an aggregate root, but at this point I don't have enough information to take decisions on that I guess it will emerge on next commits.

