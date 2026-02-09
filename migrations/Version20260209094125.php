<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260209094125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP password_user, CHANGE email_user email_user VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_8d93d64912a5f6cc TO UNIQ_IDENTIFIER_EMAIL_USER');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD password_user VARCHAR(100) NOT NULL, DROP roles, DROP password, CHANGE email_user email_user VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_identifier_email_user TO UNIQ_8D93D64912A5F6CC');
    }
}
