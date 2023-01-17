<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117175411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove obrigatoriedade dos campos de responsável e documento do aluno';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aluno CHANGE nome_mae nome_mae VARCHAR(255) DEFAULT NULL, CHANGE nome_responsavel nome_responsavel VARCHAR(255) DEFAULT NULL, CHANGE responsavel_cpf responsavel_cpf INT DEFAULT NULL, CHANGE responsavel_rg responsavel_rg VARCHAR(255) DEFAULT NULL, CHANGE documento_cpf documento_cpf VARCHAR(255) DEFAULT NULL, CHANGE documento_rg documento_rg VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aluno CHANGE documento_cpf documento_cpf VARCHAR(255) NOT NULL, CHANGE documento_rg documento_rg VARCHAR(255) NOT NULL, CHANGE nome_mae nome_mae VARCHAR(255) NOT NULL, CHANGE nome_responsavel nome_responsavel VARCHAR(255) NOT NULL, CHANGE responsavel_cpf responsavel_cpf INT NOT NULL, CHANGE responsavel_rg responsavel_rg VARCHAR(255) NOT NULL');
    }
}
