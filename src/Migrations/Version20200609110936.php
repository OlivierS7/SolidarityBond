<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200609110936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A23EDC87 FOREIGN KEY (subject_id) REFERENCES subjects (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE contains_orders ADD CONSTRAINT FK_62614D3FA5418CB FOREIGN KEY (contains_id) REFERENCES contains (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contains_orders ADD CONSTRAINT FK_62614D3CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contains_products ADD CONSTRAINT FK_84AB31FA5418CB FOREIGN KEY (contains_id) REFERENCES contains (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contains_products ADD CONSTRAINT FK_84AB316C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE products ADD description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE subjects ADD CONSTRAINT FK_AB259917C54C8C93 FOREIGN KEY (type_id) REFERENCES types (id)');
        $this->addSql('ALTER TABLE subjects ADD CONSTRAINT FK_AB259917A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E96BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A23EDC87');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE contains_orders DROP FOREIGN KEY FK_62614D3FA5418CB');
        $this->addSql('ALTER TABLE contains_orders DROP FOREIGN KEY FK_62614D3CFFE9AD6');
        $this->addSql('ALTER TABLE contains_products DROP FOREIGN KEY FK_84AB31FA5418CB');
        $this->addSql('ALTER TABLE contains_products DROP FOREIGN KEY FK_84AB316C8A81A9');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEA76ED395');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A3DA5256D');
        $this->addSql('ALTER TABLE products DROP description');
        $this->addSql('ALTER TABLE subjects DROP FOREIGN KEY FK_AB259917C54C8C93');
        $this->addSql('ALTER TABLE subjects DROP FOREIGN KEY FK_AB259917A76ED395');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E96BF700BD');
    }
}
