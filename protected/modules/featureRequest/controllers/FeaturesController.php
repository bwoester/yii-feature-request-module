<?php

/**
 *
 * @property-read AbstractUser $abstractUser
 */
class FeaturesController extends FeatureRequestsBaseController
{

  /////////////////////////////////////////////////////////////////////////////

  public function accessRules()
  {
    $accessRules = array_merge( array(
      array(
        'allow',
        'actions' =>  array( 'index', 'search', 'show' ),
        'users'   =>  array( '*' ),
      ),
      array(
        'allow',
        'actions' =>  array( 'vote' ),
        'users'   =>  array( '@' ),
      ),
      array(
        'allow',
        'actions' =>  array( 'update' ),
        'roles'   =>  array( 'admin' ),
      ),
    ), parent::accessRules() );

    return $accessRules;
  }

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

  public function actionSearch( $term, $encode=false )
  {
    $model = new FeatureRequest();
    $model->message->title = $term;

    /* @var $dataProvider CActiveDataProvider */
    $dataProvider = $model->search();

    if ($encode === false)
    {
      $this->render('searchResults', array(
        'dataProvider' => $dataProvider,
      ));
    }
    else if (strtolower($encode) === 'json')
    {
      $data = $dataProvider->getData();
      echo FRHelper::jsonEncode( $data, array('message') );
    }
  }

  /////////////////////////////////////////////////////////////////////////////

  public function actionVote()
  {
    $this->checkParams( array('featureRequestId', 'voteWeight') );
    $featureRequest = $this->loadFeatureRequest( $_POST['featureRequestId'] );

    $vote = $featureRequest->userVote;
    $vote->weight = $_POST['voteWeight'];

    if ($vote->save()) {
      Yii::app()->user->setFlash( 'success', 'Your vote has been saved.' );
    } else {
      Yii::app()->user->setFlash( 'error', 'Failed to save your vote.' );
    }

    // display the feature request detail view after voting
    $this->render( 'show', array(
      'featureRequest'  => $featureRequest,
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
          Yii::app()->user->setFlash( 'success', 'Your feature request has been saved.' );
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

  public function actionUpdate()
  {
    $featureRequest = null;
    
    if (isset($_POST['featureRequestId']))
    {
      $featureRequest = $this->loadFeatureRequest( $_POST['featureRequestId'] );
    }
    else
    {
      $this->checkParams(array(
        'FeatureRequest' => array('id'),
      ));      

      $featureRequest = $this->loadFeatureRequest( $_POST['FeatureRequest']['id'] );
      $featureRequest->attributes = $_POST['FeatureRequest'];
      
      if (isset($_POST['AbstractMessage'])) {
        $featureRequest->message->attributes = $_POST['AbstractMessage'];  
      }   
      
      if ($featureRequest->save())
      {
        Yii::app()->user->setFlash( 'success', 'Feature request has been updated.' );

        // display the feature request detail view after updating
        $this->redirect( array('show', 'id'=>$featureRequest->id) );
      }
    }
    
    $this->render( 'update', array(
      'featureRequest' => $featureRequest,
    ));
  }

  /////////////////////////////////////////////////////////////////////////////

  /**
   * @param int $id
   * @return FeatureRequest
   */
	public function loadFeatureRequest( $id )
	{
    $model = FeatureRequest::model()->findByPk( $id );

    if ($model === null) {
      throw new CHttpException( 404, 'Feature request not found.' );
		}

		return $model;
	}

  /////////////////////////////////////////////////////////////////////////////

}