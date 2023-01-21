<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230121020749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajusta o campo desconto para aceitar valores nulos';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato CHANGE desconto desconto NUMERIC(15, 3) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato CHANGE desconto desconto NUMERIC(15, 3) NOT NULL');
    }
}
