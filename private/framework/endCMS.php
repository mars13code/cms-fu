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

$extension = lireOption("cms.extension");
if (in_array($extension, [ "jpg", "png", "gif" ]))  {
    echo $codeResponse;
}
elseif ($codeResponse != "") {
    $codeResponse = str_replace("</body>", "$debugBody</body>", $codeResponse);
    echo $codeResponse;
} else {
    echo $debugBody;
    ajouterErreurSQL();
}
