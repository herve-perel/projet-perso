<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230716082917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, poster VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, age INT DEFAULT NULL, bio LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actor_film (actor_id INT NOT NULL, film_id INT NOT NULL, INDEX IDX_B20C8CD110DAF24A (actor_id), INDEX IDX_B20C8CD1567F5183 (film_id), PRIMARY KEY(actor_id, film_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE director (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age INT DEFAULT NULL, bio LONGTEXT DEFAULT NULL, poster VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, support_id INT DEFAULT NULL, director_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, category VARCHAR(50) NOT NULL, year INT NOT NULL, synopsis LONGTEXT NOT NULL, poster VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8244BE22315B405 (support_id), INDEX IDX_8244BE22899FB366 (director_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support (id INT AUTO_INCREMENT NOT NULL, format VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actor_film ADD CONSTRAINT FK_B20C8CD110DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actor_film ADD CONSTRAINT FK_B20C8CD1567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22315B405 FOREIGN KEY (support_id) REFERENCES support (id)');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22899FB366 FOREIGN KEY (director_id) REFERENCES director (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actor_film DROP FOREIGN KEY FK_B20C8CD110DAF24A');
        $this->addSql('ALTER TABLE actor_film DROP FOREIGN KEY FK_B20C8CD1567F5183');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22315B405');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22899FB366');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE actor_film');
        $this->addSql('DROP TABLE director');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE support');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
