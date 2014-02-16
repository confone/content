CREATE TABLE {$dbName}.access_token
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	access_token VARCHAR(65),
	account_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_access_token_access_token_index ON {$dbName}.access_token (access_token(64));
CREATE INDEX {$dbName}_access_token_account_id_index ON {$dbName}.access_token (account_id)


CREATE TABLE {$dbName}.account_token
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	account_token VARCHAR(33),
	account_id INT(10) UNSIGNED,
	type VARCHAR(2),

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_account_token_account_token_index ON {$dbName}.active_token (account_token(32));
CREATE INDEX {$dbName}_account_token_account_id_index ON {$dbName}.active_token (account_id)
CREATE INDEX {$dbName}_account_token_type_index ON {$dbName}.active_token (type(1));


CREATE TABLE {$dbName}.pubkey_token
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	pubkey VARCHAR(41),
	token VARCHAR(33),

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_pubkey_token_email_index ON {$dbName}.pubkey_token (pubkey(40));
CREATE INDEX {$dbName}_pubkey_token_token_index ON {$dbName}.pubkey_token (token(32));


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';