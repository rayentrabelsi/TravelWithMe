<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303172128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D8955E69E9D09');
        $this->addSql('DROP INDEX IDX_3F9D8955E69E9D09 ON voyage');
        $this->addSql('ALTER TABLE voyage DROP id_transport');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D89554A4A3511 FOREIGN KEY (vehicule_id) REFERENCES moy_transport (id_transport)');
        $this->addSql('CREATE INDEX IDX_3F9D89554A4A3511 ON voyage (vehicule_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D89554A4A3511');
        $this->addSql('DROP INDEX IDX_3F9D89554A4A3511 ON voyage');
        $this->addSql('ALTER TABLE voyage ADD id_transport INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955E69E9D09 FOREIGN KEY (id_transport) REFERENCES moy_transport (id_transport)');
        $this->addSql('CREATE INDEX IDX_3F9D8955E69E9D09 ON voyage (id_transport)');
    }
}
