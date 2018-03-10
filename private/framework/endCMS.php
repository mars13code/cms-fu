<?php

// http://php.net/manual/fr/function.ob-get-clean.php
$codeResponse = ob_get_clean();


if ($codeResponse != "")
    echo $codeResponse;
else
    ajouterErreurSQL();