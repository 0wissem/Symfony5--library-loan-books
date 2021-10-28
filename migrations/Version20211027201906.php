<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027201906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_48EB7CBC37D925CB ON emprunt_livres');
        $this->addSql('ALTER TABLE emprunt_livres DROP livre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt_livres ADD livre_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_48EB7CBC37D925CB ON emprunt_livres (livre_id)');
    }
}
