<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180525095025 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personne_role_partie DROP FOREIGN KEY FK_A92A33DDD60322AC');
        $this->addSql('DROP TABLE personne_role_partie');
        $this->addSql('DROP TABLE role');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE personne_role_partie (id INT AUTO_INCREMENT NOT NULL, personne_id INT NOT NULL, role_id INT NOT NULL, partie_id INT NOT NULL, INDEX IDX_A92A33DDD60322AC (role_id), INDEX IDX_A92A33DDE075F7A4 (partie_id), INDEX IDX_A92A33DDA21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(10) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DDA21BD112 FOREIGN KEY (personne_id) REFERENCES personnes (id)');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE personne_role_partie ADD CONSTRAINT FK_A92A33DDE075F7A4 FOREIGN KEY (partie_id) REFERENCES parties (id)');
    }
}
