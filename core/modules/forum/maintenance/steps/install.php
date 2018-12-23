<?php

/**
 * Podium installation steps.
 */

use yii\db\Schema;

return [
    [
        'table' => 'icons',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'            => Schema::TYPE_BIGPK,
                'icon'          => Schema::TYPE_STRING,
                'icon_type'     => Schema::TYPE_INTEGER,
                'icon_string'   => Schema::TYPE_STRING,
                'icon_path'     => Schema::TYPE_STRING,
                'icon_base_url' => Schema::TYPE_STRING,
            ],
        ],
    ],
    [
        'table' => 'forum_category',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'          => Schema::TYPE_PK,
                'name'        => Schema::TYPE_STRING . ' NOT NULL',
                'slug'        => Schema::TYPE_STRING . ' NOT NULL',
                'keywords'    => Schema::TYPE_STRING,
                'description' => Schema::TYPE_STRING,
                'visible'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
                'locked'      => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
                'sort'        => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'created_at'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at'  => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'forum_category',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'sort',
            'cols' => ['sort', 'id'],
        ],
    ],
    [
        'table' => 'forum_category',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'name',
            'cols' => ['name'],
        ],
    ],
    [
        'table' => 'forum_category',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'display',
            'cols' => ['id', 'slug'],
        ],
    ],
    [
        'table' => 'forum_category',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'display_guest',
            'cols' => ['id', 'slug', 'visible'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'            => Schema::TYPE_PK,
                'category_id'   => Schema::TYPE_INTEGER . ' NOT NULL',
                'root'          => Schema::TYPE_INTEGER . ' DEFAULT NULL',
                'lft'           => Schema::TYPE_INTEGER . ' NOT NULL',
                'rgt'           => Schema::TYPE_INTEGER . ' NOT NULL',
                'lvl'           => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'name'          => Schema::TYPE_STRING . ' NOT NULL',
                'sub'           => Schema::TYPE_STRING,
                'slug'          => Schema::TYPE_STRING . ' NOT NULL',
                'keywords'      => Schema::TYPE_STRING,
                'description'   => Schema::TYPE_STRING,
                'sort'          => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'threads'       => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'posts'         => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'icon'          => Schema::TYPE_STRING,
                'icon_type'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
                'active'        => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
                'visible'       => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
                'selected'      => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
                'disabled'      => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
                'readonly'      => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
                'collapsed'     => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
                'movable_u'     => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
                'movable_d'     => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
                'movable_l'     => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
                'movable_r'     => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
                'removable'     => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
                'removable_all' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
                'child_allowed' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
                'created_at'    => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at'    => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'idx_NK1',
            'cols' => ['root'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'idx_NK2',
            'cols' => ['lft'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'idx_NK3',
            'cols' => ['rgt'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'idx_NK4',
            'cols' => ['lvl'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'idx_NK5',
            'cols' => ['active'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'sort',
            'cols' => ['sort', 'id'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'name',
            'cols' => ['name'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'display',
            'cols' => ['id', 'category_id'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'display_slug',
            'cols' => ['id', 'category_id', 'slug'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'display_guest_slug',
            'cols' => ['id', 'category_id', 'slug', 'active'],
        ],
    ],
    [
        'table' => 'forum',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'category_id',
            'ref'    => 'forum_category',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'thread',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'             => Schema::TYPE_PK,
                'name'           => Schema::TYPE_STRING . ' NOT NULL',
                'slug'           => Schema::TYPE_STRING . ' NOT NULL',
                'category_id'    => Schema::TYPE_INTEGER . ' NOT NULL',
                'forum_id'       => Schema::TYPE_INTEGER . ' NOT NULL',
                'author_id'      => Schema::TYPE_INTEGER . ' NOT NULL',
                'pinned'         => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'locked'         => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'posts'          => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'views'          => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'created_at'     => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at'     => Schema::TYPE_INTEGER . ' NOT NULL',
                'new_post_at'    => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'edited_post_at' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            ],
        ],
    ],
    [
        'table' => 'thread',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'name',
            'cols' => ['name'],
        ],
    ],
    [
        'table' => 'thread',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'created_at',
            'cols' => ['created_at'],
        ],
    ],
    [
        'table' => 'thread',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'display',
            'cols' => ['id', 'category_id', 'forum_id'],
        ],
    ],
    [
        'table' => 'thread',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'display_slug',
            'cols' => ['id', 'category_id', 'forum_id', 'slug'],
        ],
    ],
    [
        'table' => 'thread',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'sort',
            'cols' => ['pinned', 'updated_at', 'id'],
        ],
    ],
    [
        'table' => 'thread',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'sort_author',
            'cols' => ['updated_at', 'id'],
        ],
    ],
    [
        'table' => 'thread',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'category_id',
            'ref'    => 'forum_category',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'thread',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'forum_id',
            'ref'    => 'forum',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'post',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'         => Schema::TYPE_PK,
                'content'    => Schema::TYPE_TEXT . ' NOT NULL',
                'thread_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'forum_id'   => Schema::TYPE_INTEGER . ' NOT NULL',
                'author_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'edited'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'likes'      => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'dislikes'   => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'edited_at'  => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            ],
        ],
    ],
    [
        'table' => 'post',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'updated_at',
            'cols' => ['updated_at'],
        ],
    ],
    [
        'table' => 'post',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'created_at',
            'cols' => ['created_at'],
        ],
    ],
    [
        'table' => 'post',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'edited_at',
            'cols' => ['edited_at'],
        ],
    ],
    [
        'table' => 'post',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'identify',
            'cols' => ['id', 'thread_id', 'forum_id'],
        ],
    ],
    [
        'table' => 'post',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'thread_id',
            'ref'    => 'thread',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'post',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'forum_id',
            'ref'    => 'forum',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'vocabulary',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'   => Schema::TYPE_PK,
                'word' => Schema::TYPE_STRING . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'vocabulary',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'word',
            'cols' => ['word'],
        ],
    ],
    [
        'table' => 'vocabulary_junction',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'      => Schema::TYPE_PK,
                'word_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'vocabulary_junction',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'word_id',
            'ref'    => 'vocabulary',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'vocabulary_junction',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'post_id',
            'ref'    => 'post',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'email',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'         => Schema::TYPE_PK,
                'user_id'    => Schema::TYPE_INTEGER,
                'email'      => Schema::TYPE_STRING . ' NOT NULL',
                'subject'    => Schema::TYPE_TEXT . ' NOT NULL',
                'content'    => Schema::TYPE_TEXT . ' NOT NULL',
                'status'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'attempt'    => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'email',
        'call'  => 'addIndex',
        'data'  => [
            'name' => 'status',
            'cols' => ['status'],
        ],
    ],
    [
        'table' => 'email',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'user_id',
            'ref'    => 'users',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'thread_view',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'               => Schema::TYPE_PK,
                'user_id'          => Schema::TYPE_INTEGER . ' NOT NULL',
                'thread_id'        => Schema::TYPE_INTEGER . ' NOT NULL',
                'new_last_seen'    => Schema::TYPE_INTEGER . ' NOT NULL',
                'edited_last_seen' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'thread_view',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'user_id',
            'ref'    => 'users',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'thread_view',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'thread_id',
            'ref'    => 'thread',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'post_thumb',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'         => Schema::TYPE_PK,
                'user_id'    => Schema::TYPE_INTEGER . ' NOT NULL',
                'post_id'    => Schema::TYPE_INTEGER . ' NOT NULL',
                'thumb'      => Schema::TYPE_SMALLINT . ' NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'post_thumb',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'user_id',
            'ref'    => 'users',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'post_thumb',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'post_id',
            'ref'    => 'post',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'subscription',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'        => Schema::TYPE_PK,
                'user_id'   => Schema::TYPE_INTEGER . ' NOT NULL',
                'thread_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'post_seen' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
            ],
        ],
    ],
    [
        'table' => 'subscription',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'user_id',
            'ref'    => 'users',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'subscription',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'thread_id',
            'ref'    => 'thread',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'moderator',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'       => Schema::TYPE_PK,
                'user_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'forum_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'moderator',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'user_id',
            'ref'    => 'users',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'moderator',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'forum_id',
            'ref'    => 'forum',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'content',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'      => Schema::TYPE_PK,
                'name'    => Schema::TYPE_STRING . ' NOT NULL',
                'topic'   => Schema::TYPE_STRING . ' NOT NULL',
                'content' => Schema::TYPE_TEXT . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'content',
        'call'  => 'addContent',
        'data'  => [],
    ],
    [
        'table' => 'poll',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'         => Schema::TYPE_PK,
                'question'   => Schema::TYPE_STRING . ' NOT NULL',
                'votes'      => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
                'hidden'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
                'end_at'     => Schema::TYPE_INTEGER,
                'thread_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'author_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'poll',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'thread_id',
            'ref'    => 'thread',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'poll',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'author_id',
            'ref'    => 'users',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'poll_answer',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'      => Schema::TYPE_PK,
                'poll_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'answer'  => Schema::TYPE_STRING . ' NOT NULL',
                'votes'   => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            ],
        ],
    ],
    [
        'table' => 'poll_answer',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'poll_id',
            'ref'    => 'poll',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'poll_vote',
        'call'  => 'createTable',
        'data'  => [
            'schema' => [
                'id'         => Schema::TYPE_PK,
                'poll_id'    => Schema::TYPE_INTEGER . ' NOT NULL',
                'answer_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'caster_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
        ],
    ],
    [
        'table' => 'poll_vote',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'poll_id',
            'ref'    => 'poll',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'poll_vote',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'answer_id',
            'ref'    => 'poll_answer',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'poll_vote',
        'call'  => 'addForeign',
        'data'  => [
            'key'    => 'caster_id',
            'ref'    => 'users',
            'col'    => 'id',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ],
    [
        'table' => 'auth_rule',
        'call'  => 'addRules',
        'data'  => [],
    ],
    [
        'table' => 'content',
        'call'  => 'addConfig',
        'data'  => [],
    ],
];