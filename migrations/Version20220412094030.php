<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412094030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent_specialty (agent_id INT NOT NULL, specialty_id INT NOT NULL, INDEX IDX_173220A83414710B (agent_id), INDEX IDX_173220A89A353316 (specialty_id), PRIMARY KEY(agent_id, specialty_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_specialty ADD CONSTRAINT FK_173220A83414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agent_specialty ADD CONSTRAINT FK_173220A89A353316 FOREIGN KEY (specialty_id) REFERENCES specialty (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE specialty_agent');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE specialty_agent (specialty_id INT NOT NULL, agent_id INT NOT NULL, INDEX IDX_85FDB9B13414710B (agent_id), INDEX IDX_85FDB9B19A353316 (specialty_id), PRIMARY KEY(specialty_id, agent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE specialty_agent ADD CONSTRAINT FK_85FDB9B13414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE specialty_agent ADD CONSTRAINT FK_85FDB9B19A353316 FOREIGN KEY (specialty_id) REFERENCES specialty (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE agent_specialty');
    }
}
