<?php

/**
 * This is the model class for xml "currencyrate".
 *
 * The followings are the available columns in table 'currencyrate':
 * @property string $ccy
 * @property string $ccy_name_ru
 * @property integer $buy
 * @property integer $unit
 * @property string $date
 */


class CurrencyrateXML extends SimpleXMLElement
{
        public $ccy;
        public $ccy_name_ru;
        public $buy;
        public $unit;
        public $date;
}
