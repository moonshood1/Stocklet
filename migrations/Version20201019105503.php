<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201019105503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE left_pic1_name left_pic1_name VARCHAR(255) DEFAULT NULL, CHANGE left_pic2_name left_pic2_name VARCHAR(255) DEFAULT NULL, CHANGE left_pic3_name left_pic3_name VARCHAR(255) DEFAULT NULL, CHANGE right_pic1_name right_pic1_name VARCHAR(255) DEFAULT NULL, CHANGE right_pic2_name right_pic2_name VARCHAR(255) DEFAULT NULL, CHANGE right_pic3_name right_pic3_name VARCHAR(255) DEFAULT NULL, CHANGE right_pic4_name right_pic4_name VARCHAR(255) DEFAULT NULL, CHANGE right_pic5_name right_pic5_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE picture_name picture_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE left_pic1_name left_pic1_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE left_pic2_name left_pic2_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE left_pic3_name left_pic3_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE right_pic1_name right_pic1_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE right_pic2_name right_pic2_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE right_pic3_name right_pic3_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE right_pic4_name right_pic4_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE right_pic5_name right_pic5_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE picture_name picture_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
