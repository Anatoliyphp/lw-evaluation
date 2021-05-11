<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210219003534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create tables User and Group';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE `group` (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('
            CREATE TABLE user (
                id INT AUTO_INCREMENT NOT NULL,
                email VARCHAR(255) NOT NULL,
                role INT NOT NULL,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                group_id INT DEFAULT NULL,
                PRIMARY KEY(id),
                INDEX idx_group_id (group_id),
                FOREIGN KEY (group_id)
                    REFERENCES `group`(id)
                    ON DELETE SET NULL
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE `group`');
    }
}
