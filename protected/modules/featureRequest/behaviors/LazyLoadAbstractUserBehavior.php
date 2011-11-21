<?php



/**
 * Returns an AbstractUser instance for use in feature request module.
 * Will create AbstractUser records as needed on the fly.
 *
 * @author Benjamin
 */
class LazyLoadAbstractUserBehavior extends CBehavior
{
  private $_abstractUser = null;

  public function getAbstractUser()
  {
    if (!$this->_abstractUser instanceof AbstractUser)
    {
      $this->loadAbstractUser();

      if (!$this->_abstractUser instanceof AbstractUser) {
        $this->createAbstractUser();
      }
    }
    
    return $this->_abstractUser;
  }

  protected function loadAbstractUser()
  {
    $this->_abstractUser = AbstractUser::model()->findByAttributes( array(
      'app_user_id' => $this->getSerializedAppUserNr(),
    ));
  }

  protected function createAbstractUser()
  {
    $this->_abstractUser = new AbstractUser();
    $this->_abstractUser->app_user_id = $this->getSerializedAppUserNr();
    $this->_abstractUser->save();
  }

  protected function getSerializedAppUserNr()
  {
    /* @var $user IWebUser */
    $user = Yii::app()->user;
    $id = serialize( $user->getId() );
    return $id;
  }

}
