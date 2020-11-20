<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201109192514 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, orders_id INT DEFAULT NULL, payment_card_id INT DEFAULT NULL, payment_method VARCHAR(255) NOT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_6D28840DCFFE9AD6 (orders_id), INDEX IDX_6D28840D538594CA (payment_card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_card (id INT AUTO_INCREMENT NOT NULL, card_number VARCHAR(255) NOT NULL, month VARCHAR(255) NOT NULL, year VARCHAR(255) NOT NULL, cvv VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D538594CA FOREIGN KEY (payment_card_id) REFERENCES payment_card (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D538594CA');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE payment_card');
    }
}
