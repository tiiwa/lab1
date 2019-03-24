# Tiiwa - Lab 1
Database of Africans developing Africa

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

What things you need to install the software and how to install them

- Git [https://git-scm.com/]
- Composer [https://getcomposer.org/]
- npm [https://www.npmjs.com/]

### Installing

- Download from Git

        git clone https://github.com/tiiwa/lab1

- Install composer packages from composer.json (php files)

        composer install

- Install npm packages from package.json (js files)

        npm install
        npm update

- Create a database on your local machine

- Copy `.env.example` to `.env` and fill in the values with your local configuration

- Generate Unique App Key

        php artisan key:generate

- Prepare your Local Database Instance

        php artisan migrate #export databalse tables/structure
        php artisan migrate --seed #export and fill database with dummy values
        php artisan migrate:refresh --seed #delete and re-export database and fill with dummy values

- Expose links to storage directory at /storage

        php artisan storage:link

- Setup JWT Tokens

        php artisan jwt:secret

- Generate compiled assets

        npm run dev #compile for local developement
        npm run prod #compile for production
        npm run watch #compile and watch for file changes

- Run the app

        php artisan serve
        
        
###Development Best Practice
        
- Linting your code

	####PHP 
	- Install [PHP Coding Standards Linter](http://cs.sensiolabs.org/)
	- Run ```npm run phplint```
	
	####Javascript/Vue
	- ESLint should already be installed after running ```npm install```
	- Run ```npm run eslint``` to see errors
	- Run ```npm run eslint-fix``` to attempt to fix errors
	
 <br>      

###Useful Tools

- [LiveReload](https://chrome.google.com/webstore/detail/livereload/jnihajbhpnppcggbcgedagnkighmdlei?hl=en)
- [PHP Coding Standards Linter](http://cs.sensiolabs.org/)
- [ESLint](https://eslint.org/)
- [VueJS ESLint Plugin](https://github.com/vuejs/eslint-plugin-vue)

## Built With

* [Laravel](https://laravel.com/) - The backend & api system php framework
* [Vue](https://vuejs.org/) - The Web frontend framework

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the tags on this repository. 

## Authors

* **Oluchi** - *Project Management* - [Contact](http://linkedin.com)
* **Toluwa** - *Project Management* - [Contact](http://linkedin.com)
* **Ian** - *Project Management & Development* - [Contact](http://linkedin.com)
* **Ted** - *Research* - [Contact](http://linkedin.com)
* **Margaret** - *Research* - [Contact](http://linkedin.com)
* **Temi** - *Research* - [Contact](http://linkedin.com)
* **Seyitan** - *Design & Development* - [Contact](http://linkedin.com)
* **Yaw Owusu-Ansah** - *Development* - [Website]http://jyoansah.me)
