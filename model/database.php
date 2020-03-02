<?php

/*
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Table `davidkislyak_dating`.`member`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `davidkislyak_dating`.`member` (
  `member_id` INT NOT NULL AUTO_INCREMENT,
  `fname` VARCHAR(45) NULL,
  `lname` VARCHAR(45) NULL,
  `age` INT NULL,
  `gender` VARCHAR(45) NULL,
  `phone` VARCHAR(12) NULL,
  `email` VARCHAR(45) NULL,
  `state` VARCHAR(45) NULL,
  `seeking` VARCHAR(45) NULL,
  `bio` VARCHAR(256) NULL,
  `premium` TINYINT NULL,
  `image` VARCHAR(45) NULL,
  PRIMARY KEY (`member_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `davidkislyak_dating`.`interest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `davidkislyak_dating`.`interest` (
  `interest_id` INT NOT NULL AUTO_INCREMENT,
  `interest` VARCHAR(45) NULL,
  `type` VARCHAR(7) NULL,
  `interestcol` VARCHAR(45) NULL,
  PRIMARY KEY (`interest_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `davidkislyak_dating`.`member-interest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `davidkislyak_dating`.`member-interest` (
  `interest_id` INT NOT NULL,
  `member_id` INT NOT NULL,
  PRIMARY KEY (`interest_id`, `member_id`),
  CONSTRAINT `fk_member-interest_interest`
    FOREIGN KEY (`interest_id`)
    REFERENCES `davidkislyak_dating`.`interest` (`interest_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_member-interest_member1`
    FOREIGN KEY (`member_id`)
    REFERENCES `davidkislyak_dating`.`member` (`member_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_member-interest_member1_idx` ON `davidkislyak_dating`.`member-interest` (`member_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
 */

class Database
{
    //PDO object
    private $_dbh;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        require_once("../../../connect_dating.php");

        try {
            //Create a new PDO connection
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            echo "Connected";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function executeSql($sql, $needID=null)
    {
        // Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        // Execute the statement
        $statement->execute();

        // Get the result
        if ($needID == "true") {
            return $this->_dbh->lastInsertId();
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertMember($member)
    {
        $fName = $member->getFname();
        $lName = $member->getLname();
        $age = $member->getAge();
        $gender = (strtolower($member->getAge()) == "male" ? 0 : 1);
        $phone = $member->getPhone();
        $email = $member->getEmail();
        $state = $member->getState();
        $seeking = (strtolower($member->getSeeking()) == "male" ? 0 : 1);
        $bio = $member->getBio();
        $premium = ($member instanceof PremiumMember ? 1 : 0);

        $sql = "INSERT INTO `member` (
            `member_id`, `fname`, `lname`, `age`, `gender`, `phone`, `email`, `state`, `seeking`, `bio`, `premium`, `image`)
        VALUES (
            NULL, '$fName', '$lName', '$age', '$gender', '$phone', '$email', '$state', '$seeking', '$bio', '$premium', NULL)";

        echo 'Member Insert: '.$sql;
        $insertID = $this->executeSql($sql, 'true');

        echo "insertID == ".$insertID;

        //Only for premium members
        if ($premium == 1) {
            $sql = "INSERT INTO `member-interest` (`interest_id`, `member_id`) VALUES ";

            $indoor = $member->getInDoorInterests();
            $outdoor = $member->getOutDoorInterests();

            if (sizeof($indoor) > 0) {

                foreach ($indoor as $interest) {
                    $sql .= "((SELECT interest_id FROM interest WHERE interest.interest = '$interest'), ($insertID)), ";
                }

                if (sizeof($outdoor) == 0) {
                    $sql = substr($sql, 0, -2);
                }
            }

            if (sizeof($outdoor) > 0) {
                foreach ($outdoor as $interest) {
                    $sql .= "((SELECT interest_id FROM interest WHERE interest.interest = '$interest'), ($insertID)), ";
                }

                $sql = substr($sql, 0, -2);
            }

            if (sizeof($outdoor) > 0 || sizeof($indoor) > 0) {
                $this->executeSql($sql);
            }
        }

        return true;
    }

    public function getMembers()
    {
        $sql = "SELECT *
                FROM member";

        return $this->executeSql($sql);
    }

    public function getMember($member_id)
    {
        $sql = "SELECT *
                FROM member
                WHERE member.member_id = " . $member_id;

        return $this->executeSql($sql);
    }

    public function getInterests($member_id)
    {
        $sql = "SELECT interest.interest
                FROM
                    member,
                    `member-interest` as memberinterest,
                    interest
                WHERE
                    memberinterest.member_id = " . $member_id . " AND interest.interest_id = memberinterest.interest_id";

        return $this->executeSql($sql);
    }
}