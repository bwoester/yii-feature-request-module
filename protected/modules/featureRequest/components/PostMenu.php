<?php

Yii::import( 'zii.widgets.CMenu', true );

class PostMenu extends CMenu
{
  const GET   = 'GET';
  const POST  = 'POST';
  
	protected function renderMenuItem( $item )
	{
		if (isset($item['url']) && is_array($item['url']) &&
        isset($item['method']) && $item['method'] === PostMenu::POST)
		{
      $route  = isset($item['url'][0]) ? array($item['url'][0]) : '';
      $params = isset($item['url'][1]) ? $item['url'][1] : array();
      
      $html = '<div>' . CHtml::beginForm( $route );
      
      foreach ($params as $key => $value) {
        $html .= CHtml::hiddenField( $key, $value );
      }
      
      $html .= CHtml::submitButton( $item['label'] );
      $html .= CHtml::endForm() . '</div>';
      
      return $html;
    }
    else {
      return parent::renderMenuItem( $item );
    }
	}
  
}
