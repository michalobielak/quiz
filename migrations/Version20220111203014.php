<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111203014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_DADD4A251E27F6BF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__answer AS SELECT id, question_id, answer, user FROM answer');
        $this->addSql('DROP TABLE answer');
        $this->addSql('CREATE TABLE answer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER DEFAULT NULL, answer INTEGER NOT NULL, user INTEGER NOT NULL, CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO answer (id, question_id, answer, user) SELECT id, question_id, answer, user FROM __temp__answer');
        $this->addSql('DROP TABLE __temp__answer');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('DROP INDEX IDX_94D4687FBD0F409C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__competence AS SELECT id, area_id, name, description FROM competence');
        $this->addSql('DROP TABLE competence');
        $this->addSql('CREATE TABLE competence (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, area_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_94D4687FBD0F409C FOREIGN KEY (area_id) REFERENCES area (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO competence (id, area_id, name, description) SELECT id, area_id, name, description FROM __temp__competence');
        $this->addSql('DROP TABLE __temp__competence');
        $this->addSql('CREATE INDEX IDX_94D4687FBD0F409C ON competence (area_id)');
        $this->addSql('DROP INDEX IDX_B6F7494E15761DAB');
        $this->addSql('DROP INDEX IDX_B6F7494EBD0F409C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__question AS SELECT id, area_id, competence_id, question, range FROM question');
        $this->addSql('DROP TABLE question');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, area_id INTEGER DEFAULT NULL, competence_id INTEGER DEFAULT NULL, question VARCHAR(255) NOT NULL COLLATE BINARY, range INTEGER NOT NULL, CONSTRAINT FK_B6F7494EBD0F409C FOREIGN KEY (area_id) REFERENCES area (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6F7494E15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO question (id, area_id, competence_id, question, range) SELECT id, area_id, competence_id, question, range FROM __temp__question');
        $this->addSql('DROP TABLE __temp__question');
        $this->addSql('CREATE INDEX IDX_B6F7494E15761DAB ON question (competence_id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EBD0F409C ON question (area_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_DADD4A251E27F6BF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__answer AS SELECT id, question_id, answer, user FROM answer');
        $this->addSql('DROP TABLE answer');
        $this->addSql('CREATE TABLE answer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER DEFAULT NULL, answer INTEGER NOT NULL, user INTEGER NOT NULL)');
        $this->addSql('INSERT INTO answer (id, question_id, answer, user) SELECT id, question_id, answer, user FROM __temp__answer');
        $this->addSql('DROP TABLE __temp__answer');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('DROP INDEX IDX_94D4687FBD0F409C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__competence AS SELECT id, area_id, name, description FROM competence');
        $this->addSql('DROP TABLE competence');
        $this->addSql('CREATE TABLE competence (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, area_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('INSERT INTO competence (id, area_id, name, description) SELECT id, area_id, name, description FROM __temp__competence');
        $this->addSql('DROP TABLE __temp__competence');
        $this->addSql('CREATE INDEX IDX_94D4687FBD0F409C ON competence (area_id)');
        $this->addSql('DROP INDEX IDX_B6F7494EBD0F409C');
        $this->addSql('DROP INDEX IDX_B6F7494E15761DAB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__question AS SELECT id, area_id, competence_id, question, range FROM question');
        $this->addSql('DROP TABLE question');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, area_id INTEGER DEFAULT NULL, competence_id INTEGER DEFAULT NULL, question VARCHAR(255) NOT NULL, range INTEGER NOT NULL)');
        $this->addSql('INSERT INTO question (id, area_id, competence_id, question, range) SELECT id, area_id, competence_id, question, range FROM __temp__question');
        $this->addSql('DROP TABLE __temp__question');
        $this->addSql('CREATE INDEX IDX_B6F7494EBD0F409C ON question (area_id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E15761DAB ON question (competence_id)');
    }
}
