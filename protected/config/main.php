<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Курсы валют',
        'language' => 'ru',
    
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
	),

	// application components
	'components'=>array(
	
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName'=>false,
			'rules'=>array(
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',//default
				'<controller:\w+>/index/<id:\w+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
                
               //change this data
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=currencyrate',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			//'enableProfiling'=>true,
			//'enableParamLogging' => true,                    
		),
		/*
		*/
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
//                                        'class'=>'CProfileLogRoute',
//                                        'levels'=>'profile',
//                                        'enabled'=>true,
                                    ),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'currencyRateXMLURL'=>'https://privat24.privatbank.ua/p24/accountorder?oper=prp&PUREXML&apicour&country=ru&full',//privat24 xml
		'xpathToData'=>'/exchangerate/exchangerate',
		'defaultCcyList'=>'EUR,USD,UAH,BYR',
		'cookieName'=>'CcyList',
		'cookieExpired'=>'7',//7 dayz
		'timestamp'=>time(),//now (+/- time zone)
		'ccyExpired'=>60*60*24,//1 day
	),
);