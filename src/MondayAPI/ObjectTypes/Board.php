<?php

namespace TBlack\MondayAPI\ObjectTypes;

class Board extends ObjectModel
{
    static $scope = 'boards';

    // Arguments
    static $arguments = array(
        'limit'             => [ 'type' => 'Int',     'validate' => 'isInt'     ],
        'page'              => [ 'type' => 'Int',     'validate' => 'isInt'     ],
        'ids'               => [ 'type' => '[Int]',   'validate' => 'isArrayInt'   ],
        'board_kind'        => [ 'type' => 'BoardKind', 'validate' => 'isBoardKind' ],  // (public / private / share)
        'state'             => [ 'type' => 'State',   'validate' => 'isState'   ],  // (all / active / archived / deleted)
        'newest_first'      => [ 'type' => 'Boolean',   'validate' => 'isBool'     ]
    );

    // Fields
    static $fields = array(
        'activity_logs'     => [ 'type' => '[ActivityLogType]'  , 'object' => 'ActivityLogType' ],
        'board_folder_id'   => [ 'type' => 'Int'         ],
        'board_kind'        => [ 'type' => 'BoardKind'       ],
        'columns'           => [ 'type' => '[Column]'       , 'object' => 'Column' ],
        'communication'     => [ 'type' => 'JSON'        ],
        'description'       => [ 'type' => 'String'       ],
        'groups'            => [ 'type' => '[Group]'       , 'object' => 'Group' ],
        'id'                => [ 'type' => '!ID'         ],
        'items'             => [ 'type' => '[Item]'        , 'object' => 'Item' ],
        'name'              => [ 'type' => '!String'      ],
        'owner'             => [ 'type' => '!User'        , 'object' => 'User' ],
        'permissions'       => [ 'type' => '!String'      ],
        'pos'               => [ 'type' => 'String'        ],
        'state'             => [ 'type' => '!State'        ],
        'subscribers'       => [ 'type' => '![User]'      , 'object' => 'User' ],
        'tags'              => [ 'type' => '[Tag]'        , 'object' => 'Tag' ],
        'top_group'         => [ 'type' => '!Group'        , 'object' => 'Group' ],
        'updates'           => [ 'type' => '[Update]'      , 'object' => 'Update' ],
        'views'             => [ 'type' => '[BoardView]'    , 'object' => 'BoardView' ]
    );

    static $create_item_arguments = array(
        'board_name'      => '!String',
        'board_kind'      => '!BoardKind',
        'folder_id'       => 'Int',
        'workspace_id'    => 'Int',
        'template_id'     => 'Int',
    );

    static $change_multiple_column_values = array(
        'board_id'        => '!Int',
        'item_id'         => 'Int',
        'column_values'   => '!JSON',
    );

    static $archive_arguments = array(
        'board_id'         => '!Int'
    );
}


?>
