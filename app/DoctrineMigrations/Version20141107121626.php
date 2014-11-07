<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141107121626 extends AbstractMigration
{
    /**
     * Up migration
     *
     * @param Schema $schema Schema
     *
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE tasks (
            id INT AUTO_INCREMENT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description LONGTEXT NOT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8
            COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');

        $this->addSql('CREATE TABLE solutions (
            id INT AUTO_INCREMENT NOT NULL,
            task_id INT DEFAULT NULL,
            code LONGTEXT NOT NULL,
            INDEX IDX_A90F77E8DB60186 (task_id),
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8
            COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');

        $this->addSql('ALTER TABLE solutions ADD CONSTRAINT FK_A90F77E8DB60186 FOREIGN KEY (task_id) REFERENCES tasks (id)');
    }

    /**
     * Down migration
     *
     * @param Schema $schema Schema
     *
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE solutions DROP FOREIGN KEY FK_A90F77E8DB60186');
        $this->addSql('DROP TABLE tasks');
        $this->addSql('DROP TABLE solutions');
    }
}
