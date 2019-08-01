<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190801101331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, id_partenaire_id INT NOT NULL, numero_compte VARCHAR(255) NOT NULL, code_bank DOUBLE PRECISION NOT NULL, nom_beneficiaire VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, INDEX IDX_CFF6526026F6C2C9 (id_partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, ninea DOUBLE PRECISION NOT NULL, localisation VARCHAR(255) NOT NULL, domaine_dactivite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, id_compte_id INT NOT NULL, id_caissier_id INT NOT NULL, date_de_depot DATETIME NOT NULL, montant_du_depot DOUBLE PRECISION NOT NULL, INDEX IDX_47948BBC72F0DA07 (id_compte_id), INDEX IDX_47948BBCAD065ACC (id_caissier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, id_partenaire_id INT DEFAULT NULL, id_compte_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, profil VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, photo VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), INDEX IDX_1D1C63B326F6C2C9 (id_partenaire_id), INDEX IDX_1D1C63B372F0DA07 (id_compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526026F6C2C9 FOREIGN KEY (id_partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC72F0DA07 FOREIGN KEY (id_compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCAD065ACC FOREIGN KEY (id_caissier_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B326F6C2C9 FOREIGN KEY (id_partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B372F0DA07 FOREIGN KEY (id_compte_id) REFERENCES compte (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC72F0DA07');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B372F0DA07');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526026F6C2C9');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B326F6C2C9');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCAD065ACC');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE depot');
        $this->addSql('DROP TABLE utilisateur');
    }
}
