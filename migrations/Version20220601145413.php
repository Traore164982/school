<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601145413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module ADD rp_id INT NOT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628B70FF80C FOREIGN KEY (rp_id) REFERENCES rp (id)');
        $this->addSql('CREATE INDEX IDX_C242628B70FF80C ON module (rp_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628B70FF80C');
        $this->addSql('DROP INDEX IDX_C242628B70FF80C ON module');
        $this->addSql('ALTER TABLE module DROP rp_id');
    }
}
