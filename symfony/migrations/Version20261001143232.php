<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261001143232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE health (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, reminder_date DATE DEFAULT NULL, practitioner VARCHAR(150) DEFAULT NULL, commentary LONGTEXT DEFAULT NULL, horse_id INT NOT NULL, health_type_id INT NOT NULL, INDEX IDX_CEDA231376B275AD (horse_id), INDEX IDX_CEDA231358E511D4 (health_type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE health ADD CONSTRAINT FK_CEDA231376B275AD FOREIGN KEY (horse_id) REFERENCES horse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE health ADD CONSTRAINT FK_CEDA231358E511D4 FOREIGN KEY (health_type_id) REFERENCES health_type (id) ON DELETE RESTRICT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE health DROP FOREIGN KEY FK_CEDA231376B275AD');
        $this->addSql('ALTER TABLE health DROP FOREIGN KEY FK_CEDA231358E511D4');
        $this->addSql('DROP TABLE health');
    }
}
