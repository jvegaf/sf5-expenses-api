<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20200730224950 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates `user_group` and `user_group_user` tables';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE user_group (
                id CHAR(36) NOT NULL PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                owner_id CHAR(36) NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                INDEX IDX_user_group_user_id (owner_id),
                CONSTRAINT FK_user_group_user_id FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE user_group_user (
                user_id CHAR(36) NOT NULL,
                group_id CHAR(36) NOT NULL,
                INDEX IDX_user_group_user_user_id (user_id),
                INDEX IDX_user_group_user_group_id (group_id),
                CONSTRAINT FK_user_group_user_user_id FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE,
                CONSTRAINT FK_user_group_user_group_id FOREIGN KEY (group_id) REFERENCES user_group (id) ON UPDATE CASCADE ON DELETE CASCADE
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE user_group_user');
        $this->addSql('DROP TABLE user_group');
    }
}