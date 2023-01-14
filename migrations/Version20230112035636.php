<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112035636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Implementa a tabela de lançamentos';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lancamento (id INT AUTO_INCREMENT NOT NULL, contrato_id INT DEFAULT NULL, tipo_lancamento VARCHAR(10) NOT NULL, forma_pagamento VARCHAR(255) NOT NULL, descricao VARCHAR(255) NOT NULL, parcela INT NOT NULL, vencimento DATE NOT NULL, valor NUMERIC(10, 2) NOT NULL, observacao LONGTEXT DEFAULT NULL, INDEX IDX_6693B3BD70AE7BF1 (contrato_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lancamento ADD CONSTRAINT FK_6693B3BD70AE7BF1 FOREIGN KEY (contrato_id) REFERENCES contrato (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lancamento DROP FOREIGN KEY FK_6693B3BD70AE7BF1');
        $this->addSql('DROP TABLE lancamento');
    }
}
