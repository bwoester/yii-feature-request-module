<?php

/* @var $this SearchOrCreateWidget */

echo CHtml::form( $this->createUrl );

$this->widget('zii.widgets.jui.CJuiAutoComplete', $this->CJuiAutoComplete );

echo CHtml::submitButton('create');

echo CHtml::endForm();
