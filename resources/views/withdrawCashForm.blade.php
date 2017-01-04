<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Cash Unlimited</title>

        <!-- Bootstrap -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="/css/styles.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">

            <form
                class="form-account"
                method="POST"
                action="{{ action('AccountController@withdraw') }}">
                {{ csrf_field() }}

                <input hidden="operation" value="withdraw">
                <h2 class="form-account-heading">Unlimited Cash</h2>

                <div
                    class="form-group{{
                        $errors->has('cash')
                        ? ' has-error'
                        : ''
                    }} has-feedback">
                    <label for="cash" class="sr-only">Value to withdraw</label>
                    <input
                        id="cash"
                        class="form-control"
                        name="cash"
                        placeholder="Value"
                        required
                        autofocus
                        type="text">
                    <span
                        class="glyphicon glyphicon-usd form-control-feedback">
                    </span>
                    @if ($errors->has('cash'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cash') }}</strong>
                        </span>
                    @endif
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    withdraw
                </button>
            </form>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
    </body>
</html>
