<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use DateTime;

final class Version20210222110228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'create entities Enrollment and LabWorkAvailability';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE enrollment (
                id INT AUTO_INCREMENT NOT NULL,
                user_id INT NOT NULL,
                course_id INT NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('
            CREATE TABLE lab_work_availability (
                id INT AUTO_INCREMENT NOT NULL,
                lab_work_id INT NOT NULL,
                access_date TIMESTAMP NOT NULL,
                enrollment_id INT NOT NULL,
                PRIMARY KEY(id),
                INDEX idx_enrollment_id (enrollment_id),
                FOREIGN KEY (enrollment_id)
                    REFERENCES `enrollment`(id)
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE lab_work_availability');
        $this->addSql('DROP TABLE enrollment');
    }
}
