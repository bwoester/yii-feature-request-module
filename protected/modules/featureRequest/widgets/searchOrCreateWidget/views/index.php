<?php

/* @var $this SearchOrCreateWidget */

echo CHtml::beginForm( $this->searchUrl, 'get' );

$this->widget('zii.widgets.jui.CJuiAutoComplete', $this->CJuiAutoComplete );

echo CHtml::submitButton('search');

echo CHtml::endForm();
