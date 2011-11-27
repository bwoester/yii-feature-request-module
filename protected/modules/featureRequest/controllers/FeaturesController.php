<?php

/**
 *
 * @property-read AbstractUser $abstractUser
 */
class FeaturesController extends FeatureRequestsBaseController
{

  /////////////////////////////////////////////////////////////////////////////

  public function behaviors()
  {
    return array(
      'lazyLoadAbstractUser' => 'LazyLoadAbstractUserBehavior',
    );
  }

  /////////////////////////////////////////////////////////////////////////////

  public function actionIndex()
  {
    $dataProvider = FeatureRequest::model()->getHighestRated();
    $this->render( 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /////////////////////////////////////////////////////////////////////////////

  public function actionShow( $id )
  {
    $featureRequest = FeatureRequest::model()->findByPk( $id );
    $this->render( 'show', array(
      'featureRequest' => $featureRequest,
    ));
  }

  /////////////////////////////////////////////////////////////////////////////

  public function actionSearch()
  {
    $result = array(
      'Improve User Interface',
      'Add User Profiles',
    );
    
    echo CJSON::encode( $result );
  }

  /////////////////////////////////////////////////////////////////////////////

  public function actionVote()
  {
    if (!isset($_POST['featureRequestId']) || !isset($_POST['voteWeight'])) {
      throw new CHttpException( 400, 'Your request is invalid.' );
    }

    $featureRequest = FeatureRequest::model()->findByPk( $_POST['featureRequestId'] );

    if ($featureRequest instanceof FeatureRequest)
    {
      $vote = $featureRequest->userVote;
      $vote->weight = $_POST['voteWeight'];
      
      if ($vote->save()) {
        Yii::app()->user->setFlash( 'voted', 'Your vote has been saved.' );
      }
    }
    else {
      throw new CHttpException( 404, 'Feature request not found.' );
    }

    // display the feature request detail view after voting
    $this->render( 'show', array(
      'featureRequest'  => $featureRequest,
      'vote'            => $vote,
    ));
  }

  /////////////////////////////////////////////////////////////////////////////

  public function actionCreate()
  {
    $featureRequest = new FeatureRequest();
    $vote = new Vote();

    // create new feature request and redirect to it
    if ( /* isset($_POST['FeatureRequest']) && */ isset($_POST['AbstractMessage']) && isset($_POST['Vote']))
    {
      $abstractUser = $this->abstractUser;
      /* @var $transaction CDbTransaction */
      $transaction = $abstractUser->dbConnection->beginTransaction();

      try
      {
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
          $vote = $featureRequest->getUserVote();
          $vote->attributes = $_POST['Vote'];

          $valid = $vote->save();
        }

        if ($valid)
        {
          $transaction->commit();
          Yii::app()->user->setFlash( 'featureRequestCreated', 'Your feature request has been saved.' );
          $this->redirect( $featureRequest->getUrl() );
        }
        else
        {
          $transaction->rollBack();
        }
      }
      catch(Exception $e)
      {
        $transaction->rollBack();
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

  /////////////////////////////////////////////////////////////////////////////

}