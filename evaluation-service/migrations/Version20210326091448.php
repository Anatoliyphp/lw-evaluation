<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210326091448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'add foreign key to task';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            ALTER TABLE task MODIFY pipeline_id INT NULL
        ');
        $this->addSql('
            ALTER TABLE task ADD CONSTRAINT fk_pipeline_id FOREIGN KEY (pipeline_id) REFERENCES evaluation_pipeline(id) ON DELETE SET NULL
        ');
    }

    public function down(Schema $schema) : void
    {

    }
}
