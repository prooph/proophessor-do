# Technology Stack

## Server Side
- PHP >= 7.1
- [PSR-7](http://www.php-fig.org/psr/psr-7/) middleware layer based on [zend-expressive](https://github.com/zendframework/zend-expressive)
  - IoC Container: [zend-servicemanager](https://github.com/zendframework/zend-servicemanager) v2.6+ with [container-interop](https://github.com/container-interop/container-interop) support
  - Routing: [Aura.Router](https://github.com/auraphp/Aura.Router)
  - Templates: [zend-view](https://github.com/zendframework/zend-view)
- Separate write and read model following the [CQRS approach](https://cqrs.files.wordpress.com/2010/11/cqrs_documents.pdf) by Greg Young
- Communication from and to the domain layer is handled by [prooph/service-bus](https://github.com/prooph/service-bus)
- Event sourced write model is powered by [prooph/event-sourcing](https://github.com/prooph/event-sourcing)
- Domain events are persisted in a [prooph/event-store](https://github.com/prooph/event-store) using the implementation:
  - [pdo-event-store](https://github.com/prooph/pdo-event-store)
- Simple and fast implementation of enumerations: [php-enum](https://github.com/marc-mabe/php-enum)
- Read model persistence is managed with the help of [Doctrine DBAL](https://github.com/doctrine/dbal)
- Interop. factories using [sandrokeil/interop-config](https://github.com/sandrokeil/interop-config)
- [Assertions](https://github.com/beberlei/assert) - well, you know it

## Client Side
- Layout is graped from [http://bootswatch.com](http://bootswatch.com) which is based on [bootstrap](http://getbootstrap.com/)
- User interaction is handled with [riot.js](http://riotjs.com/)
- User input is validated with [validate.js](http://rickharrison.github.io/validate.js/)
- Commands are sent to the server using [jQuery.ajax](https://jquery.com/)
- Server messages are presented by [notify.js](http://notifyjs.com/)
- Datetime objects are handled with [moment.js](http://momentjs.com/)
- Datetime picker support provided by [bootstrap-datetimepicker](http://eonasdan.github.io/bootstrap-datetimepicker/)
- JavaScript UUID generator taken from [https://gist.github.com/duzun/d1bfb5406a362e06eccd](https://gist.github.com/duzun/d1bfb5406a362e06eccd)
- Little helpers: [lodash.js](https://lodash.com/) and [undersocre.string.js](http://gabceb.github.io/underscore.string.site/)
