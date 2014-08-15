Phing
=====

OpenDTP use Phing as build project.
More documentation [here](http://www.phing.info/).

Summary
-------

> [Commands](#commands)

### Commands ###
To help you during your developpement we had some usefull commands

* deploy : seed database. run build.
* redeploy : revert all migrations then run deploy.
* build : make storage folders if not exists and run migrations.
* build-dev : make build folders. Run build then quality-analyse.
* quality-analyse : run phpcs, phpmd, phpcpd, phpunit
* phpcs : codestyle analyse build report phpcs-checkstyle.html
* phpmd : code mess analyse build report code_mess.html
* phpcpd : copy paste detection
* phpunit : run phpunit tests