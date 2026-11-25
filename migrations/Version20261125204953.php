<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261125204953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des clients, comptes, transactions et prêts';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, iban VARCHAR(34) NOT NULL, type VARCHAR(255) NOT NULL, balance NUMERIC(15, 2) NOT NULL, currency VARCHAR(3) NOT NULL, opened_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, score INT DEFAULT NULL, score_updated_at DATETIME DEFAULT NULL, customer_id INT NOT NULL, UNIQUE INDEX UNIQ_7D3656A4FAD56E62 (iban), INDEX IDX_7D3656A49395C3F3 (customer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE bank_transaction (id INT AUTO_INCREMENT NOT NULL, amount NUMERIC(15, 2) NOT NULL, type VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, counterparty_iban VARCHAR(34) DEFAULT NULL, counterparty_name VARCHAR(255) DEFAULT NULL, counterparty_bank VARCHAR(255) DEFAULT NULL, decided_at DATETIME DEFAULT NULL, rejection_reason VARCHAR(255) DEFAULT NULL, source_account_id INT NOT NULL, destination_account_id INT DEFAULT NULL, decided_by_id INT DEFAULT NULL, INDEX IDX_50BCB3AEE7DF2E9E (source_account_id), INDEX IDX_50BCB3AEC652C408 (destination_account_id), INDEX IDX_50BCB3AEE26B496B (decided_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(30) NOT NULL, address VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_81398E09A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, amount NUMERIC(15, 2) NOT NULL, interest_rate NUMERIC(5, 2) NOT NULL, duration_months INT NOT NULL, requested_at DATETIME NOT NULL, score_at_request INT NOT NULL, status VARCHAR(255) NOT NULL, decided_at DATETIME DEFAULT NULL, account_id INT NOT NULL, decided_by_id INT DEFAULT NULL, INDEX IDX_C5D30D039B6B5FBA (account_id), INDEX IDX_C5D30D03E26B496B (decided_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, decided_at DATETIME DEFAULT NULL, decided_by_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), INDEX IDX_8D93D649E26B496B (decided_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id))');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A49395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE bank_transaction ADD CONSTRAINT FK_50BCB3AEE7DF2E9E FOREIGN KEY (source_account_id) REFERENCES account (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE bank_transaction ADD CONSTRAINT FK_50BCB3AEC652C408 FOREIGN KEY (destination_account_id) REFERENCES account (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE bank_transaction ADD CONSTRAINT FK_50BCB3AEE26B496B FOREIGN KEY (decided_by_id) REFERENCES `user` (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D039B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03E26B496B FOREIGN KEY (decided_by_id) REFERENCES `user` (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649E26B496B FOREIGN KEY (decided_by_id) REFERENCES `user` (id) ON DELETE RESTRICT');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A49395C3F3');
        $this->addSql('ALTER TABLE bank_transaction DROP FOREIGN KEY FK_50BCB3AEE7DF2E9E');
        $this->addSql('ALTER TABLE bank_transaction DROP FOREIGN KEY FK_50BCB3AEC652C408');
        $this->addSql('ALTER TABLE bank_transaction DROP FOREIGN KEY FK_50BCB3AEE26B496B');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09A76ED395');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D039B6B5FBA');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03E26B496B');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649E26B496B');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE bank_transaction');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE loan');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
