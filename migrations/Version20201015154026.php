<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201015154026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD left_pic1_name VARCHAR(255) NOT NULL, ADD left_pic2_name VARCHAR(255) NOT NULL, ADD left_pic3_name VARCHAR(255) NOT NULL, ADD right_pic1_name VARCHAR(255) NOT NULL, ADD right_pic2_name VARCHAR(255) NOT NULL, ADD right_pic3_name VARCHAR(255) NOT NULL, ADD right_pic4_name VARCHAR(255) NOT NULL, ADD right_pic5_name VARCHAR(255) NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP left_pic1_name, DROP left_pic2_name, DROP left_pic3_name, DROP right_pic1_name, DROP right_pic2_name, DROP right_pic3_name, DROP right_pic4_name, DROP right_pic5_name, DROP updated_at');
    }
}
