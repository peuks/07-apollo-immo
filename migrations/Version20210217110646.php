<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210217110646 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE property_option');
        $this->addSql('ALTER TABLE specificity ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE specificity ADD CONSTRAINT FK_EA204E50727ACA70 FOREIGN KEY (parent_id) REFERENCES specificity (id)');
        $this->addSql('CREATE INDEX IDX_EA204E50727ACA70 ON specificity (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE property_option (property_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_24F16FCCA7C41D6F (option_id), INDEX IDX_24F16FCC549213EC (property_id), PRIMARY KEY(property_id, option_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE property_option ADD CONSTRAINT FK_24F16FCC549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property_option ADD CONSTRAINT FK_24F16FCCA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specificity DROP FOREIGN KEY FK_EA204E50727ACA70');
        $this->addSql('DROP INDEX IDX_EA204E50727ACA70 ON specificity');
        $this->addSql('ALTER TABLE specificity DROP parent_id');
    }
}
