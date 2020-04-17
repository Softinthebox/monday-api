<?php

namespace TBlack\MondayAPI\Querying;

use TBlack\MondayAPI\Objects\Column as Column;
use TBlack\MondayAPI\Objects\Item as Item;

class Collection
{
	public function get( Array $struct, Array $args = [] )
	{	
		$collection = array();
		if(empty($args)){
			foreach ($struct as $_key_ => $value) {
				$field = $this->validate($value['type'], $_key_);
				if($field!==false)
					$collection[] = $field;
			}
		}else{
			foreach ($args as $_key_) {
				if(isset($struct[$_key_])){
					$field = $this->validate($struct[$_key_]['type'], $_key_);
					if($field!==false)
						$collection[] = $field;
				}
			}
		}
		return $collection;;
	}

	private function validate($type, $_key_)
	{
		if($type[0]==='['){

			$class_name = 'TBlack\MondayAPI\Objects\\'.substr($type, 1, -1);
			
			if( class_exists($class_name) ){

				var_dump($class_name); die();

			}else{
				return false;
			}

		}
		return $_key_;
	}
}


?>
