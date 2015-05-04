# proophessor example application
including exercises!

## What's going on here?

Proophessor is a CQRS + ES module for Zend Framework 2. You can learn more about it by reading the [official documentaion](http://prooph.github.io/proophessor/).


This repository contains an example implementation of a small domain served by a PHP web application. 
[Proophessor](https://github.com/prooph/proophessor) powers the M part and [ZF2](https://github.com/zendframework/zf2) the V and C part of the
MVC stack. Database connection is managed with the help of [doctrine](https://github.com/doctrine) seamlessly integrated through
the [prooph/event-store-doctrine-adapter](https://github.com/prooph/event-store-doctrine-adapter) on the write side and the
[DoctrineORMModule](https://github.com/doctrine/DoctrineORMModule) on the read side.

