<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210222102539 extends AbstractMigration
{
    public function getDescription() : string
    {
        // teacher@test.com Test1234
        // student@test.com Test1234
        return 'Adds test user credentials';
    }

    public function up(Schema $schema) : void
    {
         $this->addSql('
         INSERT INTO
           `group` (id, name)
         VALUES
           (1, "ПС-11 2021")
         ');
        
        $this->addSql('
        INSERT INTO
          `user` (id, email, role, first_name, last_name, group_id, password)
        VALUES
          (DEFAULT, "teacher@test.com", 2, "Преподаватель", "Предметович", NULL, "$argon2id$v=19$m=65536,t=4,p=1$EOoOxmEzjqlXi4WqI5j/Iw$MBoUY4ZwG0X44K4m4RkyBcVjuAImRCFTXSP+7ZBUSo8"),
          (DEFAULT, "student@test.com", 1, "Студент", "Василиевич", 1, "$argon2id$v=19$m=65536,t=4,p=1$Jq87+7D7+IU5aJb5meJPdw$Dmz78uHtd7kCSZuuP+wLX9wOzOUyExTVo6xLWR5vIPI")
        ');
    }

    public function down(Schema $schema) : void
    {
        // do nothing
    }
}
