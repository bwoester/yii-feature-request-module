<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Yii::import( 'zii.widgets.jui.CJuiWidget', true );

/**
 * Description of SearchOrCreateWidget
 *
 * @author Benjamin
 */
class SearchOrCreateWidget extends CJuiWidget
{
  /**
   * options passed to CJuiAutoComplete
   * @var array
   */
  public $CJuiAutoComplete = array();

  /**
   * Route to the action that renders the create model view
   * @var mixed string or array used to build route
   */
  public $createUrl = '';

  /**
   * Route to the action that renders the search results
   * @var mixed string or array used to build route
   */
  public $searchUrl = '';

  /**
   * Route to the action that views one selected result
   * @var mixed string or array used to build route
   */
  public $viewUrl = '';

  /**
   * Will be used on hovering the result items to update the autocomplete value
   * @var string
   */
  public $resultDisplay = '';

  /**
   * Will be used on hovering the result items to update the autocomplete value
   * @var string
   */
  public $resultId = '';

  private $_searchOrCreatePluginUrl = '';

  /////////////////////////////////////////////////////////////////////////////

  public function init()
  {
    parent::init();
    $this->publishAssets();

    if (!isset($this->CJuiAutoComplete['options'])) {
      $this->CJuiAutoComplete['options'] = array();
    }

    if (!isset($this->CJuiAutoComplete['options']['focus']))
    {
      $this->CJuiAutoComplete['options']['focus'] = 'js:function( event, ui ) {
        var hoveredText = ui.item.'.$this->resultDisplay.';
        var decoded = $("<div/>").html( hoveredText ).text();
        $(this).val( decoded );

        return false;
      }';
    }

    if (!isset($this->CJuiAutoComplete['options']['select']))
    {
      $this->CJuiAutoComplete['options']['select'] = 'js:function( event, ui ) {
        var hoveredText = ui.item.'.$this->resultDisplay.';
        var decoded = $("<div/>").html( hoveredText ).text();
        $(this).val( decoded );

        $(this).siblings( "input[type=submit]" ).val( "Go" );
        $(this).siblings( "input[type=hidden]" ).attr( "name", "id" );
        $(this).siblings( "input[type=hidden]" ).val( ui.item.'.$this->resultId.' );
        $(this).closest( "form" ).attr( "action", "'.CHtml::normalizeUrl($this->viewUrl).'" );
        
        // TODO: for some reason, this will cause a search, although the the form action has been modified..
        // $(this).closest( "form" ).submit();

        return false;
      }';
    }
  }

  /////////////////////////////////////////////////////////////////////////////

  public function run()
  {
    $this->render('index');
  }

  /////////////////////////////////////////////////////////////////////////////

  private function publishAssets()
  {
    /* @var $am CAssetManager */
    $am = Yii::app()->assetManager;
    $this->_searchOrCreatePluginUrl = $am->publish( dirname(__FILE__).'/js/jquery.searchOrCreate.js' );

    /* @var $cs CClientScript */
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile( $this->_searchOrCreatePluginUrl, CClientScript::POS_END );
  }

  /////////////////////////////////////////////////////////////////////////////

}
