<?php

namespace TBlack\MondayAPI\ObjectTypes;

class Item extends ObjectModel
{
    static $scope = 'items';

    // Arguments
    static $arguments = array(
        'limit'           => [ 'type' => 'Int',     'validate' => 'isInt'     ],
        'page'            => [ 'type' => 'Int',     'validate' => 'isInt'     ],
        'ids'             => [ 'type' => '[Int]',   'validate' => 'isArrayInt'   ],
        'newest_first'    => [ 'type' => 'Boolean',   'validate' => 'isBool'     ]
    );

    // Fields
    static $fields = array(
        'assets'          => [ 'type' => '[Asset]'      , 'object' => 'Asset' ],
        'board'           => [ 'type' => 'Board'      , 'object' => 'Board' ],
        'column_values'   => [ 'type' => '[ColumnValue]'  , 'object' => 'ColumnValue' ],
        'created_at'      => [ 'type' => 'String'      ],
        'creator'         => [ 'type' => 'User'        , 'object' => 'User' ],
        'creator_id'      => [ 'type' => '!String'      ],
        'group'           => [ 'type' => 'Group'      , 'object' => 'Group' ],
        'id'              => [ 'type' => '!ID'        ],
        'name'            => [ 'type' => '!String'      ],
        'state'           => [ 'type' => 'State'      , 'object' => 'State' ],
        'subscribers'     => [ 'type' => '![User]'      , 'object' => 'User' ],
        'updated_at'      => [ 'type' => 'String'      ],
        'updates'         => [ 'type' => '[Update]'      , 'object' => 'Update' ],
    );

    static $create_item_arguments = array(
        'board_id'      => 'Int',
        'group_id'      => 'String',
        'item_name'     => 'String',
        'column_values' => '!JSON',
    );

    static $change_multiple_column_values = array(
        'board_id'        => '!Int',
        'item_id'         => 'Int',
        'column_values'   => '!JSON',
    );

    static $archive_delete_arguments = array(
        'item_id'         => 'Int'
    );
}


?>
