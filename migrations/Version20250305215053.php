<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305215053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file_dattente (id INT AUTO_INCREMENT NOT NULL, urgence_id INT NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_9C97802578B7FBD (urgence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motif_changement_gravite (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_dattente ADD CONSTRAINT FK_9C97802578B7FBD FOREIGN KEY (urgence_id) REFERENCES urgence (id)');
        $this->addSql('ALTER TABLE personnel_soignant DROP nom, DROP prenom, DROP specialite, DROP telephone, DROP username, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3BD5E888C');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3BD5E888C ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP personnel_soignant_id, CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file_dattente DROP FOREIGN KEY FK_9C97802578B7FBD');
        $this->addSql('DROP TABLE file_dattente');
        $this->addSql('DROP TABLE motif_changement_gravite');
        $this->addSql('ALTER TABLE personnel_soignant ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD specialite VARCHAR(255) NOT NULL, ADD telephone VARCHAR(20) NOT NULL, ADD username VARCHAR(180) NOT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD personnel_soignant_id INT DEFAULT NULL, CHANGE password password VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3BD5E888C FOREIGN KEY (personnel_soignant_id) REFERENCES personnel_soignant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3BD5E888C ON utilisateur (personnel_soignant_id)');
    }
}
