# Proophessor Do
**zend expressive** *meets* **prooph**

[![Build Status](https://travis-ci.org/prooph/proophessor-do.svg)](https://travis-ci.org/prooph/proophessor-do)

You're viewing an example application showing you how well PSR-7 middleware can play together with CQRS and EventSourcing.

And you're ask to try it yourself. **Proophessor Do** includes exercises! So read on and **pick up a task!**

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/prooph/improoph)

## What's going on here?

[prooph](https://github.com/prooph) is an organisation developing and supporting CQRS and Event-Sourcing infrastructure for PHP environments.
You can learn more about it by reading the [official prooph guide](http://prooph.github.io/proophessor/).

This repository contains an example implementation of a small domain model served by a PHP web application flavoured with client side JavaScript
to keep the **UI** and the **Backend** focused on what they can best.

## Technology Stack

### Server Side
- PHP 5.5+
- [PSR-7](http://www.php-fig.org/psr/psr-7/) middleware layer based on [zend-expressive](https://github.com/zendframework/zend-expressive)
  - IoC Container: [zend-servicemanager](https://github.com/zendframework/zend-servicemanager) v2.6+ with [container-interop](https://github.com/container-interop/container-interop) support
  - Routing: [Aura.Router](https://github.com/auraphp/Aura.Router)
  - Templates: [zend-view](https://github.com/zendframework/zend-view)
- Separate write and read model following the [CQRS approach](https://cqrs.files.wordpress.com/2010/11/cqrs_documents.pdf) by Greg Young
- Communication from and to the domain layer is handled by [prooph/service-bus](https://github.com/prooph/service-bus)
- Event sourced write model is powered by [prooph/event-sourcing](https://github.com/prooph/event-sourcing)
- Domain events are persisted in a [prooph/event-store](https://github.com/prooph/event-store) using one of the adapters:
  - [doctrine adapter](https://github.com/prooph/event-store-doctrine-adapter)
  - [mongo db adapter](https://github.com/prooph/event-store-mongodb-adapter)
- Read model persistence is managed with the help of [Doctrine DBAL](https://github.com/doctrine/dbal)
- Value Object implementations are graped from [nicolopignatelli/valueobjects](https://github.com/nicolopignatelli/valueobjects)
- Interop. factories using [sandrokeil/interop-config](https://github.com/sandrokeil/interop-config)
- [Assertions](https://github.com/beberlei/assert) - well, you know it

### Client Side
- Layout is graped from [http://bootswatch.com](http://bootswatch.com) which is based on [bootstrap](http://getbootstrap.com/)
- User interaction is handled with [riot.js](http://riotjs.com/)
- User input is validated with [validate.js](http://rickharrison.github.io/validate.js/)
- Commands are sent to the server using [jQuery.ajax](https://jquery.com/)
- Server messages are presented by [notify.js](http://notifyjs.com/)
- JavaScript UUID generator taken from [https://gist.github.com/duzun/d1bfb5406a362e06eccd](https://gist.github.com/duzun/d1bfb5406a362e06eccd)
- Little helpers: [lodash.js](https://lodash.com/) and [undersocre.string.js](http://gabceb.github.io/underscore.string.site/)

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
3. Ask if you need help -> [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/prooph/improoph)
4. Have fun and learn!


*Note: Some tasks depend on others and some can be split into sub tasks. Let's discuss this in the issues. And of course you
can also work together. Sharing work doubles knowledge!*

## HALL OF FAME

A successfully merged pull request will add you to the HALL OF FAME!

### Features

- [x] Project set up, register user, post todo - done by [people at prooph](https://github.com/orgs/prooph/people)
- [ ] [Mark a todo as done](https://github.com/prooph/proophessor-do/issues/1) - done by [your name here]
- [ ] [Reopen a todo](https://github.com/prooph/proophessor-do/issues/2) - done by [your name here]
- [ ] Add deadline to todo - done by [your name here]
- [ ] Add reminder for assignee - done by [your name here]
- [ ] Mark a todo as expired - done by [your name here]
- [ ] Notify assignee when todo deadline is expired - done by [your name here]
- [ ] Notify assignee when reminder time is reached - done by [your name here]
- more features will follow ...

## Support

- Ask questions on [prooph-users](https://groups.google.com/forum/?hl=de#!forum/prooph) mailing list.
- File issues at [https://github.com/prooph/proophessor-do/issues](https://github.com/prooph/proophessor-do/issues).
- Say hello in the [prooph gitter](https://gitter.im/prooph/improoph) chat.

Happy messaging!
