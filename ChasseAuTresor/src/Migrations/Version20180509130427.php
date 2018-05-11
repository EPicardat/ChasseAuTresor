<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180509130427 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personne_role_partie DROP FOREIGN KEY FK_A92A33DD6BA58F3E');
        $this->addSql('DROP INDEX IDX_A92A33DD6BA58F3E ON personne_role_partie');
        $this->addSql('ALTER TABLE personne_role_partie CHANGE personne_id_id personne_id INT NOT NULL');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DDA21BD112 FOREIGN KEY (personne_id) REFERENCES personnes (id)');
        $this->addSql('CREATE INDEX IDX_A92A33DDA21BD112 ON personne_role_partie (personne_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personne_role_partie DROP FOREIGN KEY FK_A92A33DDA21BD112');
        $this->addSql('DROP INDEX IDX_A92A33DDA21BD112 ON personne_role_partie');
        $this->addSql('ALTER TABLE personne_role_partie CHANGE personne_id personne_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DD6BA58F3E FOREIGN KEY (personne_id_id) REFERENCES personnes (id)');
        $this->addSql('CREATE INDEX IDX_A92A33DD6BA58F3E ON personne_role_partie (personne_id_id)');
    }
}
