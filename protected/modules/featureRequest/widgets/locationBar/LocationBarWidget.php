<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Yii::import( 'zii.widgets.jui.CJuiInputWidget', true );

/**
 * Description of LocationBarWidget
 *
 * @author Benjamin
 */
class LocationBarWidget extends CJuiInputWidget
{
  /**
   * Route to the action that renders the create model view
   * @var mixed string or array used to build route
   */
  // public $createUrl = '';

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
  // public $displayAttribute = '';

  /**
   * Will be used on hovering the result items to update the autocomplete value
   * @var string
   */
  // public $resultId = '';

  private $_pluginUrl = '';

  /////////////////////////////////////////////////////////////////////////////

  public function init()
  {
    parent::init();
    $this->publishAssets();

    if (!isset($this->options['autocomplete'])) {
      $this->options['autocomplete'] = array();
    }

    $this->options['viewUrl'] = CHtml::normalizeUrl( $this->viewUrl );

//    if (!isset($this->autoCompleteOptions['options']['focus']))
//    {
//      $this->autoCompleteOptions['options']['focus'] = 'js:function( event, ui ) {
//        var hoveredText = ui.item.'.$this->resultDisplay.';
//        var decoded = $("<div/>").html( hoveredText ).text();
//        $(this).val( decoded );
//
//        return false;
//      }';
//    }

//    if (!isset($this->autoCompleteOptions['options']['select']))
//    {
//      $this->autoCompleteOptions['options']['select'] = 'js:function( event, ui ) {
//        var viewUrl = "'.CHtml::normalizeUrl($this->viewUrl).'";
//        var parsed = parseUri( viewUrl );
//
//        // if the URL contains a query string, remove it and render it as
//        // hidden input elements
//        // @see "http://stackoverflow.com/questions/901115/get-query-string-values-in-javascript#answer-2880929"
//        var urlParams = {};
//        (function (query) {
//            var e,
//                a = /\+/g,  // Regex for replacing addition symbol with a space
//                r = /([^&=]+)=?([^&]*)/g,
//                d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
//                q = query; // window.location.search.substring(1);
//
//            while (e = r.exec(q))
//               urlParams[d(e[1])] = d(e[2]);
//        })(parsed.query);
//
//        var queryInputs = "";
//        $.each( urlParams, function(key, value) {
//          queryInputs += \'<input type="hidden" name="\' + key + \'" value="\' + value + \'" />\';
//        });
//
//        var resultId = ui.item.'.$this->resultId.';
//        var viewFormHtml = \'<form action="\' + viewUrl + \'" method="get">\
//          \' + queryInputs + \'\
//          <input type="hidden" value="\' + resultId + \'" name="id" />\
//          <input name="" type="submit" value="Go" />\
//        </form>\';
//
//        $(viewFormHtml)
//          .appendTo("body")
//          .submit()
//        ;
//
//        return false;
//      }';
//    }
  }

  /////////////////////////////////////////////////////////////////////////////

  public function run()
  {
		list($name,$id) = $this->resolveNameID();

		if (isset($this->htmlOptions['id'])) {
			$id = $this->htmlOptions['id'];
    } else {
			$this->htmlOptions['id'] = $id;
    }

		if (isset($this->htmlOptions['name'])) {
			$name = $this->htmlOptions['name'];
      unset( $this->htmlOptions['name'] );
    }

    echo CHtml::beginForm( $this->searchUrl, 'GET', $this->htmlOptions );

		if($this->hasModel())
			echo CHtml::activeTextField( $this->model, $this->attribute, array('id'=>false,'name'=>$name) );
		else
			echo CHtml::textField( $name, $this->value, array('id'=>false,'name'=>$name) );

    echo CHtml::submitButton( 'Search', array('name'=>null) );
    echo CHtml::endForm();

		$options = CJavaScript::encode( $this->options );

    $js = "jQuery('#{$id} input[name={$name}]').locationBar($options);";
		$cs = Yii::app()->getClientScript();

		$cs->registerScript( __CLASS__.'#'.$id, $js );
  }

  /////////////////////////////////////////////////////////////////////////////

  private function publishAssets()
  {
    /* @var $am CAssetManager */
    $am = Yii::app()->assetManager;
    $this->_pluginUrl = $am->publish( dirname(__FILE__).'/js/jquery.locationBar.js' );

    /* @var $cs CClientScript */
    $cs = Yii::app()->clientScript;
    $cs->registerScriptFile( $this->_pluginUrl, CClientScript::POS_END );
  }

  /////////////////////////////////////////////////////////////////////////////

}
