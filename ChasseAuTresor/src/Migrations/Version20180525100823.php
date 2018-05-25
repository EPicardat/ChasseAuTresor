<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180525100823 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personne_role_partie DROP FOREIGN KEY FK_A92A33DDD60322AC');
        $this->addSql('CREATE TABLE personne_partie_resolue (id INT AUTO_INCREMENT NOT NULL, resolue TINYINT(1) NOT NULL, role VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE personne_role_partie');
        $this->addSql('DROP TABLE resolue');
        $this->addSql('DROP TABLE role');
        $this->addSql('ALTER TABLE parties ADD personne_partie_resolue_id INT DEFAULT NULL, ADD accuracy NUMERIC(5, 2) NOT NULL');
        $this->addSql('ALTER TABLE parties ADD CONSTRAINT FK_4363180526A02EEB FOREIGN KEY (personne_partie_resolue_id) REFERENCES personne_partie_resolue (id)');
        $this->addSql('CREATE INDEX IDX_4363180526A02EEB ON parties (personne_partie_resolue_id)');
        $this->addSql('ALTER TABLE personnes ADD personne_partie_resolue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnes ADD CONSTRAINT FK_2BB4FE2B26A02EEB FOREIGN KEY (personne_partie_resolue_id) REFERENCES personne_partie_resolue (id)');
        $this->addSql('CREATE INDEX IDX_2BB4FE2B26A02EEB ON personnes (personne_partie_resolue_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parties DROP FOREIGN KEY FK_4363180526A02EEB');
        $this->addSql('ALTER TABLE personnes DROP FOREIGN KEY FK_2BB4FE2B26A02EEB');
        $this->addSql('CREATE TABLE personne_role_partie (id INT AUTO_INCREMENT NOT NULL, personne_id INT NOT NULL, role_id INT NOT NULL, partie_id INT NOT NULL, INDEX IDX_A92A33DDD60322AC (role_id), INDEX IDX_A92A33DDE075F7A4 (partie_id), INDEX IDX_A92A33DDA21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resolue (id INT AUTO_INCREMENT NOT NULL, resolue TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(10) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DDA21BD112 FOREIGN KEY (personne_id) REFERENCES personnes (id)');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DDE075F7A4 FOREIGN KEY (partie_id) REFERENCES parties (id)');
        $this->addSql('DROP TABLE personne_partie_resolue');
        $this->addSql('DROP INDEX IDX_4363180526A02EEB ON parties');
        $this->addSql('ALTER TABLE parties DROP personne_partie_resolue_id, DROP accuracy');
        $this->addSql('DROP INDEX IDX_2BB4FE2B26A02EEB ON personnes');
        $this->addSql('ALTER TABLE personnes DROP personne_partie_resolue_id');
    }
}
