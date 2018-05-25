<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180525121924 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE indices CHANGE partie_id partie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parties DROP FOREIGN KEY FK_4363180526A02EEB');
        $this->addSql('DROP INDEX IDX_4363180526A02EEB ON parties');
        $this->addSql('ALTER TABLE parties DROP personne_partie_resolue_id');
        $this->addSql('ALTER TABLE personne_partie_resolue ADD personne_id INT DEFAULT NULL, ADD partie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personne_partie_resolue ADD CONSTRAINT FK_74DE1E9DA21BD112 FOREIGN KEY (personne_id) REFERENCES personnes (id)');
        $this->addSql('ALTER TABLE personne_partie_resolue ADD CONSTRAINT FK_74DE1E9DE075F7A4 FOREIGN KEY (partie_id) REFERENCES parties (id)');
        $this->addSql('CREATE INDEX IDX_74DE1E9DA21BD112 ON personne_partie_resolue (personne_id)');
        $this->addSql('CREATE INDEX IDX_74DE1E9DE075F7A4 ON personne_partie_resolue (partie_id)');
        $this->addSql('ALTER TABLE personnes DROP FOREIGN KEY FK_2BB4FE2B26A02EEB');
        $this->addSql('DROP INDEX IDX_2BB4FE2B26A02EEB ON personnes');
        $this->addSql('ALTER TABLE personnes DROP personne_partie_resolue_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE indices CHANGE partie_id partie_id INT NOT NULL');
        $this->addSql('ALTER TABLE parties ADD personne_partie_resolue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parties ADD CONSTRAINT FK_4363180526A02EEB FOREIGN KEY (personne_partie_resolue_id) REFERENCES personne_partie_resolue (id)');
        $this->addSql('CREATE INDEX IDX_4363180526A02EEB ON parties (personne_partie_resolue_id)');
        $this->addSql('ALTER TABLE personne_partie_resolue DROP FOREIGN KEY FK_74DE1E9DA21BD112');
        $this->addSql('ALTER TABLE personne_partie_resolue DROP FOREIGN KEY FK_74DE1E9DE075F7A4');
        $this->addSql('DROP INDEX IDX_74DE1E9DA21BD112 ON personne_partie_resolue');
        $this->addSql('DROP INDEX IDX_74DE1E9DE075F7A4 ON personne_partie_resolue');
        $this->addSql('ALTER TABLE personne_partie_resolue DROP personne_id, DROP partie_id');
        $this->addSql('ALTER TABLE personnes ADD personne_partie_resolue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnes ADD CONSTRAINT FK_2BB4FE2B26A02EEB FOREIGN KEY (personne_partie_resolue_id) REFERENCES personne_partie_resolue (id)');
        $this->addSql('CREATE INDEX IDX_2BB4FE2B26A02EEB ON personnes (personne_partie_resolue_id)');
    }
}
