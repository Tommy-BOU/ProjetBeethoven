<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418075541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_226E58979D86650F ON borrowing');
        $this->addSql('DROP INDEX UNIQ_226E589771868B2E ON borrowing');
        $this->addSql('ALTER TABLE borrowing ADD user_id INT NOT NULL, ADD book_id INT NOT NULL, DROP user_id_id, DROP book_id_id');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E5897A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E589716A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_226E5897A76ED395 ON borrowing (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_226E589716A2B381 ON borrowing (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E5897A76ED395');
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E589716A2B381');
        $this->addSql('DROP INDEX IDX_226E5897A76ED395 ON borrowing');
        $this->addSql('DROP INDEX UNIQ_226E589716A2B381 ON borrowing');
        $this->addSql('ALTER TABLE borrowing ADD user_id_id INT NOT NULL, ADD book_id_id INT NOT NULL, DROP user_id, DROP book_id');
        $this->addSql('CREATE INDEX IDX_226E58979D86650F ON borrowing (user_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_226E589771868B2E ON borrowing (book_id_id)');
    }
}
