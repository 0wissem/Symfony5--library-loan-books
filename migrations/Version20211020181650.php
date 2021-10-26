<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020181650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emprunt_livres (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(50) NOT NULL, rapport VARCHAR(255) DEFAULT NULL, date_de_reservation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt_livres_livre (emprunt_livres_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_88667841E57CF06 (emprunt_livres_id), INDEX IDX_886678437D925CB (livre_id), PRIMARY KEY(emprunt_livres_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt_livres_user (emprunt_livres_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B97FA62F1E57CF06 (emprunt_livres_id), INDEX IDX_B97FA62FA76ED395 (user_id), PRIMARY KEY(emprunt_livres_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emprunt_livres_livre ADD CONSTRAINT FK_88667841E57CF06 FOREIGN KEY (emprunt_livres_id) REFERENCES emprunt_livres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt_livres_livre ADD CONSTRAINT FK_886678437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt_livres_user ADD CONSTRAINT FK_B97FA62F1E57CF06 FOREIGN KEY (emprunt_livres_id) REFERENCES emprunt_livres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt_livres_user ADD CONSTRAINT FK_B97FA62FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt_livres_livre DROP FOREIGN KEY FK_88667841E57CF06');
        $this->addSql('ALTER TABLE emprunt_livres_user DROP FOREIGN KEY FK_B97FA62F1E57CF06');
        $this->addSql('DROP TABLE emprunt_livres');
        $this->addSql('DROP TABLE emprunt_livres_livre');
        $this->addSql('DROP TABLE emprunt_livres_user');
    }
}
