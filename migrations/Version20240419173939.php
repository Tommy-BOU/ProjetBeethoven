<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419173939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, subscription_id INT NOT NULL, stripe_id VARCHAR(255) NOT NULL, amount_paid INT NOT NULL, number VARCHAR(255) NOT NULL, hosted_invoice_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_906517449A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, stripe_id VARCHAR(255) NOT NULL, price INT NOT NULL, created_at DATETIME NOT NULL, payment_link VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517449A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('ALTER TABLE subscription ADD plan_id INT NOT NULL, ADD user_id INT NOT NULL, ADD current_period_end DATETIME NOT NULL, ADD is_active TINYINT(1) NOT NULL, DROP price, CHANGE type stripe_id VARCHAR(255) NOT NULL, CHANGE subscription_date current_period_start DATETIME NOT NULL');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_A3C664D3E899029B ON subscription (plan_id)');
        $this->addSql('CREATE INDEX IDX_A3C664D3A76ED395 ON subscription (user_id)');
        $this->addSql('ALTER TABLE user ADD stripe_id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3E899029B');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517449A1887DC');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE plan');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3A76ED395');
        $this->addSql('DROP INDEX IDX_A3C664D3E899029B ON subscription');
        $this->addSql('DROP INDEX IDX_A3C664D3A76ED395 ON subscription');
        $this->addSql('ALTER TABLE subscription ADD price DOUBLE PRECISION NOT NULL, ADD subscription_date DATETIME NOT NULL, DROP plan_id, DROP user_id, DROP current_period_start, DROP current_period_end, DROP is_active, CHANGE stripe_id type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP stripe_id');
    }
}
