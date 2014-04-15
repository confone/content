CREATE TABLE {$dbName}.lookup_project_account
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	project_id INT(10) UNSIGNED,
	account_id INT(10) UNSIGNED,
	access_level TINYINT,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_project_account_project_id_index ON {$dbName}.lookup_project_account (project_id);
CREATE INDEX {$dbName}_project_account_account_id_index ON {$dbName}.lookup_project_account (account_id);


CREATE TABLE {$dbName}.lookup_pubkey_project
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	pub_key VARCHAR(41),
	project_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_pubkey_project_pub_key_index ON {$dbName}.lookup_pubkey_project (pub_key(40));
CREATE INDEX {$dbName}_pubkey_project_project_id_index ON {$dbName}.lookup_pubkey_project (project_id);


CREATE TABLE {$dbName}.lookup_prikey_project
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	pri_key VARCHAR(41),
	project_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_prikey_project_pri_key_index ON {$dbName}.lookup_prikey_project (pri_key(40));
CREATE INDEX {$dbName}_prikey_project_project_id_index ON {$dbName}.lookup_prikey_project (project_id);


INSERT INTO lookup_prikey_application (pri_key, app_id)
VALUES ('b1d6771652e4ed621de446b2c721d435', 1);


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';