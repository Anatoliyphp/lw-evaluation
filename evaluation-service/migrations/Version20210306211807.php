<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210306211807 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Adds test course enrollment on test student';
    }

    public function up(Schema $schema) : void
    {
         $this->addSql('
            INSERT INTO
                `enrollment` (id, user_id, course_id)
            VALUES 
                (1, 2, 1),
                (2, 2, 2)
         ');
        
        $this->addSql('
            INSERT INTO
                `lab_work_availability`(id, lab_work_id, access_date, enrollment_id)
            VALUES 
                (
                    DEFAULT,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 1" AND course_id = 1),
                    (\'2021-03-01 20:30:00\'),
                    1
                ),
                (
                    DEFAULT,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 2" AND course_id = 1),
                    (\'2021-04-01 20:30:00\'),
                    1
                ),
                (
                    DEFAULT,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 1" AND course_id = 2),
                    (\'2021-03-15 20:30:00\'),
                    2
                ),
                (
                    DEFAULT,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 2" AND course_id = 2),
                    (\'2021-04-15 20:30:00\'),
                    2
                )
        ');
    }

    public function down(Schema $schema) : void
    {
        // do nothing
    }
}
