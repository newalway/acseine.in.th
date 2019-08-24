<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190712101832 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customer_payment_linepay (id INT AUTO_INCREMENT NOT NULL, customer_order_id INT DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, currency VARCHAR(45) NOT NULL, order_id VARCHAR(255) NOT NULL, transaction_id VARCHAR(255) DEFAULT NULL, payment_access_token VARCHAR(255) DEFAULT NULL, reserve_info_payment_url_web VARCHAR(255) DEFAULT NULL, reserve_info_payment_url_app VARCHAR(255) DEFAULT NULL, reserve_return_code VARCHAR(255) DEFAULT NULL, reserve_return_message VARCHAR(255) DEFAULT NULL, confirm_return_code VARCHAR(255) DEFAULT NULL, confirm_return_message VARCHAR(255) DEFAULT NULL, confirm_info_method VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B7D4DA3EA15A2E17 (customer_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_payment_linepay ADD CONSTRAINT FK_B7D4DA3EA15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE customer_payment_linepay');
    }
}
