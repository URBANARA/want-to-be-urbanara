# Cash Machine

[Browser](#browser)

[Command line](#command-line)

[API](#api)

[Tests](#tests)

## <a name="browser"></a> Browser

To run a complete web interface, execute:

    php -S localhost:8080 -t ./cash-machine/public/

Open the url `http://localhost:8080` in your browser.

## <a name="command-line"></a> Command Line

To run the apllication from command line, execute:

    php cash-machine/console.php withdraw 300

Response:

    Result: [100, 100, 100]

### Amount

Add the argument `--amount` to display the total amount

    php cash-machine/console.php withdraw 300 --amount

Response:

    Amount: 300.00
    Result: [100, 100, 100]

### Pretty

Add the argument `--pretty` to get a better output

    php cash-machine/console.php withdraw 380 --amount --pretty

Response:

    Amount: 380.00
    Result: [
      3 x 100.00
      1 x 50.00
      1 x 20.00
      1 x 10.00
    ]

## <a name="api"></a> API

You can request the withdraw from our API and receive a JSON response

### Starting application

    php -S localhost:8080 -t ./cash-machine/public/

### Performing a request

Tell the value to withdraw using the route:
    
    GET /api/v1/withdraw/:value

E.g:

    curl http://localhost:8080/api/v1/withdraw/380

Response:

    {
        "notes": {
            "10": 1,
            "100": 3,
            "20": 1,
            "50": 1
        }
    }

### Handling errors

If the API can't process the request, you will receive an error message:

    curl http://localhost:8080/api/v1/withdraw/385

Response:

    {
        "error": "Note unavailable: 5",
        "unvailableNote": 5
    }


## <a name="tests"></a> Tests

To run tests:

    cd cash-machine
    vendor/bin/phpunit


## Deploy Heroku

To deploy application

    git subtree push --prefix cash-machine heroku master
