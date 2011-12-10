<?php

/* @var $this SearchOrCreateWidget */

?>

<div class="searchOrCreate">

<?php
echo CHtml::beginForm( $this->searchUrl, 'get' );

$this->widget('zii.widgets.jui.CJuiAutoComplete', $this->CJuiAutoComplete );
echo CHtml::hiddenField( '' );
echo CHtml::submitButton('Search', array('name'=>''));

echo CHtml::endForm();
?>

</div>

<?php

/* @var $cs CClientScript */
$cs = Yii::app()->clientScript;
$cs->registerScript('searchOrCreate', '
  jQuery(".searchOrCreate").searchOrCreate({
  });
');




