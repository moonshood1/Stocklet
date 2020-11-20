<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201015093555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, category_description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, author_id INT NOT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_9474526C4584665A (product_id), INDEX IDX_9474526CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, products_id INT NOT NULL, users_id INT NOT NULL, product_quantity INT NOT NULL, product_unit_price DOUBLE PRECISION NOT NULL, order_total_amount DOUBLE PRECISION NOT NULL, order_date DATETIME NOT NULL, shipping_city VARCHAR(255) NOT NULL, shipping_district VARCHAR(255) NOT NULL, shipping_address1 VARCHAR(255) NOT NULL, shipping_address2 VARCHAR(255) DEFAULT NULL, INDEX IDX_F52993986C8A81A9 (products_id), INDEX IDX_F529939867B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, product_name VARCHAR(255) NOT NULL, product_description1 LONGTEXT NOT NULL, product_description2 LONGTEXT NOT NULL, unit_price DOUBLE PRECISION NOT NULL, product_available TINYINT(1) NOT NULL, brand VARCHAR(255) NOT NULL, initial_stock INT NOT NULL, current_stock INT NOT NULL, spec1 LONGTEXT DEFAULT NULL, spec1_title VARCHAR(255) DEFAULT NULL, spec2 LONGTEXT DEFAULT NULL, spec2_title LONGTEXT DEFAULT NULL, spec3 LONGTEXT DEFAULT NULL, spec3_title VARCHAR(255) DEFAULT NULL, end_date DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, left_pic1_url VARCHAR(255) DEFAULT NULL, left_pic2_url VARCHAR(255) DEFAULT NULL, left_pic3_url VARCHAR(255) DEFAULT NULL, right_pic1_url VARCHAR(255) DEFAULT NULL, right_pic2_url VARCHAR(255) DEFAULT NULL, right_pic3_url VARCHAR(255) DEFAULT NULL, right_pic4_url VARCHAR(255) DEFAULT NULL, right_pic5_url VARCHAR(255) DEFAULT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_332CA4DDD60322AC (role_id), INDEX IDX_332CA4DDA76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, user_phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939867B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4584665A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986C8A81A9');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939867B3B43D');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE user');
    }
}
