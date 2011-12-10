<?php

/**
 * Description of ConfigurableModelBehavior
 * @author Benjamin
 */
class ConfigurableBehavior extends CBehavior
{
  public $moduleClass     = '';
  public $moduleInstance  = null;

  public function attach($owner)
  {
    parent::attach($owner);
    
    $currentModule = Yii::app()->getController()->getModule();
    if ($currentModule instanceof $this->moduleClass) {
      $this->moduleInstance = $currentModule;
    }
  }

  public function setModuleInstance( $module )
  {
    if (!$module instanceof $this->moduleClass) {
      throw new CException( "\$module must be an instance of '{$this->moduleClass}'." );
    }
    $this->moduleInstance = $module;
  }

  public function getConfigValue( $key ) {
    return $this->moduleInstance->$key;
  }
}
