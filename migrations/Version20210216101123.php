<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210216101123 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidater (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, property_id INT DEFAULT NULL, candidature_at DATETIME NOT NULL, souhait_at VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', INDEX IDX_1D70C89AA76ED395 (user_id), INDEX IDX_1D70C89A549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidater ADD CONSTRAINT FK_1D70C89AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE candidater ADD CONSTRAINT FK_1D70C89A549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE dossier ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D48E037A76ED395 ON dossier (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE candidater');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037A76ED395');
        $this->addSql('DROP INDEX UNIQ_3D48E037A76ED395 ON dossier');
        $this->addSql('ALTER TABLE dossier DROP user_id');
    }
}
