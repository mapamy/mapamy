<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitialMigration extends AbstractMigration
{
    public function change(): void
    {
        // Create the 'maps' table
        $table = $this->table('maps');
        $table->addColumn('user_id', 'integer')
              ->addColumn('name', 'string', ['limit' => 255])
              ->addColumn('slug', 'string', ['limit' => 120])
              ->addColumn('description', 'text')
              ->create();

        // Create the 'users' table
        $table = $this->table('users');
        $table->addColumn('provider', 'string', ['limit' => 255])
              ->addColumn('provider_id', 'string', ['limit' => 255])
              ->addIndex(['provider_id'], ['unique' => true])
              ->addColumn('email', 'string', ['limit' => 255])
              ->addColumn('token', 'text')
              ->create();

        // Create the 'pins' table
        $table = $this->table('pins');
        $table->addColumn('map_id', 'integer')
              ->addColumn('name', 'string', ['limit' => 255])
              ->addColumn('slug', 'string', ['limit' => 120])
              ->addColumn('description', 'text')
              ->addColumn('location', 'point')
              ->addForeignKey('map_id', 'maps', 'id', ['delete'=> 'CASCADE'])
              ->create();

        // Add foreign key to 'maps' table
        $this->table('maps')
             ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE'])
             ->update();
    }
}