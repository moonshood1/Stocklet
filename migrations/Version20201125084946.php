<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125084946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, promo_code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, promo_reduction DOUBLE PRECISION NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_order (promo_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_1C00AF0ED0C07AFF (promo_id), INDEX IDX_1C00AF0E8D9F6D38 (order_id), PRIMARY KEY(promo_id, order_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_user (promo_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C70A754FD0C07AFF (promo_id), INDEX IDX_C70A754FA76ED395 (user_id), PRIMARY KEY(promo_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promo_order ADD CONSTRAINT FK_1C00AF0ED0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_order ADD CONSTRAINT FK_1C00AF0E8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_user ADD CONSTRAINT FK_C70A754FD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_user ADD CONSTRAINT FK_C70A754FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo_order DROP FOREIGN KEY FK_1C00AF0ED0C07AFF');
        $this->addSql('ALTER TABLE promo_user DROP FOREIGN KEY FK_C70A754FD0C07AFF');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE promo_order');
        $this->addSql('DROP TABLE promo_user');
    }
}
