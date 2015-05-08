<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Richiesta Reset Password</h2>

        <div>
            Di seguito il link per il reset della tua password<br/>
            {!! URL::to('password/reset/' . $codice) !!}.<br/>
        </div>

    </body>
</html>