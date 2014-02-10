CREATE TABLE {$dbName}.image_code
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	code VARCHAR(33),
	project_path_id INT(10) UNSIGNED,
	image_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_image_code_code_index ON {$dbName}.image_code (code(32));
CREATE INDEX {$dbName}_image_code_project_path_id_index ON {$dbName}.image_code (project_path_id);


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';