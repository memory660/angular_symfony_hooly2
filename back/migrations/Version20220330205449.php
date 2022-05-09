<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330205449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, date_reservation DATE NOT NULL, week_no INT NOT NULL, date_begin DATE NOT NULL, date_end DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, location_no INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, day_id INT NOT NULL, user_id INT NOT NULL, location_id INT NOT NULL, society_id INT NOT NULL, INDEX IDX_42C849559C24126 (day_id), INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C8495564D218E (location_id), INDEX IDX_42C84955E6389D24 (society_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE society (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495564D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955E6389D24 FOREIGN KEY (society_id) REFERENCES society (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559C24126');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495564D218E');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955E6389D24');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE society');
        $this->addSql('DROP TABLE user');
    }
}
