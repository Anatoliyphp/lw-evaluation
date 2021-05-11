<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210228121709 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creating entities Course, LabWork and Task';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE course (
                id INT AUTO_INCREMENT NOT NULL,
                title VARCHAR(255) NOT NULL,
                description VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('
            CREATE TABLE lab_work (
                id INT AUTO_INCREMENT NOT NULL,
                course_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                PRIMARY KEY(id),
                INDEX idx_course_id (course_id),
                FOREIGN KEY (course_id)
                    REFERENCES `course`(id)
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('
            CREATE TABLE task (
                id INT AUTO_INCREMENT NOT NULL,
                lab_work_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                description VARCHAR(255) NOT NULL,
                passing_score INT NOT NULL,
                max_score INT NOT NULL,
                pipeline_id INT NOT NULL,
                PRIMARY KEY(id),
                INDEX idx_lab_work_id (lab_work_id),
                FOREIGN KEY (lab_work_id)
                    REFERENCES `lab_work`(id)
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE lab_work');
        $this->addSql('DROP TABLE course');
    }
}
