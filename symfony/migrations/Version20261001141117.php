<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261001141117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horse_image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, horse_id INT NOT NULL, UNIQUE INDEX UNIQ_7ABFCE6E76B275AD (horse_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE horse_image ADD CONSTRAINT FK_7ABFCE6E76B275AD FOREIGN KEY (horse_id) REFERENCES horse (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horse_image DROP FOREIGN KEY FK_7ABFCE6E76B275AD');
        $this->addSql('DROP TABLE horse_image');
    }
}
