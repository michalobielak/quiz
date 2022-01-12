<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112211948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question_id INTEGER DEFAULT NULL, answer INTEGER NOT NULL, user INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('CREATE TABLE area (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, desription CLOB NOT NULL)');
        $this->addSql('CREATE TABLE competence (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, area_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_94D4687FBD0F409C ON competence (area_id)');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, area_id INTEGER DEFAULT NULL, competence_id INTEGER DEFAULT NULL, question VARCHAR(255) NOT NULL, range INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B6F7494EBD0F409C ON question (area_id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E15761DAB ON question (competence_id)');
        $this->addSql('CREATE TABLE summary (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, area_id INTEGER DEFAULT NULL, competence_id INTEGER DEFAULT NULL, evalution INTEGER NOT NULL, description CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_CE286663BD0F409C ON summary (area_id)');
        $this->addSql('CREATE INDEX IDX_CE28666315761DAB ON summary (competence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE area');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE summary');
    }
}
