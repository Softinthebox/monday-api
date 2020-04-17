<?php

namespace TBlack\MondayAPI\ObjectTypes;

use TBlack\MondayAPI\ObjectTypes\ObjectModel as ObjectModel;

class Column extends ObjectModel
{
	static $struct_columns = array(
		'archived' 		=> '!Boolean',
		'id' 			=> '!ID',
		'pos' 			=> 'String',
		'settings_str'	=> '!String',
		'title' 		=> '!String',
		'type' 			=> '!String',
		'width' 		=> 'Int',
	);
}

?>
