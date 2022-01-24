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

On the feature Get All Active users with austrian citizenship there's a lot of decisions to take here.
- I've decided to create a Bounded Context User to make explicit this source code belongs to the feature I want to implement and isolate from the Framework stuff.
- I've tried to implement only what requirements ask. Following strict TDD flow. I do not know how business will evolve, so I will stick only for what I understand from requirements.
- This is the reason why I created a specific function on the Repository with no criteria, of course, if Business needs more functionality, sure it will, I will need to do a refactor of this part.
- Same with the Use Case. The Use Case is very specific, but until, as a developer, I'm not able to know more about Business, I prefer to not take design decisions.
- Right or not, this is my way of doing, never assume requirements :) 
- With the MysqlConnection I'm not happy at all. I'm Trying to avoid Eloquent because I do not remember how to get it up running properly, and I do not want to spend time on this implementation detail.
- Of course, I totally understand that being a part of a team is very useful to have an ORM in place. Eloquent seems a good choice (not my favorite).
- I'm not happy with the Autoincremental ID on the entities, because we are coupling our models/entities with an implementation detail as Autoincrements of Mysql.
- I have a feeling that User model is an aggregate root, but at this point I don't have enough information to take decisions on that I guess it will emerge on next commits.


On the feature Edit User details I have a lack of knowledge about what's correct from business perspective.
- What happens when I try to edit user details but the citizenship_country_id is not a valid country because does not exist on database? What's the behavior expected?
- I have a feeling that User Details is not an entity, is a Value Object, but... the field citizenship_country_id has something, I guess this information is not directly related with User Details, but I have no enough information.
- Is it allowed to edit the ID property of User Details? Why? How? May I do something to avoid Mysql Collisions?
- I'm not happy enough with the implementation of the MysqlUserRepository, I think I'm reinventing the wheel, but I do not want to put Eloquent in place because It will polute the models.
- I think it's a big mistake get entities from the database and `set` the ID property passing through the constructor. In my opinion a constructor for an entity must be called only and only one time in the lifecycle of an entity, so, when its created.
- I'm not happy enough with the mapping between Mysql queries and the objetcs and the opposite way, at some point it will emerge a DataMapper
- This is the reason because I like Doctrine as an ORM because it helps me to do this stuff. Maybe I can use a Reflection class but I do not want to go this way for this exersise, too complicated :)
- The solution is far to be perfect but, at least I think the behaviour is what business needs at this point.

On the feature Delete user if has user details I have the next Thoughts.
- I'm ok with the implementation. I'm fine because I've spent less time developing because I'm starting to reuse some parts that has been developed, this is a good sign.
- The implementation on the MysqlUserRepository does not need, at this point, any Data Mapper and all the features of this part are finished, nice :)
- I've decided to throw an exception on the repository where `find` a User and the entity is not found. I think this is not the best way to proceed but is something we can discuss with the team.
- Talking about the feature tests. I use to name this tests Integration test, why? because I think is not a good practise to test business rules with the database implementation in place.
- Validating business rules can be done perfectly by using Unit tests, and isolating the database (an implementation detail). It's fast, efficient and scalable.
- This is the reason because I call Feature tests `Integration tests` because the purpose I like to accomplish with these tests is to check that all the dependencies are working as expected (Well integrated) and the `Happy path`.
- I think is not a bad idea to have a `happy path test` this is a use case with the most common behaviour tested via Integration test (I used to do only one by feature).


On the las feature implementing a repository with different sources.
- I decided to go for a factory injected on the use case class. So I can test this locally with unit tests and I think it solves the desired problem.
- I'm not happy at all with the CSV or the MYSQL transactions repository but I wanted to finish the test today and I'm little tired :(
- But all the stuff seems to be working, I've launched the tests several times and I'm pretty sure all is working as expected.
- The solution is not perfect, of course there are not perfect solucionts, but at least with all the tests in place and a high code coverage the cost of change (refactor) is low.

I've enjoyed a lot by doing the exercise. Thanks for your time reading and correcting this exercise, feedback will be welcome!
