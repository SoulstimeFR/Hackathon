<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261015210417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hackathon_organisateur (hackathon_id INT NOT NULL, organisateur_id INT NOT NULL, INDEX IDX_F4E1E1E9996D90CF (hackathon_id), INDEX IDX_F4E1E1E9D936B2FA (organisateur_id), PRIMARY KEY (hackathon_id, organisateur_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE hackathon_organisateur ADD CONSTRAINT FK_F4E1E1E9996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hackathon_organisateur ADD CONSTRAINT FK_F4E1E1E9D936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackathon_organisateur DROP FOREIGN KEY FK_F4E1E1E9996D90CF');
        $this->addSql('ALTER TABLE hackathon_organisateur DROP FOREIGN KEY FK_F4E1E1E9D936B2FA');
        $this->addSql('DROP TABLE hackathon_organisateur');
    }
}
