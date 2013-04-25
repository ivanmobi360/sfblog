<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130425143006 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE blog ADD user_id INT DEFAULT NULL, DROP author");
        $this->addSql("ALTER TABLE blog ADD CONSTRAINT FK_C0155143A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)");
        $this->addSql("CREATE INDEX IDX_C0155143A76ED395 ON blog (user_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE blog DROP FOREIGN KEY FK_C0155143A76ED395");
        $this->addSql("DROP INDEX IDX_C0155143A76ED395 ON blog");
        $this->addSql("ALTER TABLE blog ADD author VARCHAR(100) NOT NULL, DROP user_id");
    }
}
