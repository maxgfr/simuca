<?php
	foreach($model->getData() as $titre){
			echo TitreView::getHtmlDevelopped($titre);
		}
?>