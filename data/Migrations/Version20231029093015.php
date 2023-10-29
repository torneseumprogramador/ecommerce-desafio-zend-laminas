<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231029093015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration for the Cliente entity';
    }

    public function up(Schema $schema): void
    {
        // Create 'clientes' table
        $table = $schema->createTable('clientes');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('nome', 'string', ['length' => 150]);
        $table->addColumn('telefone', 'string', ['length' => 30]);
        $table->addColumn('email', 'string', ['length' => 200]);
        $table->addColumn('endereco', 'text');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        // Drop 'clientes' table
        $schema->dropTable('clientes');
    }
}
