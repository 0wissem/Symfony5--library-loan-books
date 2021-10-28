<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027202026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE emprunt_livres_livre');
        $this->addSql('ALTER TABLE emprunt_livres DROP INDEX UNIQ_48EB7CBC37D925CB, ADD INDEX IDX_48EB7CBC37D925CB (livre_id)');
        $this->addSql('ALTER TABLE emprunt_livres ADD CONSTRAINT FK_48EB7CBC37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emprunt_livres_livre (emprunt_livres_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_88667841E57CF06 (emprunt_livres_id), INDEX IDX_886678437D925CB (livre_id), PRIMARY KEY(emprunt_livres_id, livre_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE emprunt_livres_livre ADD CONSTRAINT FK_88667841E57CF06 FOREIGN KEY (emprunt_livres_id) REFERENCES emprunt_livres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt_livres_livre ADD CONSTRAINT FK_886678437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emprunt_livres DROP INDEX IDX_48EB7CBC37D925CB, ADD UNIQUE INDEX UNIQ_48EB7CBC37D925CB (livre_id)');
        $this->addSql('ALTER TABLE emprunt_livres DROP FOREIGN KEY FK_48EB7CBC37D925CB');
    }
}
