<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212144340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reseau (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travailler (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, started_at DATETIME NOT NULL, INDEX IDX_90B2DF3DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE travailler ADD CONSTRAINT FK_90B2DF3DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE agence_user');
        $this->addSql('ALTER TABLE agence ADD travailler_id INT DEFAULT NULL, ADD reseau_id INT DEFAULT NULL, ADD adresse_postale VARCHAR(255) NOT NULL, CHANGE raison_sociale raison_sociale VARCHAR(100) NOT NULL, CHANGE nom_commercial nom_commercial VARCHAR(50) NOT NULL, CHANGE telephone telephone VARCHAR(20) NOT NULL, CHANGE mail mail VARCHAR(50) NOT NULL, CHANGE responsable_agence responsable_agence VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9693DB813 FOREIGN KEY (travailler_id) REFERENCES travailler (id)');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9445D170C FOREIGN KEY (reseau_id) REFERENCES reseau (id)');
        $this->addSql('CREATE INDEX IDX_64C19AA9693DB813 ON agence (travailler_id)');
        $this->addSql('CREATE INDEX IDX_64C19AA9445D170C ON agence (reseau_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9445D170C');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9693DB813');
        $this->addSql('CREATE TABLE agence_user (agence_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EE8008A1A76ED395 (user_id), INDEX IDX_EE8008A1D725330D (agence_id), PRIMARY KEY(agence_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE agence_user ADD CONSTRAINT FK_EE8008A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agence_user ADD CONSTRAINT FK_EE8008A1D725330D FOREIGN KEY (agence_id) REFERENCES agence (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE reseau');
        $this->addSql('DROP TABLE travailler');
        $this->addSql('DROP INDEX IDX_64C19AA9693DB813 ON agence');
        $this->addSql('DROP INDEX IDX_64C19AA9445D170C ON agence');
        $this->addSql('ALTER TABLE agence DROP travailler_id, DROP reseau_id, DROP adresse_postale, CHANGE raison_sociale raison_sociale VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom_commercial nom_commercial VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE telephone telephone INT NOT NULL, CHANGE mail mail VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE responsable_agence responsable_agence VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
