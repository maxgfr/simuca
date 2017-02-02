<?php
    echo "</br><h5>Une erreur s'est produite lors de la connexion : </h5>" ;
    foreach ($model->getError()  as $error) {
        echo "<p>".$error."</p>";
    }
    $_POST = array();
?>