<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110204307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Implementação da tabela de contrato';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrato (id INT AUTO_INCREMENT NOT NULL, aluno_id INT NOT NULL, curso_id INT NOT NULL, parcelas INT NOT NULL, forma_pagamento VARCHAR(255) NOT NULL, desconto NUMERIC(10, 2) NOT NULL, valor NUMERIC(10, 2) NOT NULL, INDEX IDX_66696523B2DDF7F4 (aluno_id), INDEX IDX_6669652387CB4A1F (curso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrato ADD CONSTRAINT FK_66696523B2DDF7F4 FOREIGN KEY (aluno_id) REFERENCES aluno (id)');
        $this->addSql('ALTER TABLE contrato ADD CONSTRAINT FK_6669652387CB4A1F FOREIGN KEY (curso_id) REFERENCES curso (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrato DROP FOREIGN KEY FK_66696523B2DDF7F4');
        $this->addSql('ALTER TABLE contrato DROP FOREIGN KEY FK_6669652387CB4A1F');
        $this->addSql('DROP TABLE contrato');
    }
}
