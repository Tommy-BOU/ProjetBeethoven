<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417091604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD last_name VARCHAR(255) NOT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD zip_code INT NOT NULL, DROP name, DROP prenom, DROP adresse, DROP ville, CHANGE date_de_naissance birthdate DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` ADD name VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, DROP last_name, DROP first_name, DROP address, DROP city, DROP zip_code, CHANGE birthdate date_de_naissance DATE NOT NULL');
    }
}
