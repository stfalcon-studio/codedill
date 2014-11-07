<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141107164113 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('CREATE TABLE solutions_ratings (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, solution_id INT DEFAULT NULL, rating_value SMALLINT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F52B6FA3A76ED395 (user_id), INDEX IDX_F52B6FA31C0BE183 (solution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE solutions_ratings ADD CONSTRAINT FK_F52B6FA3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE solutions_ratings ADD CONSTRAINT FK_F52B6FA31C0BE183 FOREIGN KEY (solution_id) REFERENCES solutions (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE solutions_ratings');
    }
}
