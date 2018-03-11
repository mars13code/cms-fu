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

ajouterHtmlFoot("1000-cms", $debugBody);

$extension = lireOption("cms.extension");
if (in_array($extension, [ "jpg", "png", "gif" ]))  {
    echo $codeResponse;
}
elseif ($codeResponse != "") {
    $cmsHeader = ajouterHtmlHead();
    $cmsFooter = ajouterHtmlFoot();
    
    $codeResponse = str_replace("</header>", "$cmsHeader</header>", $codeResponse);
    $codeResponse = str_replace("</body>", "$cmsFooter</body>", $codeResponse);
    echo $codeResponse;
} else {
    echo $debugBody;
    ajouterErreurSQL();
}
