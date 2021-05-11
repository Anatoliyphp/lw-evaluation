<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210314084722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'creates evaluation module';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE task_evaluation (
                id INT AUTO_INCREMENT NOT NULL,
                task_id INT NOT NULL,
                user_id INT NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('
            CREATE TABLE evaluation_attempt (
                id INT AUTO_INCREMENT NOT NULL,
                task_evaluation_id INT NOT NULL,
                final_status SMALLINT NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY(id),
                INDEX idx_task_evaluation_id (task_evaluation_id),
                CONSTRAINT fk_task_evaluation_id
                FOREIGN KEY (task_evaluation_id)
                    REFERENCES `task_evaluation`(id)
                    ON DELETE CASCADE 
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('
            CREATE TABLE evaluation_action_state (
                id INT AUTO_INCREMENT NOT NULL,
                evaluation_attempt_id INT NOT NULL,
                action_id INT NOT NULL,
                status SMALLINT NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY(id),
                INDEX idx_evaluation_attempt_id (evaluation_attempt_id),
                CONSTRAINT fk_evaluation_attempt_id
                FOREIGN KEY (evaluation_attempt_id)
                    REFERENCES `evaluation_attempt`(id)
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('
            CREATE TABLE evaluation_file_artifact (
                id INT AUTO_INCREMENT NOT NULL,
                evaluation_action_state_id INT NOT NULL,
                file_name VARCHAR(255) NOT NULL,
                file_path TEXT NOT NULL,
                created_at DATETIME NOT NULL,
                INDEX idx_evaluation_action_state_id (evaluation_action_state_id),
                PRIMARY KEY(id),
                CONSTRAINT fk1_evaluation_action_state_id
                FOREIGN KEY (evaluation_action_state_id)
                    REFERENCES `evaluation_action_state`(id)
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('
            CREATE TABLE evaluation_score_artifact (
                id INT AUTO_INCREMENT NOT NULL,
                evaluation_action_state_id INT NOT NULL,
                score INT NOT NULL,
                passing_score INT NOT NULL,
                max_score INT NOT NULL,
                evaluated_by_id INT NOT NULL,
                comment TEXT DEFAULT NULL,
                created_at DATETIME NOT NULL,
                INDEX idx_evaluation_action_state_id (evaluation_action_state_id),
                PRIMARY KEY(id),
                CONSTRAINT fk2_evaluation_action_state_id
                FOREIGN KEY (evaluation_action_state_id)
                    REFERENCES `evaluation_action_state`(id)
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('
            CREATE TABLE evaluation_compilation_artifact (
                id INT AUTO_INCREMENT NOT NULL,
                evaluation_action_state_id INT NOT NULL UNIQUE,
                error_reason TEXT DEFAULT NULL,
                created_at DATETIME NOT NULL,
                PRIMARY KEY(id),
                INDEX idx_evaluation_action_state_id (evaluation_action_state_id),
                CONSTRAINT fk3_evaluation_action_state_id
                FOREIGN KEY (evaluation_action_state_id)
                    REFERENCES `evaluation_action_state`(id)
                    ON DELETE CASCADE   
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE evaluation_file_artifact DROP FOREIGN KEY fk1_evaluation_action_state_id');
        $this->addSql('ALTER TABLE evaluation_score_artifact DROP FOREIGN KEY fk2_evaluation_action_state_id');
        $this->addSql('ALTER TABLE evaluation_compilation_artifact DROP FOREIGN KEY fk3_evaluation_action_state_id');
        $this->addSql('ALTER TABLE evaluation_action_state DROP FOREIGN KEY fk_evaluation_attempt_id');
        $this->addSql('ALTER TABLE evaluation_attempt DROP FOREIGN KEY fk_task_evaluation_id');
        $this->addSql('DROP TABLE evaluation_action_state');
        $this->addSql('DROP TABLE evaluation_attempt');
        $this->addSql('DROP TABLE evaluation_compilation_artifact');
        $this->addSql('DROP TABLE evaluation_file_artifact');
        $this->addSql('DROP TABLE evaluation_score_artifact');
        $this->addSql('DROP TABLE task_evaluation');
    }
}
