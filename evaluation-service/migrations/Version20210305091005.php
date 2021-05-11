<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210305091005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Changes the description field type of the task table';
    }

    public function up(Schema $schema) : void
    {
         $this->addSql('
            ALTER TABLE task MODIFY description TEXT NOT NULL
         ');
    }

    public function down(Schema $schema) : void
    {
        // do nothing
    }
}
