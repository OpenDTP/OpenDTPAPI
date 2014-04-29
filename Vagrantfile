require 'yaml'

def plugin(name, version = nil, opts = {})
	@vagrant_home ||= opts[:home_path] || ENV['VAGRANT_HOME'] || "#{ENV['HOME']}/.vagrant.d"

	if !File.exist?("#@vagrant_home/plugins.json") || !File.file?("#@vagrant_home/plugins.json")
		if File.file?("@vagrant_home/plugins.json")
			print 'Invalid file ' + @vagrant_home + '/plugins.json'
			return
		end
		File.open("#@vagrant_home/plugins.json", 'w') {|f| f.write('{"version":"1","installed":{}}') }
		print 'Successfully created ' + @vagrant_home + '/plugins.json' + $/
	end

	plugins = JSON.parse(File.read("#@vagrant_home/plugins.json"))

	if !plugins['installed'].include?(name) || (version && !version_matches(name, version))

		# Inform user of plugin installation
		print 'Installing plugin ' + name
		if version
			print '(' + version + ')'
		end
		print '. This can take a few minutes ...' + $/

		cmd = "vagrant plugin install"
		cmd << " --entry-point #{opts[:entry_point]}" if opts[:entry_point]
		cmd << " --plugin-source #{opts[:source]}" if opts[:source]
		cmd << " --plugin-version #{version}" if version
		cmd << " #{name}"

		result = %x(#{cmd})
		print result

		# Refreshing Gems and loading newly installed plugin
		print 'Loading plugin ' + name + $/
		Gem::refresh()
		require name
	end
end

def version_matches(name, version)
	gems = Dir["#@vagrant_home/gems/specifications/*"].map { |spec| spec.split('/').last.sub(/\.gemspec$/,'').split(/-(?=[\d]+\.?){1,}/) }
	gem_hash = {}
	gems.each { |gem, v| gem_hash[gem] = v }
	gem_hash[name] == version
end

dir = File.dirname(File.expand_path(__FILE__))

configValues = YAML.load_file("#{dir}/puphpet/config.yaml")
data = configValues['vagrantfile-local']

Vagrant.configure("2") do |config|

	config.vm.box = "#{data['vm']['box']}"
	config.vm.box_url = "#{data['vm']['box_url']}"

	if data['vm']['hostname'].to_s != ''
		config.vm.hostname = "#{data['vm']['hostname']}"
	end

	data['vm']['network']['forwarded_port'].each do |i, port|
		if port['guest'] != '' && port['host'] != ''
			config.vm.network :forwarded_port, guest: port['guest'].to_i, host: port['host'].to_i
		end
	end

	data['vm']['synced_folder'].each do |i, folder|
		if folder['source'] != '' && folder['target'] != '' && folder['id'] != ''
			nfs = (folder['nfs'] == "true") ? "nfs" : nil
			config.vm.synced_folder "#{folder['source']}", "#{folder['target']}", id: "#{folder['id']}", type: nfs
		end
	end

	config.vm.usable_port_range = (10200..10500)

	if !data['vm']['provider']['virtualbox'].empty?
		config.vm.provider :virtualbox do |virtualbox|
			data['vm']['provider']['virtualbox']['modifyvm'].each do |key, value|
				if key == "natdnshostresolver1"
					value = value ? "on" : "off"
				end
				virtualbox.customize ["modifyvm", :id, "--#{key}", "#{value}"]
			end
		end
	end

	config.vm.provision "shell" do |s|
		s.path = "puphpet/shell/initial-setup.sh"
		s.args = "/vagrant/puphpet"
	end
	config.vm.provision :shell, :path => "puphpet/shell/update-puppet.sh"
	config.vm.provision :shell, :path => "puphpet/shell/librarian-puppet-vagrant.sh"

	config.vm.provision :puppet do |puppet|
		ssh_username = !data['ssh']['username'].nil? ? data['ssh']['username'] : "vagrant"
		puppet.facter = {
			"ssh_username" => "#{ssh_username}"
		}
		puppet.manifests_path = "#{data['vm']['provision']['puppet']['manifests_path']}"
		puppet.manifest_file = "#{data['vm']['provision']['puppet']['manifest_file']}"

		if !data['vm']['provision']['puppet']['options'].empty?
			puppet.options = data['vm']['provision']['puppet']['options']
		end
	end

	config.vm.provision :shell, :path => "puphpet/shell/execute-files.sh"

	if !data['ssh']['host'].nil?
		config.ssh.host = "#{data['ssh']['host']}"
	end
	if !data['ssh']['port'].nil?
		config.ssh.port = "#{data['ssh']['port']}"
	end
	if !data['ssh']['private_key_path'].nil?
		config.ssh.private_key_path = "#{data['ssh']['private_key_path']}"
	end
	if !data['ssh']['username'].nil?
		config.ssh.username = "#{data['ssh']['username']}"
	end
	if !data['ssh']['guest_port'].nil?
		config.ssh.guest_port = data['ssh']['guest_port']
	end
	if !data['ssh']['shell'].nil?
		config.ssh.shell = "#{data['ssh']['shell']}"
	end
	if !data['ssh']['keep_alive'].nil?
		config.ssh.keep_alive = data['ssh']['keep_alive']
	end
	if !data['ssh']['forward_agent'].nil?
		config.ssh.forward_agent = data['ssh']['forward_agent']
	end
	if !data['ssh']['forward_x11'].nil?
		config.ssh.forward_x11 = data['ssh']['forward_x11']
	end
	if !data['vagrant']['host'].nil?
		config.vagrant.host = data['vagrant']['host'].gsub(":", "").intern
	end

end

