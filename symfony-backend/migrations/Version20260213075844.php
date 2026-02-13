<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213075844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video ADD COLUMN event_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD COLUMN event_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD COLUMN position INTEGER DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE video ADD COLUMN is_visible BOOLEAN DEFAULT 1 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__video AS SELECT id, title, youtube_id, description, created_at FROM video');
        $this->addSql('DROP TABLE video');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, youtube_id VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO video (id, title, youtube_id, description, created_at) SELECT id, title, youtube_id, description, created_at FROM __temp__video');
        $this->addSql('DROP TABLE __temp__video');
    }
}
