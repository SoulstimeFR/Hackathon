<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261016012938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY `FK_2449BA1553C59D72`');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1553C59D72 FOREIGN KEY (responsable_id) REFERENCES inscription (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY `FK_5E90F6D66D861B89`');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D66D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1553C59D72');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT `FK_2449BA1553C59D72` FOREIGN KEY (responsable_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D66D861B89');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT `FK_5E90F6D66D861B89` FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
    }
}
