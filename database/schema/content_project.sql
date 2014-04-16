CREATE TABLE {$dbName}.project
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	name VARCHAR(61),
	owner_id INT(10) UNSIGNED NOT NULL,
	last_modify DATETIME,
	create_time DATETIME,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_project_owner_id_index ON {$dbName}.project (owner_id);


CREATE TABLE {$dbName}.project_path
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	project_id INT(10) UNSIGNED NOT NULL,
	parent_path_id INT(10) UNSIGNED NOT NULL,
	path VARCHAR(33),
	path_full VARCHAR(256),
	is_deleted VARCHAR(2),
	last_modify DATETIME,
	create_time DATETIME,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX {$dbName}_project_path_project_id_index ON {$dbName}.project_path (project_id);
CREATE INDEX {$dbName}_project_path_path_index ON {$dbName}.project_path (path(32));
CREATE INDEX {$dbName}_project_path_is_deleted_index ON {$dbName}.project_path (is_deleted(1));


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';

