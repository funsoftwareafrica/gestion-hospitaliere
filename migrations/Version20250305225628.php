<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305225628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP roles');
        $this->addSql('DROP INDEX UNIQ_AB6149B7E7927C74 ON personnel_soignant');
        $this->addSql('ALTER TABLE personnel_soignant ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD specialite VARCHAR(255) NOT NULL, ADD telephone VARCHAR(20) NOT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnel_soignant DROP nom, DROP prenom, DROP specialite, DROP telephone, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB6149B7E7927C74 ON personnel_soignant (email)');
        $this->addSql('ALTER TABLE patient ADD roles JSON NOT NULL');
    }
}
