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
        var viewUrl = "'.CHtml::normalizeUrl($this->viewUrl).'";
        var parsed = parseUri( viewUrl );

        // if the URL contains a query string, remove it and render it as
        // hidden input elements
        // @see "http://stackoverflow.com/questions/901115/get-query-string-values-in-javascript#answer-2880929"
        var urlParams = {};
        (function (query) {
            var e,
                a = /\+/g,  // Regex for replacing addition symbol with a space
                r = /([^&=]+)=?([^&]*)/g,
                d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
                q = query; // window.location.search.substring(1);

            while (e = r.exec(q))
               urlParams[d(e[1])] = d(e[2]);
        })(parsed.query);

        var queryInputs = "";
        $.each( urlParams, function(key, value) {
          queryInputs += \'<input type="hidden" name="\' + key + \'" value="\' + value + \'" />\';
        });

        var resultId = ui.item.'.$this->resultId.';
        var viewFormHtml = \'<form action="\' + viewUrl + \'" method="get">\
          \' + queryInputs + \'\
          <input type="hidden" value="\' + resultId + \'" name="id" />\
          <input name="" type="submit" value="Go" />\
        </form>\';

        $(viewFormHtml)
          .appendTo("body")
          .submit()
        ;

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
