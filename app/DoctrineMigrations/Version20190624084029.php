<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190624084029 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE counseling_register CHANGE q2 q2 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE q3 q3 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE q4 q4 LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE counseling_register CHANGE q2 q2 TEXT DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE q3 q3 TEXT DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE q4 q4 TEXT DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
