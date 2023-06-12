<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612122804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participate_event DROP FOREIGN KEY FK_D6C919875FE98FC0');
        $this->addSql('ALTER TABLE participate_event DROP FOREIGN KEY FK_D6C9198771F7E88B');
        $this->addSql('ALTER TABLE participate_user DROP FOREIGN KEY FK_5203D6C95FE98FC0');
        $this->addSql('ALTER TABLE participate_user DROP FOREIGN KEY FK_5203D6C9A76ED395');
        $this->addSql('DROP TABLE participate_event');
        $this->addSql('DROP TABLE participate_user');
        $this->addSql('ALTER TABLE participate ADD event_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B13871F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B138A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_D02B13871F7E88B ON participate (event_id)');
        $this->addSql('CREATE INDEX IDX_D02B138A76ED395 ON participate (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participate_event (participate_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D6C919875FE98FC0 (participate_id), INDEX IDX_D6C9198771F7E88B (event_id), PRIMARY KEY(participate_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participate_user (participate_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5203D6C95FE98FC0 (participate_id), INDEX IDX_5203D6C9A76ED395 (user_id), PRIMARY KEY(participate_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE participate_event ADD CONSTRAINT FK_D6C919875FE98FC0 FOREIGN KEY (participate_id) REFERENCES participate (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participate_event ADD CONSTRAINT FK_D6C9198771F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participate_user ADD CONSTRAINT FK_5203D6C95FE98FC0 FOREIGN KEY (participate_id) REFERENCES participate (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participate_user ADD CONSTRAINT FK_5203D6C9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participate DROP FOREIGN KEY FK_D02B13871F7E88B');
        $this->addSql('ALTER TABLE participate DROP FOREIGN KEY FK_D02B138A76ED395');
        $this->addSql('DROP INDEX IDX_D02B13871F7E88B ON participate');
        $this->addSql('DROP INDEX IDX_D02B138A76ED395 ON participate');
        $this->addSql('ALTER TABLE participate DROP event_id, DROP user_id');
    }
}
