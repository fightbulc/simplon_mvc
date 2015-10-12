<?php

use Phinx\Migration\AbstractMigration;
use Simplon\Mvc\App\Constants\SqlStorageConstants;

class UsersAuth extends AbstractMigration
{
    public function change()
    {
        $this->table(SqlStorageConstants::AUTH_USERS)
            ->addColumn('pub_token', 'string', ['limit' => 12])
            ->addColumn('name', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('created_at', 'integer', ['limit' => 10, 'signed' => false])
            ->addColumn('updated_at', 'integer', ['limit' => 10, 'signed' => false])
            ->addIndex(['pub_token', 'id'], ['name' => 'by_pubtoken'])
            ->create();

        $this->table(SqlStorageConstants::AUTH_CONNECTORS, ['id' => false])
            ->addColumn('user_id', 'integer', ['limit' => 10, 'signed' => false])
            ->addColumn('conn_name', 'string', ['limit' => 3])
            ->addColumn('conn_key', 'string', ['limit' => 3])
            ->addColumn('conn_value_json', 'text')
            ->addColumn('created_at', 'integer', ['limit' => 10, 'signed' => false])
            ->addColumn('updated_at', 'integer', ['limit' => 10, 'signed' => false])
            ->addIndex(['conn_name', 'conn_key', 'user_id'], ['name' => 'by_connector'])
            ->addIndex(['user_id', 'conn_name', 'conn_key'], ['name' => 'by_userid'])
            ->create();

        $this->table(SqlStorageConstants::AUTH_TEAMS)
            ->addColumn('pub_token', 'string', ['limit' => 12])
            ->addColumn('group_token', 'string', ['limit' => 12])
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('contstraints_json', 'text')
            ->addColumn('created_at', 'integer', ['limit' => 10, 'signed' => false])
            ->addColumn('updated_at', 'integer', ['limit' => 10, 'signed' => false])
            ->addIndex(['pub_token', 'group_token', 'id'], ['name' => 'by_pubtoken'])
            ->create();

        $this->table(SqlStorageConstants::AUTH_TEAM_USER_RELATIONS, ['id' => false])
            ->addColumn('team_id', 'integer', ['limit' => 10, 'signed' => false])
            ->addColumn('user_id', 'integer', ['limit' => 10, 'signed' => false])
            ->addColumn('role', 'string', ['limit' => 12])
            ->addColumn('is_accessible', 'boolean', ['limit' => 1, 'default' => 0])
            ->addColumn('is_selected', 'boolean', ['limit' => 1, 'default' => 0])
            ->addIndex(['team_id', 'user_id', 'role', 'is_accessible'], ['name' => 'by_team'])
            ->addIndex(['user_id', 'team_id', 'role', 'is_accessible'], ['name' => 'by_user'])
            ->create();
    }
}
