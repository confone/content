CREATE TABLE {$dbName}.lookup_text_code
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	code VARCHAR(33),
	text_id INT(10) UNSIGNED,
	project_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_text_code_code_index ON {$dbName}.lookup_text_code (code(32));
CREATE INDEX {$dbName}_text_code_project_id_index ON {$dbName}.lookup_text_code (project_id);


CREATE TABLE {$dbName}.lookup_text_project_path
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	project_path_id INT(10) UNSIGNED,
	text_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_text_project_path_project_path_id_index ON {$dbName}.lookup_text_project_path (project_path_id);


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';