CREATE TABLE {$dbName}.image
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	code VARCHAR(33),
	project_id INT(10) UNSIGNED,
	account_id INT(10) UNSIGNED,
	create_time DATETIME,
	last_modify DATETIME,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_image_code_index ON {$dbName}.image (code(32));


CREATE TABLE {$dbName}.image_version
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	image_id INT(10) UNSIGNED, 
	file_path VARCHAR(61),
	version TINYINT,
	create_time DATETIME,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_image_version_iid_index ON {$dbName}.image_version (image_id);


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';

