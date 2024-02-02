<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240202125344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant_of_draw_participant (participant_of_draw_id INT NOT NULL, participant_id INT NOT NULL, PRIMARY KEY(participant_of_draw_id, participant_id))');
        $this->addSql('CREATE INDEX IDX_6E293272AE70D617 ON participant_of_draw_participant (participant_of_draw_id)');
        $this->addSql('CREATE INDEX IDX_6E2932729D1C3019 ON participant_of_draw_participant (participant_id)');
        $this->addSql('ALTER TABLE participant_of_draw_participant ADD CONSTRAINT FK_6E293272AE70D617 FOREIGN KEY (participant_of_draw_id) REFERENCES participant_of_draw (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant_of_draw_participant ADD CONSTRAINT FK_6E2932729D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant DROP CONSTRAINT fk_d79f6b11ae70d617');
        $this->addSql('DROP INDEX idx_d79f6b11ae70d617');
        $this->addSql('ALTER TABLE participant DROP participant_of_draw_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE participant_of_draw_participant DROP CONSTRAINT FK_6E293272AE70D617');
        $this->addSql('ALTER TABLE participant_of_draw_participant DROP CONSTRAINT FK_6E2932729D1C3019');
        $this->addSql('DROP TABLE participant_of_draw_participant');
        $this->addSql('ALTER TABLE participant ADD participant_of_draw_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT fk_d79f6b11ae70d617 FOREIGN KEY (participant_of_draw_id) REFERENCES participant_of_draw (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_d79f6b11ae70d617 ON participant (participant_of_draw_id)');
    }
}
