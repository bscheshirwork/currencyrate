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
