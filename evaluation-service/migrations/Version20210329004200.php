<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210329004200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Adds test task1 evaluation';
    }

    public function up(Schema $schema) : void
    {
         $this->addSql('
            INSERT INTO
                `task_evaluation` (id, task_id, user_id)
            VALUES 
                (1, 1, 2)
         ');
        
        $this->addSql('
            INSERT INTO
                `evaluation_attempt`(id, task_evaluation_id, final_status, created_at, updated_at)
            VALUES 
                (
                    1,
                    1,
                    2,
                    (\'2021-03-28 20:30:00\'),
                    (\'2021-03-28 20:50:00\')
                )
        ');

        $this->addSql('
            INSERT INTO
                `evaluation_action_state`(id, evaluation_attempt_id, action_id, status, created_at, updated_at)
            VALUES 
                (
                    1,
                    1,
                    1,
                    2,
                    (\'2021-03-28 20:30:00\'),
                    (\'2021-03-28 20:45:00\')
                )
        ');

        $this->addSql('
            INSERT INTO
                `evaluation_file_artifact`(id, evaluation_action_state_id, file_name, file_path, created_at)
            VALUES 
                (
                    1,
                    1,
                    "lab1_task1_file1.pas",
                    "/path/to/lab1_task1_file1.pas",
                    (\'2021-03-28 20:30:00\')
                ),
                (
                    2,
                    1,
                    "lab1_task1_file2.pas",
                    "/path/to/lab1_task1_file2.pas",
                    (\'2021-03-28 20:40:00\')
                ),
                (
                    3,
                    1,
                    "lab1_task1_file3.pas",
                    "/path/to/lab1_task1_file3.pas",
                    (\'2021-03-28 20:45:00\')
                )
        ');

        $this->addSql('
            INSERT INTO
                `evaluation_action_state`(id, evaluation_attempt_id, action_id, status, created_at, updated_at)
            VALUES 
                (
                    2,
                    1,
                    3,
                    2,
                    (\'2021-03-28 20:50:00\'),
                    (\'2021-03-28 20:50:00\')
                )
        ');

        $this->addSql('
            INSERT INTO
                `evaluation_compilation_artifact`(id, evaluation_action_state_id, created_at)
            VALUES 
                (
                    1,
                    2,
                    (\'2021-03-28 20:50:00\')
                )
        ');
    }

    public function down(Schema $schema) : void
    {
        // do nothing
    }
}
