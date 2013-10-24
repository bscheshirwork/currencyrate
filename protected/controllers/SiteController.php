<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array();
	}

	/**
	 * Lists all models / select models
	 */
	public function actionIndex()
	{
                //read the ccy array from cookie. Ajax reload easy refresh cookie without GET/POST. If necessary add $_POST[]
                $cookie = (isset(Yii::app()->request->cookies[Yii::app()->params['cookieName']]->value)) ?
                        Yii::app()->request->cookies[Yii::app()->params['cookieName']]->value : Yii::app()->params['defaultCcyList'];
                $ccylist=  preg_split('|[\W]+|', $cookie,-1,PREG_SPLIT_NO_EMPTY);
                
                //delete old currency rate
                $model=Currencyrate::model();
                $model->deleteByPk($ccylist,'UNIX_TIMESTAMP(timestamp)<:timestamp', array(':timestamp'=>Yii::app()->params['timestamp']-Yii::app()->params['ccyExpired']));
                
                //form criteria to show main table
                $criteria=new CDbCriteria;
		$criteria->addInCondition('ccy', $ccylist);
                
                //get xml if expired cr
                if((count($ccylist)!=$model->count($criteria)) || (Yii::app()->request->isAjaxRequest && (bool)$_GET['refresh']) ){
                    
                        //load xml
                        $xml= new CurrencyrateXML(Yii::app()->params['currencyRateXMLURL'],0,TRUE);

                        //check load selected ccy from store
                        $models=$model->findAllByPk($ccylist);
                        //rewrite selected currency
                        foreach ($xml->xpath(Yii::app()->params['xpathToData']) as $key => $item) {
                                foreach ($models as $model)
                                        if($model->ccy==$item['ccy']){
                                                if($model->parseArray($item));
                                                        $model->save();
                                                $item->pass=true;
                                        }
                        }

                        //rewrite other currency
                        foreach ($xml->xpath(Yii::app()->params['xpathToData']) as $key => $item) {
                                if(!$item->pass){
                                        ($model=Currencyrate::model()->findByPk($item['ccy'])) || ($model=new Currencyrate);
                                        if($model->parseArray($item));
                                                $model->save();
                                }
                                $item->pass=true;
                        }
                }
 
                //use criteria to show main table
		$dataProvider=new CActiveDataProvider('Currencyrate', array(
			'criteria'=>$criteria,
		));
                
                //form model to show selector / find in selector
		$model=new Currencyrate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Currencyrate']))
			$model->attributes=$_GET['Currencyrate'];
                
                //render it
		$this->render('index',array(
			'model'=>$model,
                        'dataProvider'=>$dataProvider,
                        'ccylist'=>$ccylist,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

}