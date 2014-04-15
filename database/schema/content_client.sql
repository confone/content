CREATE TABLE {$dbName}.client
(
	id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	project_key VARCHAR(33) NOT NULL,
	name VARCHAR(41) NOT NULL,
	scope VARCHAR(256) NOT NULL,
	create_time DATETIME NOT NULL,
	modified_time DATETIME NOT NULL,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE INDEX app_key_index ON {$dbName}.client (project_key(32));


INSERT INTO client (project_key, name, scope, create_time, modified_time) 
VALUES ('E268443E43D93DAB7EBEF303BBE9642F', 'account', 'account+business+comment+image', NOW(), NOW());


GRANT ALL ON {$dbName}.* TO '{$uname}'@'%' IDENTIFIED BY '{$passwd}';