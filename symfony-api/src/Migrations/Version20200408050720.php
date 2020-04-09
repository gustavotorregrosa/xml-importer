<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200408050720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, shiporder_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, note VARCHAR(1000) NOT NULL, quantity INT NOT NULL, price NUMERIC(10, 2) NOT NULL, INDEX IDX_1F1B251EF7FABC28 (shiporder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ship_order (id INT NOT NULL, orderperson_id INT NOT NULL, INDEX IDX_F450C04DEE431C96 (orderperson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destination (id INT AUTO_INCREMENT NOT NULL, shiporder_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3EC63EAAF7FABC28 (shiporder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, phonenumber VARCHAR(255) NOT NULL, INDEX IDX_444F97DD217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EF7FABC28 FOREIGN KEY (shiporder_id) REFERENCES ship_order (id)');
        $this->addSql('ALTER TABLE ship_order ADD CONSTRAINT FK_F450C04DEE431C96 FOREIGN KEY (orderperson_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE destination ADD CONSTRAINT FK_3EC63EAAF7FABC28 FOREIGN KEY (shiporder_id) REFERENCES ship_order (id)');
        $this->addSql('ALTER TABLE phone ADD CONSTRAINT FK_444F97DD217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EF7FABC28');
        $this->addSql('ALTER TABLE destination DROP FOREIGN KEY FK_3EC63EAAF7FABC28');
        $this->addSql('ALTER TABLE ship_order DROP FOREIGN KEY FK_F450C04DEE431C96');
        $this->addSql('ALTER TABLE phone DROP FOREIGN KEY FK_444F97DD217BBB47');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE ship_order');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE phone');
    }
}
