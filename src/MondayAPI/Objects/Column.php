<?php

namespace TBlack\MondayAPI\Objects;

class Column extends MondayAPI
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
