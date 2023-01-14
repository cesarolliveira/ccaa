<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110033701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Criação da tabela aluno';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aluno (id INT AUTO_INCREMENT NOT NULL, nome_completo VARCHAR(255) NOT NULL, data_nascimento DATE NOT NULL, naturalidade VARCHAR(255) NOT NULL, nome_pai VARCHAR(255) DEFAULT NULL, nome_mae VARCHAR(255) NOT NULL, nome_responsavel VARCHAR(255) NOT NULL, responsavel_cpf INT NOT NULL, responsavel_rg VARCHAR(255) NOT NULL, situacao VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE aluno');
    }
}
