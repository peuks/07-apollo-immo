<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122125959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE heat (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE property ADD heat_id INT DEFAULT NULL, DROP heat');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEA4033601 FOREIGN KEY (heat_id) REFERENCES heat (id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDEA4033601 ON property (heat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEA4033601');
        $this->addSql('DROP TABLE heat');
        $this->addSql('DROP INDEX IDX_8BF21CDEA4033601 ON property');
        $this->addSql('ALTER TABLE property ADD heat INT NOT NULL, DROP heat_id');
    }
}
