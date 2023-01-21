<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230121025811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Implementa a coluna created_at e modified_on na tabela aluno';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aluno ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD modified_on DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aluno DROP created_at, DROP modified_on');
    }
}
