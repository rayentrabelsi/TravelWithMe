<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303165617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, voyage_id INT DEFAULT NULL, number_membre INT NOT NULL, UNIQUE INDEX UNIQ_4B98C2168C9E5AF (voyage_id), UNIQUE INDEX UNIQ_4B98C21FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hebergement (id INT AUTO_INCREMENT NOT NULL, lieu VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voyage (id INT AUTO_INCREMENT NOT NULL, hebergement_id INT NOT NULL, evenement_id INT NOT NULL, utilisateur_id INT NOT NULL, id_transport INT DEFAULT NULL, vehicule_id INT NOT NULL, depart DATE NOT NULL, arrivee DATE NOT NULL, INDEX IDX_3F9D8955E69E9D09 (id_transport), INDEX IDX_3F9D895523BB0F66 (hebergement_id), INDEX IDX_3F9D8955FD02F13 (evenement_id), UNIQUE INDEX UNIQ_3F9D8955FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C2168C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955E69E9D09 FOREIGN KEY (id_transport) REFERENCES moy_transport (id_transport)');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D895523BB0F66 FOREIGN KEY (hebergement_id) REFERENCES hebergement (id)');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955FD02F13 FOREIGN KEY (evenement_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C2168C9E5AF');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21FB88E14F');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D8955E69E9D09');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D895523BB0F66');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D8955FD02F13');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D8955FB88E14F');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE hebergement');
        $this->addSql('DROP TABLE voyage');
    }
}
