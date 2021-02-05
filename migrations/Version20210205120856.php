<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205120856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE heat (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_property (option_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_AB856D7AA7C41D6F (option_id), INDEX IDX_AB856D7A549213EC (property_id), PRIMARY KEY(option_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, heat_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, surface INT NOT NULL, rooms INT NOT NULL, bedrooms INT NOT NULL, floor INT NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postale_code INT NOT NULL, sold TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, price INT NOT NULL, INDEX IDX_8BF21CDEA4033601 (heat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE option_property ADD CONSTRAINT FK_AB856D7AA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_property ADD CONSTRAINT FK_AB856D7A549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEA4033601 FOREIGN KEY (heat_id) REFERENCES heat (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEA4033601');
        $this->addSql('ALTER TABLE option_property DROP FOREIGN KEY FK_AB856D7AA7C41D6F');
        $this->addSql('ALTER TABLE option_property DROP FOREIGN KEY FK_AB856D7A549213EC');
        $this->addSql('DROP TABLE heat');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE option_property');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE user');
    }
}
