<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126203732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE426F42F66C8');
        $this->addSql('DROP INDEX IDX_153CE426F42F66C8 ON suite');
        $this->addSql('ALTER TABLE suite DROP hotels_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suite ADD hotels_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE426F42F66C8 FOREIGN KEY (hotels_id) REFERENCES hotel (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_153CE426F42F66C8 ON suite (hotels_id)');
    }
}
