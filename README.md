# lara-chain

Lara chain

You only need docker to run this program. Make is a tool to help and simplify some commands.

```
# Build the environment
$ docker-compose build
# Get all containers up and running
$ docker-compose up -d
# Enter the main docker container based on PHP 8 alpine
$ make shell
```

# Considerations to build this project

- Created a Laravel project with composer
- I've removed manually unnecessary DEV dependencies by adding a .phar file with the specefici PHPunit tool I want to use for development
- I've removed manually some files I consider not necessary for this project because I want to do all the stuff via console with testing (webpack, js, css, etc.).

