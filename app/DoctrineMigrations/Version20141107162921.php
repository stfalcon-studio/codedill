<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141107162921 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE tasks ADD user_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_50586597A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_50586597A76ED395 ON tasks (user_id)');
        $this->addSql('ALTER TABLE solutions ADD user_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE solutions ADD CONSTRAINT FK_A90F77EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_A90F77EA76ED395 ON solutions (user_id)');
        $this->addSql('ALTER TABLE comment ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395 ON comment');
        $this->addSql('ALTER TABLE comment DROP user_id');
        $this->addSql('ALTER TABLE solutions DROP FOREIGN KEY FK_A90F77EA76ED395');
        $this->addSql('DROP INDEX IDX_A90F77EA76ED395 ON solutions');
        $this->addSql('ALTER TABLE solutions DROP user_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_50586597A76ED395');
        $this->addSql('DROP INDEX IDX_50586597A76ED395 ON tasks');
        $this->addSql('ALTER TABLE tasks DROP user_id, DROP created_at, DROP updated_at');
    }
}
