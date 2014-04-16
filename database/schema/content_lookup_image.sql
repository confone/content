CREATE TABLE {$dbName}.lookup_image_code
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	code VARCHAR(33),
	image_id INT(10) UNSIGNED,
	project_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_image_code_code_index ON {$dbName}.lookup_image_code (code(32));
CREATE INDEX {$dbName}_image_code_project_id_index ON {$dbName}.lookup_image_code (project_id);


CREATE TABLE {$dbName}.lookup_image_project_path
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	project_path_id INT(10) UNSIGNED,
	project_id INT(10) UNSIGNED,
	image_id INT(10) UNSIGNED,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_image_project_path_project_path_id_index ON {$dbName}.lookup_image_project_path (project_path_id);
CREATE INDEX {$dbName}_image_project_path_project_id_index ON {$dbName}.lookup_image_project_path (project_id);


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';


