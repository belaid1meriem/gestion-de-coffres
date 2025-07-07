<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250707210953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE code ADD code VARCHAR(36) NOT NULL, DROP name');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC67F0B0B7');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC9311871B');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC9D86650F');
        $this->addSql('DROP INDEX IDX_EDBFD5EC67F0B0B7 ON historique');
        $this->addSql('DROP INDEX IDX_EDBFD5EC9D86650F ON historique');
        $this->addSql('DROP INDEX UNIQ_EDBFD5EC9311871B ON historique');
        $this->addSql('ALTER TABLE historique ADD code_id INT NOT NULL, ADD coffre_id INT NOT NULL, ADD user_id INT NOT NULL, DROP code_id_id, DROP coffre_id_id, DROP user_id_id');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC27DAFE17 FOREIGN KEY (code_id) REFERENCES code (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECAA0D26FC FOREIGN KEY (coffre_id) REFERENCES coffre (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EDBFD5EC27DAFE17 ON historique (code_id)');
        $this->addSql('CREATE INDEX IDX_EDBFD5ECAA0D26FC ON historique (coffre_id)');
        $this->addSql('CREATE INDEX IDX_EDBFD5ECA76ED395 ON historique (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE code ADD name VARCHAR(255) NOT NULL, DROP code');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC27DAFE17');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECAA0D26FC');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECA76ED395');
        $this->addSql('DROP INDEX UNIQ_EDBFD5EC27DAFE17 ON historique');
        $this->addSql('DROP INDEX IDX_EDBFD5ECAA0D26FC ON historique');
        $this->addSql('DROP INDEX IDX_EDBFD5ECA76ED395 ON historique');
        $this->addSql('ALTER TABLE historique ADD code_id_id INT NOT NULL, ADD coffre_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, DROP code_id, DROP coffre_id, DROP user_id');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC67F0B0B7 FOREIGN KEY (coffre_id_id) REFERENCES coffre (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC9311871B FOREIGN KEY (code_id_id) REFERENCES code (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EDBFD5EC67F0B0B7 ON historique (coffre_id_id)');
        $this->addSql('CREATE INDEX IDX_EDBFD5EC9D86650F ON historique (user_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EDBFD5EC9311871B ON historique (code_id_id)');
    }
}
