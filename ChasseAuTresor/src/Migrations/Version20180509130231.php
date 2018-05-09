<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180509130231 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE personne_role_partie (id INT AUTO_INCREMENT NOT NULL, personne_id_id INT NOT NULL, role_id INT NOT NULL, partie_id INT NOT NULL, INDEX IDX_A92A33DD6BA58F3E (personne_id_id), INDEX IDX_A92A33DDD60322AC (role_id), INDEX IDX_A92A33DDE075F7A4 (partie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DD6BA58F3E FOREIGN KEY (personne_id_id) REFERENCES personnes (id)');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DDE075F7A4 FOREIGN KEY (partie_id) REFERENCES parties (id)');
        $this->addSql('ALTER TABLE indices ADD type_indice_id INT NOT NULL');
        $this->addSql('ALTER TABLE indices ADD CONSTRAINT FK_371B7B7C06F022 FOREIGN KEY (type_indice_id) REFERENCES type_indice (id)');
        $this->addSql('CREATE INDEX IDX_371B7B7C06F022 ON indices (type_indice_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE personne_role_partie');
        $this->addSql('ALTER TABLE indices DROP FOREIGN KEY FK_371B7B7C06F022');
        $this->addSql('DROP INDEX IDX_371B7B7C06F022 ON indices');
        $this->addSql('ALTER TABLE indices DROP type_indice_id');
    }
}
