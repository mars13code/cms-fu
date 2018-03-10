<?php

tracerVisit();

// http://php.net/manual/fr/function.ob-get-clean.php
$codeResponse = ob_get_clean();


if ($codeResponse != "") {
    $timerLog = startTimer();
    $debugBody =
<<<CODEHTML
<pre>
    $timerLog
</pre>

    </body>
    
CODEHTML;
    $codeResponse = str_replace("</body>", $debugBody, $codeResponse);
    echo $codeResponse;
}
else
    ajouterErreurSQL();