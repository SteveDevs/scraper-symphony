Symfony Scraper.

Requirements: 
Php 7.2 ^

How to run:

    - composer install

    Run tests:
        ./bin/phpunit
    Run Commands:
        app:scrape-right-move-properties [<postal-code>]

        Example: 
        symfony console app:scrape-right-move-properties EC2


How the application can be improved:

- Commands: Have more arguments to increase specificity.
            More advance postal code searching

- Tests: Have tests test upper and lower bounds in a more 
         comprehensive manner.

- Application: App\WebScraper\Scraper->paginate() Should be modified 
               extensively(functions can be abscracted out of it and it should be more generalized).
               Performance optimization: Especailly for postal codes with a large number of properties.
               When scraping error handling needs to implemented

