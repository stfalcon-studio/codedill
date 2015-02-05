<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141205164633 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE solutions DROP FOREIGN KEY FK_A90F77EA76ED395');
        $this->addSql('ALTER TABLE solutions CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE solutions ADD CONSTRAINT FK_A90F77EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE solutions DROP FOREIGN KEY FK_A90F77EA76ED395');
        $this->addSql('ALTER TABLE solutions CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE solutions ADD CONSTRAINT FK_A90F77EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }
}
