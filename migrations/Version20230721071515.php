<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721071515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD sender_id INT DEFAULT NULL, ADD received_id INT DEFAULT NULL, ADD title VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL, ADD is_read TINYINT(1) NOT NULL, DROP user_id, DROP event_id, DROP created_date, CHANGE content text LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB821E5F5 FOREIGN KEY (received_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FF624B39D ON message (sender_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FB821E5F5 ON message (received_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB821E5F5');
        $this->addSql('DROP INDEX IDX_B6BD307FF624B39D ON message');
        $this->addSql('DROP INDEX IDX_B6BD307FB821E5F5 ON message');
        $this->addSql('ALTER TABLE message ADD user_id INT NOT NULL, ADD event_id INT NOT NULL, ADD created_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP sender_id, DROP received_id, DROP title, DROP created_at, DROP is_read, CHANGE text content LONGTEXT NOT NULL');
    }
}
