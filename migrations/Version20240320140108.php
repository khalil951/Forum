<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320140108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, post_id INT NOT NULL, author VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, img_url VARCHAR(255) DEFAULT NULL, num_likes INT DEFAULT NULL, num_dislikes INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_5A8A6C8D54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_react (id INT AUTO_INCREMENT NOT NULL, react_id INT NOT NULL, post_id INT NOT NULL, user_id INT NOT NULL, isliked TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, catgory VARCHAR(255) NOT NULL, sub_category VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D54177093');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_react');
        $this->addSql('DROP TABLE room');
    }
}
