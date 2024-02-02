<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201230552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE participant_of_draw_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE participant_of_draw (id INT NOT NULL, draw_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4FC7FA346FC5C1B8 ON participant_of_draw (draw_id)');
        $this->addSql('ALTER TABLE participant_of_draw ADD CONSTRAINT FK_4FC7FA346FC5C1B8 FOREIGN KEY (draw_id) REFERENCES draw (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participant ADD participant_of_draw_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11AE70D617 FOREIGN KEY (participant_of_draw_id) REFERENCES participant_of_draw (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D79F6B11AE70D617 ON participant (participant_of_draw_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE participant DROP CONSTRAINT FK_D79F6B11AE70D617');
        $this->addSql('DROP SEQUENCE participant_of_draw_id_seq CASCADE');
        $this->addSql('ALTER TABLE participant_of_draw DROP CONSTRAINT FK_4FC7FA346FC5C1B8');
        $this->addSql('DROP TABLE participant_of_draw');
        $this->addSql('DROP INDEX IDX_D79F6B11AE70D617');
        $this->addSql('ALTER TABLE participant DROP participant_of_draw_id');
    }
}
