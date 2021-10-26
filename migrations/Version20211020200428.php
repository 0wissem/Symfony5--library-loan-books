<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020200428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE emprunt_livres_user');
        $this->addSql('ALTER TABLE emprunt_livres ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt_livres ADD CONSTRAINT FK_48EB7CBCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_48EB7CBCA76ED395 ON emprunt_livres (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emprunt_livres_user (emprunt_livres_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B97FA62F1E57CF06 (emprunt_livres_id), INDEX IDX_B97FA62FA76ED395 (user_id), PRIMARY KEY(emprunt_livres_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE emprunt_livres_user ADD CONSTRAINT FK_B97FA62F1E57CF06 FOREIGN KEY (emprunt_livres_id) REFERENCES emprunt_livres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt_livres_user ADD CONSTRAINT FK_B97FA62FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt_livres DROP FOREIGN KEY FK_48EB7CBCA76ED395');
        $this->addSql('DROP INDEX IDX_48EB7CBCA76ED395 ON emprunt_livres');
        $this->addSql('ALTER TABLE emprunt_livres DROP user_id');
    }
}
