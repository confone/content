CREATE TABLE {$dbName}.access_token_account
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	access_token VARCHAR(65),
	account_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_access_token_account_access_token_index ON {$dbName}.access_token_account (access_token(64));
CREATE INDEX {$dbName}_access_token_account_account_id_index ON {$dbName}.access_token_account (account_id);


CREATE TABLE {$dbName}.account_token_account
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	account_token VARCHAR(65),
	account_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_account_token_account_account_token_index ON {$dbName}.account_token_account (account_token(64));
CREATE INDEX {$dbName}_account_token_account_account_id_index ON {$dbName}.account_token_account (account_id);


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';