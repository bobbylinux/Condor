<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Conferma Iscrizione a Condor</h2>

        <div>
            Grazie per esserti iscritto al nostro sito e-commerce.
            Per confermare la tua iscrizione ti preghiamo di fare click sul link sottostante<br/>
            {!! URL::to('signin/verify/' . $codice) !!}.<br/>

        </div>

    </body>
</html>