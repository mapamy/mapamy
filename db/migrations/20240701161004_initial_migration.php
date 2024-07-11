<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitialMigration extends AbstractMigration
{
    public function change(): void
    {
        // Create the 'users' table
        $table = $this->table('users');
        $table->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('token', 'text')
            ->create();

        // Create the 'maps' table
        $table = $this->table('maps');
        $table->addColumn('user_id', 'integer')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('slug', 'string', ['limit' => 120])
            ->addColumn('description', 'text')
            ->addColumn('wysiwyg', 'text')
            ->addColumn('privacy', 'integer')
            ->create();

        // Create the 'pins' table
        $table = $this->table('pins');
        $table->addColumn('map_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('slug', 'string', ['limit' => 120])
            ->addColumn('description', 'text')
            ->addColumn('wysiwyg', 'text')
            ->addColumn('location', 'point')
            ->addForeignKey('map_id', 'maps', 'id', ['delete' => 'CASCADE'])
            ->create();

        // Add foreign key to 'maps' table
        $this->table('maps')
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])
            ->update();

        // Add foreign key to 'pins' table
        $this->table('pins')
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE'])
            ->update();

        // Add unique constraint to 'users' table
        $this->table('users')
            ->addIndex(['email'], ['unique' => true])
            ->update();

        // Add unique constraint to 'maps' table
        $this->table('maps')
            ->addIndex(['slug'], ['unique' => true])
            ->update();

        // Add unique constraint to 'pins' table
        $this->table('pins')
            ->addIndex(['slug'], ['unique' => true])
            ->update();

        // Add spatial index to 'pins' table
        $this->execute('CREATE INDEX location_idx ON pins USING GIST (location)');
    }
}