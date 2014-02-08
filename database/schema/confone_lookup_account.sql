CREATE TABLE {$dbName}.account_email
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	email VARCHAR(61),
	account_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_account_email_email_index ON {$dbName}.account_email (email(60));
CREATE INDEX {$dbName}_account_email_account_id_index ON {$dbName}.account_email (account_id);


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';