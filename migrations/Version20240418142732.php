<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418142732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrowing ADD prolongated TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE birthdate birthdate DATE NOT NULL, CHANGE zip_code zip_code INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrowing DROP prolongated');
        $this->addSql('ALTER TABLE `user` CHANGE birthdate birthdate DATE DEFAULT NULL, CHANGE zip_code zip_code INT DEFAULT NULL');
    }
}
