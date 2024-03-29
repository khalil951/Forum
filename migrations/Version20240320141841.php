<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320141841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP post_id');
        $this->addSql('ALTER TABLE post_react DROP react_id');
        $this->addSql('ALTER TABLE room DROP room_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD post_id INT NOT NULL');
        $this->addSql('ALTER TABLE post_react ADD react_id INT NOT NULL');
        $this->addSql('ALTER TABLE room ADD room_id INT NOT NULL');
    }
}
