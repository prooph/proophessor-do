# Debugging with xDebug

Xdebug is a good way to step through the code an learn about the internal structure.

When using the **docker** or **vagrant** installation method you can
enable xdebug by replacing

```yaml
image: prooph/php:7.1-fpm
```
with
```yaml
image: prooph/php:7.1-fpm-xdebug
```
 in the `docker-compose.yml` file.

 **Note**: Port 10000 is using instead of the default Port 9000 with this image. You need to
  configure your IDE to this port.

