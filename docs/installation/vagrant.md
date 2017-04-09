# Installation using Vagrant
Please install the following software if not already installed:

* [Vagrant (tested with 1.9.3)](http://www.vagrantup.com/downloads.html)
* [Virtualbox >= 5.0](https://www.virtualbox.org/wiki/Downloads)
* [Vagrant docker-compose plugin](https://github.com/leighmcculloch/vagrant-docker-compose) (`vagrant plugin install vagrant-docker-compose`)


1.) Please follow the "Configuration" section from [docker Instructions](docker.md#step-3-configuration)
2.) Then run:
```bash
$: vagrant up
```

All dependencies will be downloaded. This may take a while ...

Now open [http://localhost:8080](http://localhost:8080/) and have fun.
