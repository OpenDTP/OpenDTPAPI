Core module
===========

Summary
-------

Core module manage users and companies and set some tools required in other OpenDTP API modules.

### Services ###

* [Assets](#assets)

Services
--------

### Assets ###

This Assets service is made to manage applications dynamic assets like users avatar or companies logo.
You can access to this service using `App\Modules\Core\Support\Facade\Assets` façade. You can use custom adapters to perform custom actions with assets.

#### Configuration ####

You can configure Assets service with `opendtp/assets.php` configuration file. Here a configuration sample :

    return array(
    
        'store' => storage_path() . '/assets',
        'users' => [
            'path' => 'users',
            'adapter' => 'App\Modules\Core\Assets\Standard',
            'url' => '/assets/users'
        ]
    
    );

* `store` : main asset store, where all files are stored
* `users` : adapter name
* `path` : path to upload files in store
* `adapter` : adapter class
* `url` : if there's an external access, the root url to access ressource