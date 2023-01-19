<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230119025131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Implementa a moeda no contrato e altera o tipo de dados do desconto e valor para suportar moedas com mais casas decimais.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato ADD moeda VARCHAR(10) NOT NULL, CHANGE desconto desconto NUMERIC(15, 3) NOT NULL, CHANGE valor valor NUMERIC(15, 3) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato DROP moeda, CHANGE desconto desconto NUMERIC(10, 2) NOT NULL, CHANGE valor valor NUMERIC(10, 2) NOT NULL');
    }
}
