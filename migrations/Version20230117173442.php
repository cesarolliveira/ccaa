<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117173442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajusta campos logradouro e numero para permitir valores nulos';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE endereco CHANGE logradouro logradouro VARCHAR(255) DEFAULT NULL, CHANGE numero numero VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE endereco CHANGE logradouro logradouro VARCHAR(255) NOT NULL, CHANGE numero numero VARCHAR(255) NOT NULL');
    }
}
