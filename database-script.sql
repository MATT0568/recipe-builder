SET FOREIGN_KEY_CHECKS = 0;
-- ----------------------------------------------------------------------------
-- Schema recipebuilder
-- ----------------------------------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `recipebuilder` ;


-- ----------------------------------------------------------------------------
-- Table recipebuilder.APP_USERS
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `recipebuilder`.`APP_USERS` (
  `USER_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `EMAIL` VARCHAR(30) CHARACTER SET 'utf8' NOT NULL,
  `PASSWORD` VARCHAR(40) CHARACTER SET 'utf8' NOT NULL,
  `FIRST_NAME` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  `LAST_NAME` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`USER_ID`),
  UNIQUE INDEX `APP_USERS_UK` (`EMAIL` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- ----------------------------------------------------------------------------
-- Table recipebuilder.INGREDIENT
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `recipebuilder`.`INGREDIENT` (
  `INGREDIENT_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `INGREDIENT_NAME` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `CALORIES` VARCHAR(70) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`INGREDIENT_ID`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- ----------------------------------------------------------------------------
-- Table recipebuilder.RECIPE
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `recipebuilder`.`RECIPE` (
  `RECIPE_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `RECIPE_NAME` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `USER_ID` INT(11) NOT NULL,
  PRIMARY KEY (`RECIPE_ID`),
  INDEX `recipe_user_id_fk_idx` (`USER_ID` ASC),
  CONSTRAINT `recipe_user_id_fk`
    FOREIGN KEY (`USER_ID`)
    REFERENCES `recipebuilder`.`APP_USERS` (`USER_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- ----------------------------------------------------------------------------
-- Table recipebuilder.INGREDIENTS
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `recipebuilder`.`INGREDIENTS` (
  `INGREDIENTS_ID` INT(11) NOT NULL AUTO_INCREMENT,
  `INGREDIENT_ID` INT(11) NOT NULL,
  `RECIPE_ID` INT(11) NOT NULL,
  `AMOUNT` VARCHAR(30) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`INGREDIENTS_ID`),
  INDEX `ingredients_ingredient_id_fk_idx` (`INGREDIENTS_ID` ASC),
  INDEX `ingredients_recipe_id_fk_idx` (`RECIPE_ID` ASC),
  CONSTRAINT `ingredients_ingredient_id_fk`
    FOREIGN KEY (`INGREDIENT_ID`)
    REFERENCES `recipebuilder`.`INGREDIENT` (`INGREDIENT_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `ingredients_recipe_id_fk`
    FOREIGN KEY (`RECIPE_ID`)
    REFERENCES `recipebuilder`.`RECIPE` (`RECIPE_ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- ----------------------------------------------------------------------------
-- View recipebuilder.RECIPE_INFO
-- ----------------------------------------------------------------------------
USE `recipebuilder`;
CREATE  OR REPLACE VIEW `recipebuilder`.`RECIPE_INFO` 
AS select distinct `r`.`RECIPE_ID` AS `RECIPE_ID`,
`r`.`RECIPE_NAME` AS `RECIPE_NAME`,
`u`.`USER_ID` AS `USER_ID`,
`u`.`EMAIL` AS `EMAIL`,
`is`.`INGREDIENTS_ID` AS `INGREDIENTS_ID`,
`is`.`AMOUNT` AS `AMOUNT`,
`i`.`INGREDIENT_ID` AS `INGREDIENT_ID`,
`i`.`INGREDIENT_NAME` AS `INGREDIENT_NAME`,
`i`.`CALORIES` AS `CALORIES`
from (((`recipebuilder`.`RECIPE` `r` left join `recipebuilder`.`APP_USERS` `u` on(`r`.`USER_ID` = `u`.`USER_ID`))
left join `recipebuilder`.`INGREDIENTS` `is` on(`r`.`RECIPE_ID` = `is`.`RECIPE_ID`))
left join `recipebuilder`.`INGREDIENT` `i` on(`is`.`INGREDIENT_ID` = `i`.`INGREDIENT_ID`));


-- ----------------------------------------------------------------------------
-- Routine recipebuilder.add_user
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `recipebuilder`$$
CREATE PROCEDURE `add_user`(IN p_email   VARCHAR(4000),
                      IN p_password   VARCHAR(4000),
                      p_first_name VARCHAR(4000),
                      p_last_name VARCHAR(4000))
BEGIN
	INSERT INTO APP_USERS (
      email,
      `PASSWORD`,
      first_name,
      last_name
    )
    VALUES (
      UPPER(p_email),
      get_hash(p_email, p_password),
      p_first_name,
      p_last_name
    );
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine recipebuilder.change_password
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `recipebuilder`$$
CREATE PROCEDURE `change_password`(IN p_email VARCHAR(4000),
                             IN p_old_password   VARCHAR(4000),
                             IN p_new_password   VARCHAR(4000))
BEGIN
    DECLARE v_USER_ID CHAR(10);
   
    DECLARE EXIT HANDLER FOR NOT FOUND BEGIN
		SIGNAL SQLSTATE 'XAE07' SET MESSAGE_TEXT = 'Invalid email/PASSWORD.';
    END;
    
    SELECT USER_ID
    INTO   v_USER_ID
    FROM   APP_USERS
    WHERE  EMAIL = UPPER(p_email)
    AND    `PASSWORD` = get_hash(p_email, p_old_password)
    FOR UPDATE;
    
    UPDATE APP_USERS
    SET    `PASSWORD` = get_hash(p_email, p_new_password)
    WHERE  USER_ID    = v_USER_ID;
    
    COMMIT;
   END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine recipebuilder.get_hash
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `recipebuilder`$$
CREATE FUNCTION `get_hash`(p_email VARCHAR(4000), p_password VARCHAR(4000)) RETURNS varchar(4000) CHARSET latin1
    DETERMINISTIC
BEGIN
	DECLARE l_salt VARCHAR(30) DEFAULT 'SaltPasswordText';
	RETURN MD5(concat(UPPER(p_email), l_salt,UPPER(p_password)));
END$$

DELIMITER ;

-- ----------------------------------------------------------------------------
-- Routine recipebuilder.valid_user
-- ----------------------------------------------------------------------------
DELIMITER $$

DELIMITER $$
USE `recipebuilder`$$
CREATE FUNCTION `valid_user`(p_email VARCHAR(4000), p_password VARCHAR(4000)) RETURNS varchar(1) CHARSET latin1
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN
      RETURN '0';
    END;
    
    CALL valid_user(p_email, p_password);
    RETURN '1';
END$$

DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `valid_user`(IN p_email   VARCHAR(4000),
                        IN p_password   VARCHAR(4000))
BEGIN
    DECLARE v_dummy VARCHAR(1);
   
    DECLARE EXIT HANDLER FOR NOT FOUND BEGIN
		SIGNAL SQLSTATE 'XAE07' SET MESSAGE_TEXT = 'Invalid email/PASSWORD.';
    END;
    
    SELECT '1'
    INTO   v_dummy
    FROM   APP_USERS
    WHERE  EMAIL = UPPER(p_email)
    AND    `PASSWORD` = get_hash(p_email, p_password);
 END$$
DELIMITER ;
SET FOREIGN_KEY_CHECKS = 1;


CALL add_user('mateo0568@gmail.com', 'puggles1', 'Matthew', 'Lesniewicz');