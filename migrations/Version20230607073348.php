<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607073348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_multimedia DROP FOREIGN KEY FK_39DFF14C20531EB8');
        $this->addSql('ALTER TABLE event_multimedia DROP FOREIGN KEY FK_39DFF14C71F7E88B');
        $this->addSql('DROP TABLE event_multimedia');
        $this->addSql('ALTER TABLE multimedia ADD event_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE multimedia ADD CONSTRAINT FK_6131286371F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_6131286371F7E88B ON multimedia (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_multimedia (event_id INT NOT NULL, multimedia_id INT NOT NULL, INDEX IDX_39DFF14C71F7E88B (event_id), INDEX IDX_39DFF14C20531EB8 (multimedia_id), PRIMARY KEY(event_id, multimedia_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE event_multimedia ADD CONSTRAINT FK_39DFF14C20531EB8 FOREIGN KEY (multimedia_id) REFERENCES multimedia (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_multimedia ADD CONSTRAINT FK_39DFF14C71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE multimedia DROP FOREIGN KEY FK_6131286371F7E88B');
        $this->addSql('DROP INDEX IDX_6131286371F7E88B ON multimedia');
        $this->addSql('ALTER TABLE multimedia DROP event_id');
    }
}
