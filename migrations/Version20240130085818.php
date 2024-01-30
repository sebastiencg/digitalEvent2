<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240130085818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE response_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE response_of_question_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE response_of_question (id INT NOT NULL, response_id INT NOT NULL, is_true BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AAB5A52AFBF32840 ON response_of_question (response_id)');
        $this->addSql('ALTER TABLE response_of_question ADD CONSTRAINT FK_AAB5A52AFBF32840 FOREIGN KEY (response_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE response DROP CONSTRAINT fk_3e7b0bfbfbf32840');
        $this->addSql('DROP TABLE response');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE response_of_question_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE response_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE response (id INT NOT NULL, response_id INT NOT NULL, is_true BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_3e7b0bfbfbf32840 ON response (response_id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT fk_3e7b0bfbfbf32840 FOREIGN KEY (response_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE response_of_question DROP CONSTRAINT FK_AAB5A52AFBF32840');
        $this->addSql('DROP TABLE response_of_question');
    }
}
