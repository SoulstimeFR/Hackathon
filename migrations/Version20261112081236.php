<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261112081236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, lien_prototype VARCHAR(255) DEFAULT NULL, projet_id INT NOT NULL, responsable_id INT DEFAULT NULL, INDEX IDX_2449BA15C18272 (projet_id), INDEX IDX_2449BA1553C59D72 (responsable_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE hackathon (id INT AUTO_INCREMENT NOT NULL, date_heure_debut DATETIME NOT NULL, date_heure_fin DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, ville VARCHAR(100) NOT NULL, theme VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE hackathon_organisateur (hackathon_id INT NOT NULL, organisateur_id INT NOT NULL, INDEX IDX_F4E1E1E9996D90CF (hackathon_id), INDEX IDX_F4E1E1E9D936B2FA (organisateur_id), PRIMARY KEY (hackathon_id, organisateur_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, num INT NOT NULL, date DATETIME NOT NULL, competence VARCHAR(255) NOT NULL, hackathon_id INT NOT NULL, participant_id INT NOT NULL, equipe_id INT DEFAULT NULL, INDEX IDX_5E90F6D6996D90CF (hackathon_id), INDEX IDX_5E90F6D69D1C3019 (participant_id), INDEX IDX_5E90F6D66D861B89 (equipe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE organisateur (id INT AUTO_INCREMENT NOT NULL, statut VARCHAR(50) NOT NULL, nom VARCHAR(100) NOT NULL, siteweb VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, telephone VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL, lien_portfolio VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, retenu TINYINT NOT NULL, hackathon_id INT NOT NULL, INDEX IDX_50159CA9996D90CF (hackathon_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id))');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1553C59D72 FOREIGN KEY (responsable_id) REFERENCES inscription (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE hackathon_organisateur ADD CONSTRAINT FK_F4E1E1E9996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hackathon_organisateur ADD CONSTRAINT FK_F4E1E1E9D936B2FA FOREIGN KEY (organisateur_id) REFERENCES organisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D69D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D66D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9996D90CF FOREIGN KEY (hackathon_id) REFERENCES hackathon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15C18272');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1553C59D72');
        $this->addSql('ALTER TABLE hackathon_organisateur DROP FOREIGN KEY FK_F4E1E1E9996D90CF');
        $this->addSql('ALTER TABLE hackathon_organisateur DROP FOREIGN KEY FK_F4E1E1E9D936B2FA');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6996D90CF');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D69D1C3019');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D66D861B89');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9996D90CF');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE hackathon');
        $this->addSql('DROP TABLE hackathon_organisateur');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE organisateur');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
