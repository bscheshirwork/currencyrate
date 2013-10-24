<?php
/* @var $this SiteController */
/* @var $model Currencyrate */
/* @var $ccylist string */
?>
<?php
Yii::app()->clientScript->registerScript('manageselect', "
	$(document).ready(function() {
		$('#currencyrate-grid-manage').selGridView('addSelection', ".json_encode($ccylist)."); 
	}); 
");
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/table.css');

?> <!-- easy-update-selected-grid -->

<div class="wide form">
Выделете требуемые курсы валют цветом и нажмите кнопку "Обновить" для сохранения результата.
<p>
Подсказка: вы можете использовать операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) для быстрого поиска по доступным полям.
</p>


<?php $this->widget('ext.selgridview.SelGridView', array(
	'id'=>'currencyrate-grid-manage',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'ccy',
		'ccy_name_ru',
		array('name'=>'buy','value'=>'$data->buy/10000'),
		'unit',
		'date',
	),
	'selectableRows'=>2,
    
)); ?>   <!-- data-update-grid -->

</div>

<?php echo CHtml::link('Обновить','#',array('class'=>'buttons','id'=>'refreshbutton')); ?>