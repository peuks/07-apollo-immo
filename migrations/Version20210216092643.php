<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210216092643 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, photo VARCHAR(255) DEFAULT NULL, piece_identite VARCHAR(255) DEFAULT NULL, bulletin_de_salaire VARCHAR(255) DEFAULT NULL, justificatif_de_domicile VARCHAR(255) DEFAULT NULL, avis_imposition_n VARCHAR(255) DEFAULT NULL, avis_imposition_n_moins_1 VARCHAR(255) DEFAULT NULL, certifications_id_insee VARCHAR(255) DEFAULT NULL, kbis VARCHAR(255) DEFAULT NULL, carte_professionelle VARCHAR(255) DEFAULT NULL, bilan VARCHAR(255) DEFAULT NULL, attestation_retraite VARCHAR(255) DEFAULT NULL, attestation_allocation VARCHAR(255) DEFAULT NULL, justificatif_etudiant VARCHAR(255) DEFAULT NULL, avis_titularisation VARCHAR(255) DEFAULT NULL, contrat_travail VARCHAR(255) DEFAULT NULL, attestion_employeur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dossier');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name');
    }
}
