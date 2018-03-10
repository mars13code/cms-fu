<?php

tracerVisit();

// http://php.net/manual/fr/function.ob-get-clean.php
$codeResponse = ob_get_clean();

// finir le timer
$timerLog  = startTimer();
$debugBody =
    <<<CODEHTML
<pre>
$timerLog
</pre>



CODEHTML;

if ($codeResponse != "") {
    $codeResponse = str_replace("</body>", "$debugBody</body>", $codeResponse);
    echo $codeResponse;
} else {
    echo $debugBody;
    ajouterErreurSQL();
}
