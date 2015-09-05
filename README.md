# proophessor-do
including exercises!

## What's going on here?

Prooph is an organisation developing and supporting CQRS and Event-Sourcing infrastructure for PHP environments.
You can learn more about it by reading the [official documentation](http://prooph.github.io/proophessor/).

This repository contains an example implementation of a small domain model served by a PHP web application.

- The application layer is built as a [ZF2](https://github.com/zendframework/zf2) module.
- Read model persistence is managed with the help of [doctrine](https://github.com/doctrine).
- Write model persistence is managed either with the [doctrine adapter](https://github.com/prooph/event-store-doctrine-adapter)
or [mongo db adapter](https://github.com/prooph/event-store-mongodb-adapter) for [prooph/event-store](https://github.com/prooph/event-store).

## Business Domain

The business logic implemented in this educational project is very simple and should be known by everybody in one way or the other.
It is about managing todo lists for users whereby a todo can have a deadline and the assigned user can add a reminder to get notified when
time has passed.


## Installation

Please refer to the [installation instructions](docs/installation.md).


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

## HALL OF FAME

A successfully merged pull request will add you to the HALL OF FAME!

### Features

- [ ] [Mark a todo as done](https://github.com/prooph/proophessor-do/issues/1) - done by [your name here]
- [ ] [Reopen a todo](https://github.com/prooph/proophessor-do/issues/2) - done by [your name here]
- [ ] Add deadline to todo - done by [your name here]
- [ ] Add reminder for assignee - done by [your name here]
- [ ] Mark a todo as expired - done by [your name here]
- [ ] Notify assignee when todo deadline is expired - done by [your name here]
- [ ] Notify assignee when reminder time is reached - done by [your name here]
- more features will follow ...

# Support

- Ask questions on [prooph-users](https://groups.google.com/forum/?hl=de#!forum/prooph) mailing list.
- File issues at [https://github.com/prooph/proophessor-do/issues](https://github.com/prooph/proophessor-do/issues).
- Say hello in the [prooph gitter](https://gitter.im/prooph/improoph) chat.



Happy messaging!


