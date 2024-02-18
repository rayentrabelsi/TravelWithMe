<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215193342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id_comment INT AUTO_INCREMENT NOT NULL, author_c VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, replies_count INT NOT NULL, PRIMARY KEY(id_comment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moy_transport (id_transport INT AUTO_INCREMENT NOT NULL, transport_type VARCHAR(255) NOT NULL, departure_point VARCHAR(255) NOT NULL, arrival_point VARCHAR(255) NOT NULL, price INT NOT NULL, PRIMARY KEY(id_transport)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id_post INT AUTO_INCREMENT NOT NULL, author VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', views_count INT NOT NULL, PRIMARY KEY(id_post)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport_reservation (id_reservation INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, transport_id INT DEFAULT NULL, reservation_datetime DATE NOT NULL, passenger_count INT NOT NULL, INDEX IDX_D4A6AA529395C3F3 (customer_id), INDEX IDX_D4A6AA529909C13F (transport_id), PRIMARY KEY(id_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transport_reservation ADD CONSTRAINT FK_D4A6AA529395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transport_reservation ADD CONSTRAINT FK_D4A6AA529909C13F FOREIGN KEY (transport_id) REFERENCES moy_transport (id_transport)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transport_reservation DROP FOREIGN KEY FK_D4A6AA529395C3F3');
        $this->addSql('ALTER TABLE transport_reservation DROP FOREIGN KEY FK_D4A6AA529909C13F');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE moy_transport');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE transport_reservation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
