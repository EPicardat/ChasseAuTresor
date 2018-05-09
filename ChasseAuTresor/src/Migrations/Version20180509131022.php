<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180509131022 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE personne_review_partie (id INT AUTO_INCREMENT NOT NULL, personne_id INT NOT NULL, review_id INT NOT NULL, partie_id INT NOT NULL, INDEX IDX_C9988D72A21BD112 (personne_id), INDEX IDX_C9988D723E2E969B (review_id), INDEX IDX_C9988D72E075F7A4 (partie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne_review_partie ADD CONSTRAINT FK_C9988D72A21BD112 FOREIGN KEY (personne_id) REFERENCES personnes (id)');
        $this->addSql('ALTER TABLE personne_review_partie ADD CONSTRAINT FK_C9988D723E2E969B FOREIGN KEY (review_id) REFERENCES review (id)');
        $this->addSql('ALTER TABLE personne_review_partie ADD CONSTRAINT FK_C9988D72E075F7A4 FOREIGN KEY (partie_id) REFERENCES parties (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE personne_review_partie');
    }
}
