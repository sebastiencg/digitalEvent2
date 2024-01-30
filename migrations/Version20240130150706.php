<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240130150706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE participant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE party_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE point_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE participant (id INT NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE party (id INT NOT NULL, participants_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_89954EE0838709D5 ON party (participants_id)');
        $this->addSql('CREATE TABLE party_question (party_id INT NOT NULL, question_id INT NOT NULL, PRIMARY KEY(party_id, question_id))');
        $this->addSql('CREATE INDEX IDX_1A594191213C1059 ON party_question (party_id)');
        $this->addSql('CREATE INDEX IDX_1A5941911E27F6BF ON party_question (question_id)');
        $this->addSql('CREATE TABLE point (id INT NOT NULL, username_id INT DEFAULT NULL, point INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B7A5F324ED766068 ON point (username_id)');
        $this->addSql('ALTER TABLE party ADD CONSTRAINT FK_89954EE0838709D5 FOREIGN KEY (participants_id) REFERENCES participant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE party_question ADD CONSTRAINT FK_1A594191213C1059 FOREIGN KEY (party_id) REFERENCES party (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE party_question ADD CONSTRAINT FK_1A5941911E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE point ADD CONSTRAINT FK_B7A5F324ED766068 FOREIGN KEY (username_id) REFERENCES participant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE participant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE party_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE point_id_seq CASCADE');
        $this->addSql('ALTER TABLE party DROP CONSTRAINT FK_89954EE0838709D5');
        $this->addSql('ALTER TABLE party_question DROP CONSTRAINT FK_1A594191213C1059');
        $this->addSql('ALTER TABLE party_question DROP CONSTRAINT FK_1A5941911E27F6BF');
        $this->addSql('ALTER TABLE point DROP CONSTRAINT FK_B7A5F324ED766068');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE party_question');
        $this->addSql('DROP TABLE point');
    }
}
