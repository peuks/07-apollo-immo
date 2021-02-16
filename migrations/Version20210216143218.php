<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210216143218 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, travailler_id INT DEFAULT NULL, reseau_id INT DEFAULT NULL, raison_sociale VARCHAR(100) NOT NULL, siret VARCHAR(40) NOT NULL, nom_commercial VARCHAR(50) NOT NULL, adresse_postale VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, mail VARCHAR(50) NOT NULL, responsable_agence VARCHAR(50) NOT NULL, INDEX IDX_64C19AA9693DB813 (travailler_id), INDEX IDX_64C19AA9445D170C (reseau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidater (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, property_id INT DEFAULT NULL, candidature_at DATETIME NOT NULL, souhait_at VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', INDEX IDX_1D70C89AA76ED395 (user_id), INDEX IDX_1D70C89A549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, description LONGTEXT NOT NULL, photo VARCHAR(255) DEFAULT NULL, piece_identite VARCHAR(255) DEFAULT NULL, bulletin_de_salaire VARCHAR(255) DEFAULT NULL, justificatif_de_domicile VARCHAR(255) DEFAULT NULL, avis_imposition_n VARCHAR(255) DEFAULT NULL, avis_imposition_n_moins_1 VARCHAR(255) DEFAULT NULL, certifications_id_insee VARCHAR(255) DEFAULT NULL, kbis VARCHAR(255) DEFAULT NULL, carte_professionelle VARCHAR(255) DEFAULT NULL, bilan VARCHAR(255) DEFAULT NULL, attestation_retraite VARCHAR(255) DEFAULT NULL, attestation_allocation VARCHAR(255) DEFAULT NULL, justificatif_etudiant VARCHAR(255) DEFAULT NULL, avis_titularisation VARCHAR(255) DEFAULT NULL, contrat_travail VARCHAR(255) DEFAULT NULL, attestion_employeur VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3D48E037A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heat (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, properties_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C53D045F3691D1CA (properties_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, heat_id INT DEFAULT NULL, user_id INT NOT NULL, title VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, surface INT NOT NULL, rooms INT NOT NULL, bedrooms INT NOT NULL, floor INT NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postale_code INT NOT NULL, sold TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, price INT NOT NULL, filename VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8BF21CDEA4033601 (heat_id), INDEX IDX_8BF21CDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reseau (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travailler (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, started_at DATETIME NOT NULL, INDEX IDX_90B2DF3DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9693DB813 FOREIGN KEY (travailler_id) REFERENCES travailler (id)');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9445D170C FOREIGN KEY (reseau_id) REFERENCES reseau (id)');
        $this->addSql('ALTER TABLE candidater ADD CONSTRAINT FK_1D70C89AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE candidater ADD CONSTRAINT FK_1D70C89A549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F3691D1CA FOREIGN KEY (properties_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEA4033601 FOREIGN KEY (heat_id) REFERENCES heat (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE travailler ADD CONSTRAINT FK_90B2DF3DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEA4033601');
        $this->addSql('ALTER TABLE candidater DROP FOREIGN KEY FK_1D70C89A549213EC');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F3691D1CA');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9445D170C');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9693DB813');
        $this->addSql('ALTER TABLE candidater DROP FOREIGN KEY FK_1D70C89AA76ED395');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037A76ED395');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEA76ED395');
        $this->addSql('ALTER TABLE travailler DROP FOREIGN KEY FK_90B2DF3DA76ED395');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE candidater');
        $this->addSql('DROP TABLE dossier');
        $this->addSql('DROP TABLE heat');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE reseau');
        $this->addSql('DROP TABLE travailler');
        $this->addSql('DROP TABLE user');
    }
}
