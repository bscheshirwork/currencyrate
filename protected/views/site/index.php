<?php
/* @var $this SiteController */
/* @var $model Currencyrate */
/* @var $dataProvider CActiveDataProvider */
/* @var $ccylist String */


Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('cookie');
Yii::app()->clientScript->registerScript('manage', "
	$('.manage-button').click(function(){
		$('.manage-form').toggle();
		return false;
	});
");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/buttons.css');
?>

<?php echo CHtml::link('Ещё...','#',array('class'=>'manage-button buttons','id'=>'morebutton')); ?>
<div class="manage-form" style="display:none">
<?php $this->renderPartial('_manage',array(
	'model'=>$model,
	'ccylist'=>$ccylist,
)); ?>
</div><!-- manage-form -->


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'currencyrate-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'ccy',
		'ccy_name_ru',
		array('name'=>'buy','value'=>'$data->buy/10000'),
		'unit',
		'date',
	),
	'updateSelector'=>'{page}, {sort}, #refreshbutton ',
	'beforeAjaxUpdate'=>'function(id,options){
			var currentccy=$("#currencyrate-grid-manage").selGridView("getAllSelection");
			$.cookie("'.Yii::app()->params['cookieName'].'", currentccy,{path: "/", expires: "'.Yii::app()->params['cookieExpired'].'"});
			options.type="POST";
			options.url+=("&CcyList="+encodeURIComponent(currentccy)+"&refresh=1");
		}',
)); ?><!-- data-grid -->
