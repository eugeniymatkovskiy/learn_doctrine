<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170921053002 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nations_in_countries (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, nation_id INT NOT NULL, population INT NOT NULL, INDEX IDX_B1EFA09EF92F3E70 (country_id), INDEX IDX_B1EFA09EAE3899 (nation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nations_in_countries ADD CONSTRAINT FK_B1EFA09EF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE nations_in_countries ADD CONSTRAINT FK_B1EFA09EAE3899 FOREIGN KEY (nation_id) REFERENCES nation (id)');
        $this->addSql('DROP TABLE nation_country');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nation_country (nation_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_BF19403AAE3899 (nation_id), INDEX IDX_BF19403AF92F3E70 (country_id), PRIMARY KEY(nation_id, country_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nation_country ADD CONSTRAINT FK_BF19403AAE3899 FOREIGN KEY (nation_id) REFERENCES nation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nation_country ADD CONSTRAINT FK_BF19403AF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE nations_in_countries');
    }
}
