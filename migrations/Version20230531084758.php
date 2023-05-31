<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531084758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_multimedia (event_id INT NOT NULL, multimedia_id INT NOT NULL, INDEX IDX_39DFF14C71F7E88B (event_id), INDEX IDX_39DFF14C20531EB8 (multimedia_id), PRIMARY KEY(event_id, multimedia_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participate (id INT AUTO_INCREMENT NOT NULL, date_regis DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participate_event (participate_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D6C919875FE98FC0 (participate_id), INDEX IDX_D6C9198771F7E88B (event_id), PRIMARY KEY(participate_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participate_user (participate_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5203D6C95FE98FC0 (participate_id), INDEX IDX_5203D6C9A76ED395 (user_id), PRIMARY KEY(participate_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_multimedia ADD CONSTRAINT FK_39DFF14C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_multimedia ADD CONSTRAINT FK_39DFF14C20531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participate_event ADD CONSTRAINT FK_D6C919875FE98FC0 FOREIGN KEY (participate_id) REFERENCES participate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participate_event ADD CONSTRAINT FK_D6C9198771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participate_user ADD CONSTRAINT FK_5203D6C95FE98FC0 FOREIGN KEY (participate_id) REFERENCES participate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participate_user ADD CONSTRAINT FK_5203D6C9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A76ED395 ON event (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_multimedia DROP FOREIGN KEY FK_39DFF14C71F7E88B');
        $this->addSql('ALTER TABLE event_multimedia DROP FOREIGN KEY FK_39DFF14C20531EB8');
        $this->addSql('ALTER TABLE participate_event DROP FOREIGN KEY FK_D6C919875FE98FC0');
        $this->addSql('ALTER TABLE participate_event DROP FOREIGN KEY FK_D6C9198771F7E88B');
        $this->addSql('ALTER TABLE participate_user DROP FOREIGN KEY FK_5203D6C95FE98FC0');
        $this->addSql('ALTER TABLE participate_user DROP FOREIGN KEY FK_5203D6C9A76ED395');
        $this->addSql('DROP TABLE event_multimedia');
        $this->addSql('DROP TABLE participate');
        $this->addSql('DROP TABLE participate_event');
        $this->addSql('DROP TABLE participate_user');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A76ED395');
        $this->addSql('DROP INDEX IDX_3BAE0AA7A76ED395 ON event');
        $this->addSql('ALTER TABLE event DROP user_id');
    }
}
