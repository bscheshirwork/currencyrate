<?php

/**
 * This is the model class for table "currencyrate".
 *
 * The followings are the available columns in table 'currencyrate':
 * @property string $ccy
 * @property string $ccy_name_ru
 * @property integer $buy
 * @property integer $unit
 * @property string $date
 * @property string $timestamp
 * 
 * 
CREATE TABLE `currencyrate` (
	`ccy` CHAR(3) NOT NULL,
	`ccy_name_ru` VARCHAR(255) NOT NULL,
	`buy` BIGINT(20) NOT NULL DEFAULT '1',
	`unit` INT(11) NOT NULL DEFAULT '1',
	`date` DATE NOT NULL,
	`timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`ccy`)
)
COMMENT='store actual currency rate'
COLLATE='utf8_general_ci'
ENGINE=InnoDB;


 */
class Currencyrate extends CActiveRecord
{
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'currencyrate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ccy, ccy_name_ru, buy, unit, date', 'required'),
			array('buy, unit', 'numerical', 'integerOnly'=>true),
			array('ccy', 'length', 'max'=>3),
			array('ccy_name_ru', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ccy, ccy_name_ru, buy, unit, date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ccy' => 'Код валюты',
			'ccy_name_ru' => 'Название валюты на русском языке',
			'buy' => 'Курс покупки (Рублей)',
			'unit' => 'Количество единиц валюты, которые можно купить по курсу покупки',
			'date' => 'Дата последнего обновления курсов валют',
		);
	}
        
	/**
	 * @param array $arr data to process.
	 * @return Currencyrate object. Filled from array. Return FALSE if $arr is not valid array
	 */
	public function parseArray($arr)
	{
                if(is_array($arr) || $arr instanceof \ArrayAccess || $arr instanceof \Traversable){
                        $this->ccy          = (string)$arr['ccy'];
                        $this->ccy_name_ru  = (string)$arr['ccy_name_ru'];
                        $this->buy          = (integer)$arr['buy'];
                        $this->unit         = (integer)$arr['unit'];
                        $this->date         = (string)$arr['date'];
                        //$post->timestamp    = new CDbExpression('NOW()');
                        return $this;
                }else
                        return FALSE;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ccy',$this->ccy,true);
		$criteria->compare('ccy_name_ru',$this->ccy_name_ru,true);
		$criteria->compare('buy/10000',$this->buy);
		$criteria->compare('unit',$this->unit);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Currencyrate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
