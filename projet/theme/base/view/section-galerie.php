
<section>
    <h3>GALERIE</h3>
    <div class="gallery">
<?php

$tabResult = trouverLigne("Page", "dataType", "upload", "ORDER BY date DESC");
foreach($tabResult as $tabLigne)
{
    extract($tabLigne);
    
    $extension = pathinfo($urlPage, PATHINFO_EXTENSION);
    if (in_array($extension, [ "jpg", "jpeg", "gif", "png" ])) {
    echo
<<<CODEHTML
    <a href="assets/upload/800x800-$urlPage"><img src="assets/upload/320x320-$urlPage"></a>
CODEHTML;
        
    }

}

?>
    </div>
</section>