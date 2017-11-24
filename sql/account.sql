-- Insert into the auth database.
ALTER TABLE `account`
	ADD COLUMN `staff` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `recruiter`;