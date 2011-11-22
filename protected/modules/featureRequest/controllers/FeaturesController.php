<?php

class FeaturesController extends FeatureRequestsBaseController
{

  public function behaviors()
  {
    return array(
      'lazyLoadAbstractUser' => 'LazyLoadAbstractUserBehavior',
    );
  }

  public function actionIndex()
  {
    $dataProvider = FeatureRequest::model()->getHighestRated();
    $this->render( 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }
  
  public function actionShow( $id )
  {
    $featureRequest = FeatureRequest::model()->findByPk( $id );
    $this->render( 'show', array(
      'featureRequest' => $featureRequest,
    ));
  }
  
  public function actionSearch()
  {
    $result = array(
      'Improve User Interface',
      'Add User Profiles',
    );
    
    echo CJSON::encode( $result );
  }

  public function actionCreate()
  {
    $featureRequest = new FeatureRequest();
    $vote = new Vote();

    // create new feature request and redirect to it
    if ( /* isset($_POST['FeatureRequest']) && */ isset($_POST['AbstractMessage']) && isset($_POST['Vote']))
    {
      /* @var $abstractUser AbstractUser */
      $abstractUser = $this->getAbstractUser();
      
      $valid = $abstractUser instanceof AbstractUser;

      if ($valid)
      {
        $featureRequest->message->attributes = $_POST['AbstractMessage'];
        $featureRequest->message->abstract_user_id = $abstractUser->id;
        /* $featureRequest->attributes = $_POST['FeatureRequest']; */
        $featureRequest->status = FeatureRequest::STATUS_NEW;
        
        $valid = $featureRequest->save();
      }
      
      if ($valid)
      {
        $vote->attributes = $_POST['Vote'];
        $vote->abstract_user_id = $abstractUser->id;
        $vote->feature_request_id = $featureRequest->id;
        
        $valid = $vote->save();
      }
      
      if ($valid) {
        $this->redirect( $featureRequest->getUrl() );
      }
    }
    // pre-fill title
    else if (isset($_POST['featureRequestTitle']) && $_POST['featureRequestTitle'] !== '')
    {
      $featureRequest->message->title = $_POST['featureRequestTitle'];
      $featureRequest->message->validate( array('title') );
    }
    
    // displays the form to create a feature request
    $this->render( 'create', array(
      'featureRequest' => $featureRequest,
      'vote' => $vote,
    ));
  }

}