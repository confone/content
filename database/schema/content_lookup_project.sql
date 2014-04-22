CREATE TABLE {$dbName}.lookup_project_account
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	project_id INT(10) UNSIGNED,
	account_id INT(10) UNSIGNED,
	access_level TINYINT,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_proj_acc_pid_index ON {$dbName}.lookup_project_account (project_id);
CREATE INDEX {$dbName}_proj_acc_aid_index ON {$dbName}.lookup_project_account (account_id);


CREATE TABLE {$dbName}.lookup_pubkey_project
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	pub_key VARCHAR(41),
	project_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_pub_proj_pub_index ON {$dbName}.lookup_pubkey_project (pub_key(40));
CREATE INDEX {$dbName}_pub_proj_pid_index ON {$dbName}.lookup_pubkey_project (project_id);


CREATE TABLE {$dbName}.lookup_prikey_project
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	pri_key VARCHAR(41),
	project_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_pri_proj_pri_index ON {$dbName}.lookup_prikey_project (pri_key(40));
CREATE INDEX {$dbName}_pri_proj_pid_index ON {$dbName}.lookup_prikey_project (project_id);


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';