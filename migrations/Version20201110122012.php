<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110122012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_card ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment_card ADD CONSTRAINT FK_37970FA767B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_37970FA767B3B43D ON payment_card (users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_card DROP FOREIGN KEY FK_37970FA767B3B43D');
        $this->addSql('DROP INDEX IDX_37970FA767B3B43D ON payment_card');
        $this->addSql('ALTER TABLE payment_card DROP users_id');
    }
}
