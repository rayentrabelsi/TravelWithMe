<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303220236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D895523BB0F66');
        $this->addSql('DROP TABLE hebergement');
        $this->addSql('DROP INDEX IDX_3F9D895523BB0F66 ON voyage');
        $this->addSql('ALTER TABLE voyage ADD accomodation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955FD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id)');
        $this->addSql('CREATE INDEX IDX_3F9D8955FD70509C ON voyage (accomodation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hebergement (id INT AUTO_INCREMENT NOT NULL, lieu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D8955FD70509C');
        $this->addSql('DROP INDEX IDX_3F9D8955FD70509C ON voyage');
        $this->addSql('ALTER TABLE voyage DROP accomodation_id');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D895523BB0F66 FOREIGN KEY (hebergement_id) REFERENCES hebergement (id)');
        $this->addSql('CREATE INDEX IDX_3F9D895523BB0F66 ON voyage (hebergement_id)');
    }
}
