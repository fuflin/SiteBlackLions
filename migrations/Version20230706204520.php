<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706204520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F4CB96DCC');
        $this->addSql('DROP INDEX IDX_B6BD307F4CB96DCC ON message');
        $this->addSql('ALTER TABLE message CHANGE created_at created_at DATETIME NOT NULL, CHANGE receive_id received_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB821E5F5 FOREIGN KEY (received_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FB821E5F5 ON message (received_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB821E5F5');
        $this->addSql('DROP INDEX IDX_B6BD307FB821E5F5 ON message');
        $this->addSql('ALTER TABLE message CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE received_id receive_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F4CB96DCC FOREIGN KEY (receive_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6BD307F4CB96DCC ON message (receive_id)');
    }
}
