<?php

namespace TBlack\MondayAPI;

use TBlack\MondayAPI\Querying\Query;
use TBlack\MondayAPI\ObjectTypes\Item;
use TBlack\MondayAPI\ObjectTypes\SubItem;
use TBlack\MondayAPI\ObjectTypes\Board;
use TBlack\MondayAPI\ObjectTypes\Column;
use TBlack\MondayAPI\ObjectTypes\BoardKind;

class MondayBoard extends MondayAPI
{
    protected $board_id = false;
    protected $group_id = false;

    public function on( Int $board_id )
    {
        $this->board_id = $board_id;
        return $this;
    }

    public function group( String $group_id )
    {
        $this->group_id = $group_id;
        return $this;
    }

    public function create( String $board_name, String $board_kind = BoardKind::PRV, Array $optionals = [] )
    {
        $Board = new Board();

        $arguments = array_merge( ['board_name' => $board_name], $optionals);

        $create = Query::create(
            'create_board',
            $Board->getArguments($arguments, Board::$create_item_arguments, ' board_kind:'.$board_kind.', '),
            $Board->getFields(['id'])
        );

        return $this->request(self::TYPE_MUTAT, $create);
    }

    public function archiveBoard( Array $fields = [] )
    {
        $Board = new Board();

        $arguments = [
            'board_id'      => $this->board_id,
        ];

        $create = Query::create(
            'archive_board',
            $Board->getArguments($arguments, Board::$archive_arguments),
            $Board->getFields($fields)
        );

        return $this->request(self::TYPE_MUTAT, $create);
    }

    public function getBoards( Array $arguments = [], Array $fields = [])
    {
        $Board = new Board();

        if($this->board_id!==false&&!isset($arguments['ids'])){
            $arguments['ids']=$this->board_id;
        }

        $boards = Query::create(
            Board::$scope,
            $Board->getArguments($arguments),
            $Board->getFields($fields)
        );

        return $this->request( self::TYPE_QUERY, $boards );
    }

    public function getColumns( Array $fields = [] )
    {
        $Column = new Column();
        $Board = new Board();

        $columns = Query::create(
            Column::$scope,
            '',
            $Column->getFields($fields)
        );

        $boards = Query::create(
            Board::$scope,
            $Board->getArguments(['ids'=>$this->board_id]),
            [$columns]
        );

        return $this->request( self::TYPE_QUERY, $boards );
    }

    public function addItem(String $item_name, array $itens = [], $create_labels_if_missing = false)
    {
        if (!$this->board_id || !$this->group_id)
            return -1;

        $arguments = [
            'board_id'    => $this->board_id,
            'group_id'    => $this->group_id,
            'item_name'   => $item_name,
            'column_values' => Column::newColumnValues($itens),
        ];

        $Item = new Item();

        $create = Query::create(
            'create_item',
            $Item->getArguments($arguments, Item::$create_item_arguments),
            $Item->getFields(['id'])
        );

        if ($create_labels_if_missing)
            $create = str_replace('}"){', '}", create_labels_if_missing:true){', $create);

        return $this->request(self::TYPE_MUTAT, $create);
    }

    public function addSubItem( Int $parent_item_id, String $item_name, Array $itens = [] )
    {
        $arguments = [
            'parent_item_id'  => $parent_item_id,
            'item_name'       => $item_name,
            'column_values'   => Column::newColumnValues( $itens ),
        ];

        $SubItem = new SubItem();

        $create = Query::create(
            'create_subitem',
            $SubItem->getArguments($arguments, SubItem::$create_item_arguments),
            $SubItem->getFields(['id'])
        );

        return $this->request(self::TYPE_MUTAT, $create);
    }

    public function archiveItem( Int $item_id ){
        $Item = new Item();

        $archive = Query::create(
            'archive_item',
            $Item->getArguments(['item_id' => $item_id], Item::$archive_delete_arguments),
            $Item->getFields(['id'])
        );

        return $this->request(self::TYPE_MUTAT, $archive);
    }

    public function deleteItem( Int $item_id )
    {
        $Item = new Item();

        $delete = Query::create(
            'delete_item',
            $Item->getArguments(['item_id' => $item_id], Item::$archive_delete_arguments),
            $Item->getFields(['id'])
        );

        return $this->request(self::TYPE_MUTAT, $delete);
    }

    public function changeMultipleColumnValues( Int $item_id, Array $column_values = [] )
    {
        if(!$this->board_id || !$this->group_id)
            return -1;

        $arguments = [
            'board_id'      => $this->board_id,
            'item_id'       => $item_id,
            'column_values' => Column::newColumnValues( $column_values ),
        ];

        $Item = new Item();

        $create = Query::create(
            'change_multiple_column_values',
            $Item->getArguments($arguments, Item::$change_multiple_column_values),
            $Item->getFields(['id'])
        );

        return $this->request(self::TYPE_MUTAT, $create);
    }

    public function customQuery($query)
    {
        return $this->request(self::TYPE_QUERY, $query);
    }

    public function customMutation($query)
    {
        return $this->request(self::TYPE_MUTAT, $query);
    }
}


?>
