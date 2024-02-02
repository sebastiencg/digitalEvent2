<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201220014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE draw_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE draw (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE question ADD draw_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E6FC5C1B8 FOREIGN KEY (draw_id) REFERENCES draw (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B6F7494E6FC5C1B8 ON question (draw_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE question DROP CONSTRAINT FK_B6F7494E6FC5C1B8');
        $this->addSql('DROP SEQUENCE draw_id_seq CASCADE');
        $this->addSql('DROP TABLE draw');
        $this->addSql('DROP INDEX IDX_B6F7494E6FC5C1B8');
        $this->addSql('ALTER TABLE question DROP draw_id');
    }
}
