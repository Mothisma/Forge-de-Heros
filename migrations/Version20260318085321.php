<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260318085321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__party AS SELECT id, name, description, max_size, user_id FROM party');
        $this->addSql('DROP TABLE party');
        $this->addSql('CREATE TABLE party (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, max_size INTEGER NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_89954EE0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO party (id, name, description, max_size, user_id) SELECT id, name, description, max_size, user_id FROM __temp__party');
        $this->addSql('DROP TABLE __temp__party');
        $this->addSql('CREATE INDEX IDX_89954EE0A76ED395 ON party (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__party AS SELECT id, name, description, max_size, user_id FROM party');
        $this->addSql('DROP TABLE party');
        $this->addSql('CREATE TABLE party (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, max_size INTEGER NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_89954EE0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO party (id, name, description, max_size, user_id) SELECT id, name, description, max_size, user_id FROM __temp__party');
        $this->addSql('DROP TABLE __temp__party');
        $this->addSql('CREATE INDEX IDX_89954EE0A76ED395 ON party (user_id)');
    }
}
