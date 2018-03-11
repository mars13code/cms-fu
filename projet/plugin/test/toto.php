<?php

ajouterControllerDir(__DIR__ . "/controller");

$GLOBALS["hello"] = 
<<<CODEHTML
<p><a href="#">COUCOU</a></p>
CODEHTML;

$codeFoot = 
<<<CODEHTML

<script>
console.log("hello");
</script>

CODEHTML;

ajouterHtmlFoot("100-test", $codeFoot);
