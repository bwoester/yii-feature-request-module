<?php
/* @var $this FeatureRequestWidget */
?>

<div class="featureRequest">

  <div class="featureRequest-sidebar">

    <div class="featureRequest-votes">
      <span class="counter"><?php echo $this->model->voteWeightSum; ?></span>
      <span class="label">Votes</span>
    </div>

    <div class="featureRequest-actions">
      <?php $this->widget('PostMenu',array(
        'items'=>array(
          array(
            'label' => 'Vote',
            'items' => array(
              array(
                'label'   => '1 vote',
                'method'  => PostMenu::POST,
                'url'     => array(
                  'features/vote',
                  array(
                    'featureRequestId'  => $this->model->id,
                    'voteWeight'        => 1,
                  ),
                ),
              ),
              array(
                'label'   => '2 votes',
                'method'  => PostMenu::POST,
                'url'     => array(
                  'features/vote',
                  array(
                    'featureRequestId'  => $this->model->id,
                    'voteWeight'        => 2,
                  ),
                ),
              ),
              array(
                'label'   => '3 votes',
                'method'  => PostMenu::POST,
                'url'     => array(
                  'features/vote',
                  array(
                    'featureRequestId'  => $this->model->id,
                    'voteWeight'        => 3,
                  ),
                ),
              ),
          )),
          array('label'=>'Admin', 'items'=>array(
            array(
              'label'   => 'Accept',
              'method'  => PostMenu::POST,
              'url'     => array(
                'route',
                array(
                  'featureRequestId'  => $this->model->id,
                ),
              ),
            ),
            array(
              'label'   => 'Reject',
              'method'  => PostMenu::POST,
              'url'     => array(
                'route',
                array(
                  'featureRequestId'  => $this->model->id,
                ),
              ),
            ),
          )),
        )
      )); ?>
    </div>

  </div>

  <div class="featureRequest-main-area">

    <h3 class="featureRequest-title"><?php
      echo CHtml::link( $this->model->message->title, $this->model->getUrl() );
    ?></h3>

    <div class="featureRequest-content"><?php
      $this->beginWidget( 'CMarkdown', array('purifyOutput'=>true) );
      echo $this->model->message->content;
      $this->endWidget();
    ?></div>

    <div class="featureRequest-info">
      <?php
        // TODO: implement comments, user profiles, ...
  //    $this->widget('zii.widgets.CMenu',array(
  //			'items'=>array(
  //        array('label'=>'by {TODO: link to author profile}' , 'url'=>array('')),
  //        array('label'=>'{TODO: link to show comments}', 'url'=>array('')),
  //      )
  //		));
      ?>
    </div>

    <div class="featureRequest-status-container">
      <span class="label"><?php echo $this->model->getAttributeLabel( 'status' ); ?></span>
      <span class="status"><?php echo $this->model->status; ?></span>
    </div>

  </div>

</div>
