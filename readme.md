<a name="top"></a>

* [during dev](#during-dev)
* [first time clone](#first-time-clone)
* [setup once per dev machine](#setup-once)


# kevin-practice Clone Guide

## Prerequisites

* php env (7.0.\*)
* composer
* finish section below `setup once per dev machine`

***

<a name="during-dev"></a>

## during dev (use when needed)

### install new package

(valet ver)
```
composer install
composer update
```

(dlaravel ver)
```
dc install
dc update
```


### start webpack (compile asset)

```
npm run dev
```

* compile minified assets
```
npm run production
```

* keep compiling during development
```
npm run watch
or
npm run watch-poll
```

### fix class not found

(valet ver)
```
composer dump-auto
```

(dlaravel ver)
```
dc dump-auto
```

### start containers (only for dlaravel)

```
cd ~/Sites/dlaravel
./console up
```

### check running container (only for dlaravel)
```
docker ps
```

### check all container (only for dlaravel)
```
docker ps -a
```

### check all using port (only for dlaravel)
```
docker ps --format "{{.ID}} -- {{.Names}}: {{.Ports}}"
```

### migrate db

(valet ver)
```
php artisan migrate
```

(dlaravel ver)
```
da migrate
```

### rollback db

(valet ver)
```
php artisan migrate:rollback
```

(dlaravel ver)
```
da migrate:rollback
```

### seed db

(valet ver)
```
php artisan db:seed
```

(dlaravel ver)
```
da db:seed
```

[Back To Top](#top)

***

<a name="first-time-clone"></a>

## first time clone (step by step)

### clone repo

```
git clone [repo_url]
cd kevin-practice
```

```
git checkout dev
```

### copy config
```
cp .env.example .env
```

### copy composer.lock
```
cp composer.lock.pre compose.lock
```

### install php package

(valet ver)
```
composer install
```

(dlaravel ver)
```
dc install
```

### install js package
```
npm install
```

### generate app key

(valet ver)
```
php artisan key:generate
```

(dlaravel ver)
```
da key:generate
```

### set laravel env
set db setting in `.env`

(valet ver)
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=kevin-practice
DB_USERNAME=root
DB_PASSWORD={your_own_mysql_password}
```

(dlaravel ver)
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=kevin-practice
DB_USERNAME=kevin-practice
DB_PASSWORD=kevin-practice
```

### compile asset
```
npm run dev
```

### setup host and database
(valet ver)
add database `kevin-practice` to your mysql server (via sequel pro or phpmyadmin or something else)

(dlaravel ver)
```
cd ~/Sites/dlaravel
./create --host kevin-practice
./create --db kevin-practice
```

### check dev site
- go to browsers then enter http://kevin-practice.test:8888

[Back To Top](#top)

***

<a name="setup-once"></a>

## setup once per dev machine

### set alias

edit `~/.zshrc` or `~/.bashrc`

```
alias phpunit="vendor/bin/phpunit"

alias da='docker-compose -f ~/Sites/dlaravel/docker-compose.yml exec -u dlaravel php php $(basename ${PWD})/artisan'

function dc() {
	if [ $(basename ${PWD}) = "sites" ]; then
		docker-compose -f ~/Sites/dlaravel/docker-compose.yml exec -u dlaravel php composer -d=./ $@
	else
		docker-compose -f ~/Sites/dlaravel/docker-compose.yml exec -u dlaravel php composer -d=$(basename ${PWD}) $@
	fi
}

container() {
	docker exec -i -t $@ /bin/bash ;
}

```

reload shell setting

```
source ~/.zshrc
```
or
```
source ~/.bashrc
```

### setup valet or dlaravel
please go to [dev_1_Setup_your_dev_machine.md](https://github.com/Fontech/laravel_document/blob/dev/laravel55%20%2B%20next/dev_1_Setup_your_dev_machine.md) `Laravel Environment Setup Guide for Mac` section