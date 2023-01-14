<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110172540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Implementa relação entre tabela de aluno e endereço';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aluno ADD endereco_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE aluno ADD CONSTRAINT FK_67C971001BB76823 FOREIGN KEY (endereco_id) REFERENCES endereco (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_67C971001BB76823 ON aluno (endereco_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aluno DROP FOREIGN KEY FK_67C971001BB76823');
        $this->addSql('DROP INDEX UNIQ_67C971001BB76823 ON aluno');
        $this->addSql('ALTER TABLE aluno DROP endereco_id');
    }
}
