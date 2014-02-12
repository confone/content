CREATE TABLE {$dbName}.account
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	email VARCHAR(61),
	password VARCHAR(41),
	name VARCHAR(128),
	profile_pic VARCHAR(61),
	description VARCHAR(256),
	last_login DATETIME,
	public_key VARCHAR(41),
	private_key VARCHAR(41),
	level VARCHAR(2),
	blocked VARCHAR(2),

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_account_email_index ON {$dbName}.account (email(60));
CREATE INDEX {$dbName}_account_public_key_index ON {$dbName}.account (public_key(40));
CREATE INDEX {$dbName}_account_private_key_index ON {$dbName}.account (private_key(40));
CREATE INDEX {$dbName}_account_level_index ON {$dbName}.account (level(1));
CREATE INDEX {$dbName}_account_blocked_index ON {$dbName}.account (blocked(1));


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';