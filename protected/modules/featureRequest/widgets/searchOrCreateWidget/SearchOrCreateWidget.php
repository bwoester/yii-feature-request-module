<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchOrCreateWidget
 *
 * @author Benjamin
 */
class SearchOrCreateWidget extends CWidget
{
  /**
   * options passed to CJuiAutoComplete
   * @var array
   */
  public $CJuiAutoComplete = array();

  /**
   * If set, overrides CJuiAutoComplete.source
   * @var mixed string or array used to build route
   */
  public $searchUrl = null;

  /**
   * Route to the action that renders the create model view
   * @var mixed string or array used to build route
   */
  public $createUrl = '';

  public function run()
  {
    $this->render('index');
  }

}
