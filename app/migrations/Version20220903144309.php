<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220903144309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE death_note (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, born_year INT NOT NULL, city_of_born LONGTEXT NOT NULL, dead_year INT NOT NULL, city_of_dead LONGTEXT NOT NULL, age INT NOT NULL, dead_nyears_ago INT NOT NULL, now INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, quote_author_id INT DEFAULT NULL, quote LONGTEXT NOT NULL, historian LONGTEXT NOT NULL, year INT NOT NULL, address LONGTEXT NOT NULL, INDEX IDX_6B71CBF471976A61 (quote_author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF471976A61 FOREIGN KEY (quote_author_id) REFERENCES death_note (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF471976A61');
        $this->addSql('DROP TABLE death_note');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE user');
    }
}
