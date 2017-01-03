# About me

Technology amuses me and I believe it can be the problem-solving puzzle-piece for many things in our lives. Therefore I enjoy identifying where technology is most needed and helping on easing that out. I also love rethinking and renewing our ways of doing things so I'm not really into the right/wrong duality, although I'm truly respectful towards best practices.  I'm a generalist programmer most experienced with web-related technologies.

# About the cash-machine solution
I tried to use an extended set of concepts together for providing my resolution to this challenge, where (being very honest) the algorithm part wasn't the most time-consuming one. Time and space complexities are crucial attributes to any algorithm for today's highly-scalable demands so I immediately bet on and looked for Dynamic Functions to solve it.
This PHP project:

* uses few new features of **PHP7** such as scalar type hints, return type declaration and error handling;
* implemented **SPL** interfaces (Countable, ArrayAccess) to provide a customized way of accessing/handling datasets of Notes;
* protected **SOLID** and avoided **STUPID** patterns during its construction;
* uses **phpDocumentor** for generating documentation directly from the source-code;
* uses **phpunit** for unit testing with **100% coverage**;
* is runnable from console but also with a pretty & clean HTML version for in-browser testing;

## How to use it

1. Make sure you have **[composer](https://getcomposer.org/download/)** installed (and use **[PHP7](http://php.net/downloads.php)**).

2. Using your command-line console, within the project's root directory, install the project's dependencies by running:

    `composer install`

3. To run the application from the console, run:

    `php console.php`

4. To see it from a web browser, we'll use the built-in PHP server. Run:

    `php -S localhost:8000`

	... and open http://localhost:8000/ in a new tab.

5. To generate the project's documentation, run:

    `./vendor/bin/phpdoc -t docs -d ./classes/,./interfaces,./exceptions --template='responsive'`

	It will generate your HTML file in the `./doc` directory

6. To execute the Test Suit, run:

    `./vendor/bin/phpunit`

	It will generate a report file in the `./report` directory
