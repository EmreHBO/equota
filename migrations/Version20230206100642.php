<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230206100642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `leave` DROP FOREIGN KEY FK_9BB080D02A13690');
        $this->addSql('DROP INDEX IDX_9BB080D02A13690 ON `leave`');
        $this->addSql('ALTER TABLE `leave` CHANGE staff_id_id staff_id INT NOT NULL');
        $this->addSql('ALTER TABLE `leave` ADD CONSTRAINT FK_9BB080D0D4D57CD FOREIGN KEY (staff_id) REFERENCES staff (id)');
        $this->addSql('CREATE INDEX IDX_9BB080D0D4D57CD ON `leave` (staff_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `leave` DROP FOREIGN KEY FK_9BB080D0D4D57CD');
        $this->addSql('DROP INDEX IDX_9BB080D0D4D57CD ON `leave`');
        $this->addSql('ALTER TABLE `leave` CHANGE staff_id staff_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE `leave` ADD CONSTRAINT FK_9BB080D02A13690 FOREIGN KEY (staff_id_id) REFERENCES staff (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9BB080D02A13690 ON `leave` (staff_id_id)');
    }
}
