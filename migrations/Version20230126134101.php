<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126134101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, surname VARCHAR(60) NOT NULL, email VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, surname VARCHAR(60) NOT NULL, email VARCHAR(60) NOT NULL, password VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, manager_id INT DEFAULT NULL, admins_id INT DEFAULT NULL, adress VARCHAR(255) NOT NULL, name VARCHAR(60) NOT NULL, city VARCHAR(60) NOT NULL, number_of_rooms INT NOT NULL, email VARCHAR(60) NOT NULL, description LONGTEXT NOT NULL, cover_img VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3535ED9642B8210 (admin_id), UNIQUE INDEX UNIQ_3535ED9783E3463 (manager_id), INDEX IDX_3535ED9FAA286C3 (admins_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manager (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, admins_id INT DEFAULT NULL, name VARCHAR(60) NOT NULL, surname VARCHAR(60) NOT NULL, email VARCHAR(60) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FA2425B9642B8210 (admin_id), INDEX IDX_FA2425B9FAA286C3 (admins_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suite (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, hotel_id INT DEFAULT NULL, hotels_id INT DEFAULT NULL, name VARCHAR(60) NOT NULL, description VARCHAR(255) NOT NULL, photo LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_153CE42619EB6921 (client_id), UNIQUE INDEX UNIQ_153CE4263243BB18 (hotel_id), INDEX IDX_153CE426F42F66C8 (hotels_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9642B8210 FOREIGN KEY (admin_id) REFERENCES `admin` (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9783E3463 FOREIGN KEY (manager_id) REFERENCES manager (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9FAA286C3 FOREIGN KEY (admins_id) REFERENCES `admin` (id)');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B9642B8210 FOREIGN KEY (admin_id) REFERENCES `admin` (id)');
        $this->addSql('ALTER TABLE manager ADD CONSTRAINT FK_FA2425B9FAA286C3 FOREIGN KEY (admins_id) REFERENCES `admin` (id)');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE42619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE4263243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE suite ADD CONSTRAINT FK_153CE426F42F66C8 FOREIGN KEY (hotels_id) REFERENCES hotel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9642B8210');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9783E3463');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9FAA286C3');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B9642B8210');
        $this->addSql('ALTER TABLE manager DROP FOREIGN KEY FK_FA2425B9FAA286C3');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE42619EB6921');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE4263243BB18');
        $this->addSql('ALTER TABLE suite DROP FOREIGN KEY FK_153CE426F42F66C8');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE manager');
        $this->addSql('DROP TABLE suite');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
