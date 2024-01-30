<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240130192134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant ADD party_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11213C1059 FOREIGN KEY (party_id) REFERENCES party (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D79F6B11213C1059 ON participant (party_id)');
        $this->addSql('ALTER TABLE party DROP CONSTRAINT fk_89954ee0838709d5');
        $this->addSql('DROP INDEX idx_89954ee0838709d5');
        $this->addSql('ALTER TABLE party DROP participants_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE party ADD participants_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT fk_89954ee0838709d5 FOREIGN KEY (participants_id) REFERENCES participant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_89954ee0838709d5 ON party (participants_id)');
        $this->addSql('ALTER TABLE participant DROP CONSTRAINT FK_D79F6B11213C1059');
        $this->addSql('DROP INDEX IDX_D79F6B11213C1059');
        $this->addSql('ALTER TABLE participant DROP party_id');
    }
}
