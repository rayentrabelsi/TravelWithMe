<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303200749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking CHANGE id_booking id_booking INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id_booking)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking MODIFY id_booking INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON booking');
        $this->addSql('ALTER TABLE booking CHANGE id_booking id_booking INT NOT NULL');
    }
}
