<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180509131505 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE indices ADD partie_id INT NOT NULL');
        $this->addSql('ALTER TABLE indices ADD CONSTRAINT FK_371B7BE075F7A4 FOREIGN KEY (partie_id) REFERENCES parties (id)');
        $this->addSql('CREATE INDEX IDX_371B7BE075F7A4 ON indices (partie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE indices DROP FOREIGN KEY FK_371B7BE075F7A4');
        $this->addSql('DROP INDEX IDX_371B7BE075F7A4 ON indices');
        $this->addSql('ALTER TABLE indices DROP partie_id');
    }
}
