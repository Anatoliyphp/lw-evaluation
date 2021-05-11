<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210326091201 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'add test data to pipeline and actions';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            INSERT INTO
                `evaluation_pipeline` (id, course_id)
            VALUES
                (
                    1,
                    (SELECT id FROM course WHERE title = "Основы программирования")
                ),
                (
                    2,
                    (SELECT id FROM course WHERE title = "Основы программирования-2")
                )
        ');
        $this->addSql('
            INSERT INTO
                `action` (id, pipeline_id, execution_order, type)
            VALUES
                (1, 1, 0, 1),
                (2, 2, 0, 1),
                (3, 1, 1, 2),
                (4, 1, 2, 3)
        ');
        $this->addSql('
            INSERT INTO 
                `file_upload_action` (id)
            VALUES
                (1),
                (2)
        ');
        $this->addSql('
            INSERT INTO 
                `pascal_compilation_action` (id, action_id_to_compile)
            VALUES
                (
                    3,
                    1
                )
        ');
        $this->addSql('
            INSERT INTO 
                `teacher_evaluation_action` (id, action_id)
            VALUES
                (
                    4,
                    1
                )
        ');
        $this->addSql('
            INSERT INTO 
                `file_upload_file_type` (id, type, file_upload_action_id)
            VALUES
                (
                    1,
                    "pas",
                    1
                )
        ');
    }

    public function down(Schema $schema) : void
    {
        
    }
}
