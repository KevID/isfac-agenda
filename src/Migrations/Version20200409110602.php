<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200409110602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agenda (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_heure DATETIME NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_2CEDC877A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agenda_comment (id INT AUTO_INCREMENT NOT NULL, agenda_id INT DEFAULT NULL, user_id INT DEFAULT NULL, commentaire LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_17B0302DEA67784A (agenda_id), INDEX IDX_17B0302DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agenda ADD CONSTRAINT FK_2CEDC877A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE agenda_comment ADD CONSTRAINT FK_17B0302DEA67784A FOREIGN KEY (agenda_id) REFERENCES agenda (id)');
        $this->addSql('ALTER TABLE agenda_comment ADD CONSTRAINT FK_17B0302DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agenda_comment DROP FOREIGN KEY FK_17B0302DEA67784A');
        $this->addSql('ALTER TABLE agenda DROP FOREIGN KEY FK_2CEDC877A76ED395');
        $this->addSql('ALTER TABLE agenda_comment DROP FOREIGN KEY FK_17B0302DA76ED395');
        $this->addSql('DROP TABLE agenda');
        $this->addSql('DROP TABLE agenda_comment');
        $this->addSql('DROP TABLE user');
    }
}
