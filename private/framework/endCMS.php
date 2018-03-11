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

ajouterAction("foot", "1000-cms", $debugBody);

$extension = lireOption("cms.extension");
if (in_array($extension, [ "jpg", "png", "gif" ]))  {
    echo $codeResponse;
}
elseif ($codeResponse != "") {
    $cmsHeader = ajouterAction("head");
    $cmsFooter = ajouterAction("foot");
    
    $codeResponse = str_replace("</head>", "$cmsHeader</head>", $codeResponse);
    $codeResponse = str_replace("</body>", "$cmsFooter</body>", $codeResponse);
    echo $codeResponse;
} else {
    echo $debugBody;
    ajouterErreurSQL();
}
