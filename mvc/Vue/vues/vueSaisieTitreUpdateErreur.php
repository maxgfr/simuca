<?php
    echo "</br><h5>Une erreur s'est produite lors de la mise à jour du titre: </h5>" ;
    foreach ($model->getError()  as $error) {
        echo "<p>".$error."</p>";
    }
?>