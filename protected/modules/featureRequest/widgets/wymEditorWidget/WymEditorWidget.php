<?php

/**
 * EWYMeditor class file.
 *
 * @author Andrius Marcinkevicius <andrew.web@ifdattic.com>
 * @author Benjamin Wöster <benjamin.woester@gmail.com>
 * @copyright Copyright &copy; 2011 Andrius Marcinkevicius
 * @license Licensed under MIT license. http://ifdattic.com/MIT-license.txt
 * @version 1.0
 */

Yii::import( 'zii.widgets.jui.CJuiInputWidget', true );

/**
 * WymEditorWidget adds a WYSIWYM (What You See Is What You Mean) XHTML editor.
 *
 * @author Andrius Marcinkevicius <andrew.web@ifdattic.com>
 * @author Benjamin Wöster <benjamin.woester@gmail.com>
 */
class WymEditorWidget extends CJuiInputWidget
{
  /**
   * @var array the plugins which should be added to editor.
   */
  public $plugins = array();

  /**
   * @var string apply wymeditor plugin to these elements.
   */
  public $target = null;

  private $_wymEditorUrl = '';

  /////////////////////////////////////////////////////////////////////////////

	public function init()
  {
    parent::init();
    $this->publishAssets();
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * Add WYMeditor to the page.
   */
  public function run()
  {
    $id = '';
    
    // Add textarea to the page
    if ($this->target === null)
    {
      list( $name, $id ) = $this->resolveNameID();

      if( $this->hasModel() ) {
        echo CHtml::activeTextArea( $this->model, $this->attribute, $this->htmlOptions );
      } else {
        echo CHtml::textArea( $name, $this->value, $this->htmlOptions );
      }
    }

    // Add the plugins to editor
    $this->addPlugins();

    $selector = $this->target === null ? "#$id" : $this->target;
    $scriptId = "wymEditor_{$selector}";

    // set default update selector to be the submit button in the form
    // containing our selector.
    if (!isset($this->options['updateSelector'])) {
      $this->options['updateSelector'] = "js:jQuery('$selector').closest('form').find('input[type=submit]')";
    }

    $options = CJavaScript::encode( $this->options );

    $cs = $this->getClientScript();
    $cs->registerScript( $scriptId, "
      jQuery('$selector').wymeditor(
        $options
      );
    " );
  }

  /////////////////////////////////////////////////////////////////////////////

  private function publishAssets()
  {
    $am = $this->getAssetManager();
    $wymEditorFilepath = dirname(__FILE__) . '/wymEditor/wymeditor';
    $this->_wymEditorUrl = $am->publish( $wymEditorFilepath );

    $cs = $this->getClientScript();
    $cs->registerScriptFile( $this->_wymEditorUrl . '/jquery.wymeditor.min.js' );
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * Add plugins to the editor.
   */
  private function addPlugins()
  {
    // if user defined custom postInit option, or if no plugins are to be
    // added, simply do nothing.
    if (isset($this->options['postInit']) || empty($this->plugins)) {
      return;
    }

    // Available plugins array
    $plugins = array(
      'hovertools' => array(
        'file' => '/plugins/hovertools/jquery.wymeditor.hovertools.js',
        'init' => 'wym.hovertools();' ),
      'fullscreen' => array(
        'file' => '/plugins/fullscreen/jquery.wymeditor.fullscreen.js',
        'init' => 'wym.fullscreen();' ),
      'tidy' => array(
        'file' => '/plugins/tidy/jquery.wymeditor.tidy.js',
        'init' => 'var wymtidy = wym.tidy();wymtidy.init();' ),
      'resizable' => array(
        'file' => '/plugins/resizable/jquery.wymeditor.resizable.js',
        'init' => 'wym.resizable();' ),
    );

    // Replacement for 'postInit' option
    $postInit = array();

    // If string provided, convert it to an array
    if (is_string($this->plugins))
    {
      $this->plugins = explode( ',', $this->plugins );
      $this->plugins = array_map( 'trim', $this->plugins );
    }

    // Add all available plugins
    foreach ($this->plugins as $plugin)
    {
      if (isset($plugins[$plugin]))
      {
        $cs = $this->getClientScript();
        $cs->registerScriptFile( $this->_wymEditorUrl . $plugins[$plugin]['file'] );
        $postInit[] = $plugins[$plugin]['init'];
      }
      else {
        throw new CException( "Unknown wymEditor plugin: '$plugin'." );
      }
    }

    // Set 'postInit' option
    $this->options['postInit'] = "js:function(wym){" . implode( '', $postInit ) . "}";
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * @return CAssetManager
   */
  private function getAssetManager()
  {
    return Yii::app()->assetManager;
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * @return CClientScript
   */
  private function getClientScript()
  {
    return Yii::app()->clientScript;
  }

  /////////////////////////////////////////////////////////////////////////////

}
