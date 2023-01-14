<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230112225000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Implementação da relação entre Aluno e Lançamento';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lancamento ADD aluno_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lancamento ADD CONSTRAINT FK_6693B3BDB2DDF7F4 FOREIGN KEY (aluno_id) REFERENCES aluno (id)');
        $this->addSql('CREATE INDEX IDX_6693B3BDB2DDF7F4 ON lancamento (aluno_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lancamento DROP FOREIGN KEY FK_6693B3BDB2DDF7F4');
        $this->addSql('DROP INDEX IDX_6693B3BDB2DDF7F4 ON lancamento');
        $this->addSql('ALTER TABLE lancamento DROP aluno_id');
    }
}
