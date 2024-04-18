<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418075119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E589771868B2E');
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E58979D86650F');
        $this->addSql('DROP INDEX idx_226e58979d86650f ON borrowing');
        $this->addSql('CREATE INDEX IDX_226E5897A76ED395 ON borrowing (user_id)');
        $this->addSql('DROP INDEX uniq_226e589771868b2e ON borrowing');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_226E589716A2B381 ON borrowing (book_id)');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E589771868B2E FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E58979D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD last_name VARCHAR(255) NOT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD zip_code INT NOT NULL, DROP name, DROP prenom, DROP adresse, DROP ville, CHANGE date_de_naissance birthdate DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E5897A76ED395');
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E589716A2B381');
        $this->addSql('DROP INDEX idx_226e5897a76ed395 ON borrowing');
        $this->addSql('CREATE INDEX IDX_226E58979D86650F ON borrowing (user_id)');
        $this->addSql('DROP INDEX uniq_226e589716a2b381 ON borrowing');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_226E589771868B2E ON borrowing (book_id)');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E5897A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E589716A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE `user` ADD name VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, DROP last_name, DROP first_name, DROP address, DROP city, DROP zip_code, CHANGE birthdate date_de_naissance DATE NOT NULL');
    }
}
