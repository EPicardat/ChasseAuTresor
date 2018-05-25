<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180525121519 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personne_partie_resolue DROP FOREIGN KEY FK_74DE1E9D6BA58F3E');
        $this->addSql('ALTER TABLE personne_partie_resolue DROP FOREIGN KEY FK_74DE1E9DC3A2C2A5');
        $this->addSql('DROP INDEX IDX_74DE1E9D6BA58F3E ON personne_partie_resolue');
        $this->addSql('DROP INDEX IDX_74DE1E9DC3A2C2A5 ON personne_partie_resolue');
        $this->addSql('ALTER TABLE personne_partie_resolue ADD personne_id INT DEFAULT NULL, ADD partie_id INT DEFAULT NULL, DROP personne_id_id, DROP partie_id_id');
        $this->addSql('ALTER TABLE personne_partie_resolue ADD CONSTRAINT FK_74DE1E9DA21BD112 FOREIGN KEY (personne_id) REFERENCES personnes (id)');
        $this->addSql('ALTER TABLE personne_partie_resolue ADD CONSTRAINT FK_74DE1E9DE075F7A4 FOREIGN KEY (partie_id) REFERENCES parties (id)');
        $this->addSql('CREATE INDEX IDX_74DE1E9DA21BD112 ON personne_partie_resolue (personne_id)');
        $this->addSql('CREATE INDEX IDX_74DE1E9DE075F7A4 ON personne_partie_resolue (partie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personne_partie_resolue DROP FOREIGN KEY FK_74DE1E9DA21BD112');
        $this->addSql('ALTER TABLE personne_partie_resolue DROP FOREIGN KEY FK_74DE1E9DE075F7A4');
        $this->addSql('DROP INDEX IDX_74DE1E9DA21BD112 ON personne_partie_resolue');
        $this->addSql('DROP INDEX IDX_74DE1E9DE075F7A4 ON personne_partie_resolue');
        $this->addSql('ALTER TABLE personne_partie_resolue ADD personne_id_id INT DEFAULT NULL, ADD partie_id_id INT DEFAULT NULL, DROP personne_id, DROP partie_id');
        $this->addSql('ALTER TABLE personne_partie_resolue ADD CONSTRAINT FK_74DE1E9D6BA58F3E FOREIGN KEY (personne_id_id) REFERENCES personnes (id)');
        $this->addSql('ALTER TABLE personne_partie_resolue ADD CONSTRAINT FK_74DE1E9DC3A2C2A5 FOREIGN KEY (partie_id_id) REFERENCES parties (id)');
        $this->addSql('CREATE INDEX IDX_74DE1E9D6BA58F3E ON personne_partie_resolue (personne_id_id)');
        $this->addSql('CREATE INDEX IDX_74DE1E9DC3A2C2A5 ON personne_partie_resolue (partie_id_id)');
    }
}
