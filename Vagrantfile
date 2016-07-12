# -*- mode: ruby -*-
# vi: set ft=ruby :

# global configuration
VAGRANTFILE_API_VERSION = "2"
VAGRANT_BOX = "ubuntu/trusty64"
VAGRANT_BOX_MEMORY = 2048
VIRTUAL_BOX_NAME = "proophessordo"

# only change these lines if you know what you do
Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    config.vm.box = VAGRANT_BOX
    config.vm.hostname = VIRTUAL_BOX_NAME + ".dev"

    # configure vhost ports, more vhosts => more port forwarding definitions
    config.vm.network :forwarded_port, guest: 8080, host: 8080
    config.vm.network :forwarded_port, guest: 443, host: 443

    # for z-ray docker image
    config.vm.network :forwarded_port, guest: 10081, host: 10081
    config.vm.network :forwarded_port, guest: 10082, host: 10082

    config.vm.synced_folder ".", "/vagrant"

    # forward ssh requests for public keys
    config.ssh.forward_agent = true

    # ensure box name
    config.vm.define VIRTUAL_BOX_NAME do |t|
    end

    # configure virtual box
    config.vm.provider :virtualbox do |vb|
        vb.name = VIRTUAL_BOX_NAME
        vb.customize ["modifyvm", :id, "--memory", VAGRANT_BOX_MEMORY]
    end

    config.vm.provision :docker
    config.vm.provision :docker_compose, yml: "/vagrant/docker-compose.yml", rebuild: false, run: "always"
    config.vm.provision "shell", inline: "cd /vagrant && docker run --rm -it --volume $(pwd):/app prooph/composer:5.6 install -o --prefer-dist"
    config.vm.provision "shell", inline: "cd /vagrant && docker run --rm -it --volume $(pwd):/app prooph/composer:5.6 require prooph/event-store-doctrine-adapter -o --prefer-dist"
    config.vm.provision "shell", inline: "cd /vagrant && docker-compose run --rm php sh bin/setup_mysql.sh"
end
