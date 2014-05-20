# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

dir = File.dirname(File.expand_path(__FILE__))

configValues = YAML.load_file("#{dir}/vagrant/puppet/config/common.yaml")
data_vm = configValues['vm']
data_ssh = configValues['ssh']

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  # All Vagrant configuration is done here. The most common configuration
  # options are documented and commented below. For a complete reference,
  # please see the online documentation at vagrantup.com.

  # Every Vagrant virtual environment requires a box to build off of.
  config.vm.box = "#{data_vm['box']}"
  config.vm.box_url = "#{data_vm['box_url']}"

  config.vm.hostname = "#{data_vm['hostname']}"
  config.vm.network "private_network", ip: "#{data_vm['network']['private_network']}"

  if !data_vm['network']['forwarded_port'].empty?
    data_vm['network']['forwarded_port'].each do |i, port|
      config.vm.network :forwarded_port, guest: port['guest'].to_i, host: port['host'].to_i
    end
  end

  config.vm.synced_folder ".", "/vagrant", disabled:true
  config.vm.synced_folder "./vagrant", "/vagrant"
  config.vm.synced_folder ".", "/data"

  data_vm['synced_folder'].each do |i, folder|
    if folder['source'] != '' && folder['target'] != '' && folder['id'] != ''
      nfs = (folder['nfs'] == "true") ? "nfs" : nil
      config.vm.synced_folder "#{folder['source']}", "#{folder['target']}", id: "#{folder['id']}", type: nfs
    end
  end

  config.vm.usable_port_range = (10200..10500)

  if !data_vm['provider'].empty?
    config.vm.provider :virtualbox do |virtualbox|
      data_vm['provider']['modifyvm'].each do |key, value|
        if key == "natdnshostresolver1"
          value = value ? "on" : "off"
        end
        virtualbox.customize ["modifyvm", :id, "--#{key}", "#{value}"]
      end
    end
  end

  config.vm.provision "shell" do |s|
    s.path = "vagrant/provision/update-librarian.sh"
    s.args = "/vagrant"
  end

  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = data_vm['provision']['manifests_path']
    puppet.manifest_file = data_vm['provision']['manifest_file']
    if !data_vm['provision']['options'].empty?
      puppet.options = data_vm['provision']['options'].join(' ')
    end
  end

  config.vm.provision "shell" do |s|
    s.path = "vagrant/provision/execute-files.sh"
    s.args = "/vagrant"
  end

end
