<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210317171402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'create evaluation_pipeline, action, course_teacher_id, file_upload_action, pascal_compilation_action,
                file_upload_file_type and teacher_evaluation_action
        ';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE evaluation_pipeline (
                id INT AUTO_INCREMENT NOT NULL, 
                course_id INT DEFAULT NULL, 
                INDEX IDX_70B2A0FF591CC992 (course_id), 
                PRIMARY KEY(id),
                FOREIGN KEY (course_id)
                    REFERENCES `course`(id)
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('
            CREATE TABLE action (
                id INT AUTO_INCREMENT NOT NULL, 
                pipeline_id INT DEFAULT NULL, 
                execution_order INT NOT NULL, 
                type INT NOT NULL, 
                INDEX IDX_47CC8C92E80B93 (pipeline_id),  
                PRIMARY KEY(id),
                FOREIGN KEY (pipeline_id) 
                    REFERENCES `evaluation_pipeline`(id)
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('
            CREATE TABLE course_teacher_id (
                id INT AUTO_INCREMENT NOT NULL, 
                course_id INT DEFAULT NULL, 
                teacher_id INT NOT NULL, 
                INDEX IDX_9E62309E591CC992 (course_id), 
                PRIMARY KEY(id),
                CONSTRAINT UC_course_teacher_id UNIQUE (course_id, teacher_id),
                FOREIGN KEY (course_id)
                    REFERENCES `course`(id)
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;');
        $this->addSql('
            CREATE TABLE file_upload_action (
                id INT NOT NULL, 
                PRIMARY KEY(id),
                FOREIGN KEY (id) 
                    REFERENCES `action`(id) 
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('
            CREATE TABLE file_upload_file_type (
                id INT AUTO_INCREMENT NOT NULL, 
                file_upload_action_id INT DEFAULT NULL, 
                type VARCHAR(255) NOT NULL, 
                INDEX IDX_D34FCF004B5F0072 (file_upload_action_id), 
                PRIMARY KEY(id),
                CONSTRAINT UC_file_upload_file_type UNIQUE (file_upload_action_id, type),
                FOREIGN KEY (file_upload_action_id) 
                    REFERENCES `file_upload_action`(id) 
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('
            CREATE TABLE pascal_compilation_action (
                id INT NOT NULL, 
                action_id_to_compile INT NOT NULL, 
                PRIMARY KEY(id),
                FOREIGN KEY (id) 
                    REFERENCES `action`(id) 
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('
            CREATE TABLE teacher_evaluation_action (
                id INT NOT NULL, 
                action_id INT NOT NULL, 
                PRIMARY KEY(id),
                FOREIGN KEY (id) 
                    REFERENCES `action`(id) 
                    ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {

    }
}
