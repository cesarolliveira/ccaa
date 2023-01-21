<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230121030245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Implementa o campo created_at e modified_on na tabela curso';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curso ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD modified_on DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curso DROP created_at, DROP modified_on');
    }
}
