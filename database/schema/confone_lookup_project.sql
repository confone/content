CREATE TABLE {$dbName}.project_account
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	project_id INT(10) UNSIGNED,
	account_id INT(10) UNSIGNED,
	access_level TINYINT,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_project_account_project_id_index ON {$dbName}.project_account (project_id);
CREATE INDEX {$dbName}_project_account_account_id_index ON {$dbName}.project_account (account_id);


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';