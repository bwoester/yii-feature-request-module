<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'  => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name'      => 'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
    'application.modules.user.models.*',
    'application.modules.user.components.*',      
    'ext.giix-components.*', // giix components
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
      'generatorPaths' => array(
        'ext.giix-core', // giix generators
      ),
			'password'=>'none',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
    'featureRequests'=>array(
      'class'=>'application.modules.featureRequest.featureRequestModule',
      'layout'=>'//layouts/column1',
      // 'maxVoteWeight'=>5,
    ),
    'user',
    'srbac'     => array(
      'debug'   => true,
      'userid'  => 'id',
    )
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
      'loginUrl' => array('/user/login'),
		),
    'authManager'=>array(
      'class'           => 'system.web.auth.CDbAuthManager',
      'connectionID'    => 'db',
      'assignmentTable' => 'auth_assignment',
      'itemChildTable'  => 'auth_item_child',
      'itemTable'       => 'auth_item',
    ),
    'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yii_feature_request',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
      'enableProfiling' => true,
      'tablePrefix' => 'tbl_'
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CProfileLogRoute',
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);