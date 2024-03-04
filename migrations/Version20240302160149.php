<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302160149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id_comment INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, reacts_id INT DEFAULT NULL, parent_comment_id INT DEFAULT NULL, author_c VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, replies_count INT NOT NULL, signaler INT NOT NULL, INDEX IDX_9474526C4B89032C (post_id), UNIQUE INDEX UNIQ_9474526CEF2E3ED8 (reacts_id), INDEX IDX_9474526CBF2AF943 (parent_comment_id), PRIMARY KEY(id_comment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id_post INT AUTO_INCREMENT NOT NULL, author VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', views_count INT NOT NULL, PRIMARY KEY(id_post)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE react (id INT AUTO_INCREMENT NOT NULL, likes INT NOT NULL, dislike INT NOT NULL, userlike VARCHAR(255) DEFAULT NULL, userdislike VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id_post)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEF2E3ED8 FOREIGN KEY (reacts_id) REFERENCES react (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CBF2AF943 FOREIGN KEY (parent_comment_id) REFERENCES comment (id_comment)');
        $this->addSql('ALTER TABLE user CHANGE auth_code auth_code VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CEF2E3ED8');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CBF2AF943');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE react');
        $this->addSql('ALTER TABLE user CHANGE auth_code auth_code VARCHAR(255) DEFAULT NULL');
    }
}
