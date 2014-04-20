CREATE TABLE {$dbName}.text
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	code VARCHAR(33),
	project_id INT(10) UNSIGNED,
	account_id INT(10) UNSIGNED,
	create_time DATETIME,
	last_modify DATETIME,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_text_code_index ON {$dbName}.text (code(32));


CREATE TABLE {$dbName}.text_version
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	text_id INT(10) UNSIGNED, 
	content TEXT,
	language VARCHAR(3),
	version TINYINT,
	create_time DATETIME,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_text_version_text_id_index ON {$dbName}.text_version (text_id);
CREATE INDEX {$dbName}_text_version_language_index ON {$dbName}.text_version (language(2));


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';

