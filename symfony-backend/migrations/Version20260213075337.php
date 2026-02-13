<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213075337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, event_date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, description CLOB DEFAULT NULL, is_visible BOOLEAN DEFAULT 1 NOT NULL, position INTEGER DEFAULT 0 NOT NULL)');
        $this->addSql('CREATE TABLE photo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, event_date DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, event_name VARCHAR(255) DEFAULT NULL, position INTEGER DEFAULT 0 NOT NULL, is_visible BOOLEAN DEFAULT 1 NOT NULL)');
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, notes CLOB DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, duration INTEGER DEFAULT NULL, position INTEGER DEFAULT 0 NOT NULL, is_visible BOOLEAN DEFAULT 1 NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, instrument VARCHAR(100) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, youtube_id VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, created_at DATETIME NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE song');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE video');
    }
}
