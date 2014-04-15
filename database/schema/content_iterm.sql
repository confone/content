CREATE TABLE {$dbName}.iterm
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	code VARCHAR(21),
	type VARCHAR(21),
	language VARCHAR(3),
	description VARCHAR(41),
	active VARCHAR(2),

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX iterm_code_index ON {$dbName}.iterm (code(20));
CREATE INDEX iterm_type_index ON {$dbName}.iterm (type(20));
CREATE INDEX iterm_language_index ON {$dbName}.iterm (language(2));
CREATE INDEX iterm_active_index ON {$dbName}.iterm (active(1));


CREATE TABLE {$dbName}.iterm_relation
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	parent_code VARCHAR(21),
	child_id INT(10) UNSIGNED,
	type VARCHAR(21),

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';