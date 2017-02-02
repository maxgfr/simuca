<?php
    echo "<h5>Une erreur s'est produite </h5>" ;
    foreach ($model->getError()  as $error) {
        echo "<p>".$error."</p>";
    }
?>