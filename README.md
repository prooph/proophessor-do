# proophessor example application
including exercises!

## What's going on here?

Proophessor is a CQRS + ES module for Zend Framework 2. You can learn more about it by reading the [official documentation](http://prooph.github.io/proophessor/).


This repository contains an example implementation of a small domain served by a PHP web application. 
[Proophessor](https://github.com/prooph/proophessor) powers the M part and [ZF2](https://github.com/zendframework/zf2) the V and C part of the
MVC stack. Database connection is managed with the help of [doctrine](https://github.com/doctrine) seamlessly integrated through
the [prooph/event-store-doctrine-adapter](https://github.com/prooph/event-store-doctrine-adapter) on the write side and the
[DoctrineORMModule](https://github.com/doctrine/DoctrineORMModule) on the read side.


## Business Domain

The business logic implemented in this educational project is very simple and should be known by everybody in one way or the other.
It is about managing todo lists for users whereby a todo can have a deadline and the assigned user can add a reminder to get notified when
time has passed.


## Installation

The application is based on a Zend Framework 2 Skeleton Application. Follow the [installation guide](https://github.com/zendframework/ZendSkeletonApplication#installation)
that can be found on the appropriate github repository.

## Database Set Up

Before you can get started you have to configure your database connection. We've prepared a template for you. Just rename the
[config/autoload/local.php.dist](config/autoload/local.php.dist) to `local.php` and adjust the doctrine connection params.

Now you should be able to perform the [migrations](data/migrations/) by running `./vendor/bin/doctrine-module migrations:migrate`
on *nix or `./vendor/bin/doctrine-module.bat migrations:migrate` on windows from the root directory of the application.


## Open In Browser

Navigate to `http://localhost/proophessor-sample-app/pubic/index/` or similar depending on how you've installed the application.

## Learning by doing!

When you play around with the application you will notice missing functionality. This has a simple reason. You explore
a learning application and what is the best way to learn? Right! Learning by doing! So if you want to learn something about
CQRS and Event Sourcing:

1. Pick up an open task listed below
2. Get us a note in the corresponding issue that you accept the challenge
3. Ask if you need help
4. Have fun and learn


Note: Some tasks depend on others and some can be split into sub tasks. Let's discuss this in the issues. And of course you
can also work together. Sharing work doubles knowledge!

### A successfully merged pull request will add you to the HALL OF FAME!

## Features

- [ ] [Mark a todo as done](https://github.com/prooph/proophessor-todo-sample/issues/1) - done by [your name here]
- [ ] [Reopen a todo](https://github.com/prooph/proophessor-todo-sample/issues/2) - done by [your name here]
- [ ] Add deadline to todo - done by [your name here]
- [ ] Add reminder for assignee - done by [your name here]
- [ ] Mark a todo as expired - done by [your name here]
- [ ] Notify assignee when todo deadline is expired - done by [your name here]
- [ ] Notify assignee when reminder time is reached - done by [your name here]
- more features will follow ...


Happy messaging!


