<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126204446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE4263243BB18');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE426F452D9C6');
        $this->addSql('DROP INDEX IDX_153CE426F452D9C6 ON suite');
        $this->addSql('DROP INDEX UNIQ_153CE4263243BB18 ON suite');
        $this->addSql('ALTER TABLE suite DROP hotel_id, DROP suites_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suite ADD hotel_id INT DEFAULT NULL, ADD suites_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE4263243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE426F452D9C6 FOREIGN KEY (suites_id) REFERENCES hotel (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_153CE426F452D9C6 ON suite (suites_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_153CE4263243BB18 ON suite (hotel_id)');
    }
}
