<?php 

namespace TBlack\MondayAPI;

class MondayAPI
{	
	private $APIV2_Token;
	private $API_Url 	= "https://api.monday.com/v2/";
	private $debug = false;

	const TYPE_QUERY    = 'query';
    const TYPE_MUTAT    = 'mutation';
	
	function __construct($debug=false)
	{
		$this->debug = $debug;
	}

	public function setToken($token)
	{
		$this->APIV2_Token = $token;
		return $this;
	}

	private function content($type, $request)
	{
		if($this->debug){
			echo $type.' { '.$request.' } '; die();
		}

		return json_encode(['query' => $type.' { '.$request.' } ']);
	}

	protected function request( $type = self::TYPE_QUERY, $request )
	{
		$headers = [ 
			'Content-Type: application/json', 
			'User-Agent: [Tblack-IT] GraphQL Client', 
			'Authorization: ' . $this->APIV2_Token
		];
		
		$data = @file_get_contents($this->API_Url, false, stream_context_create([
		    'http' => [
		        'method' => 'POST',
		        'header' => $headers,
		        'content' => $this->content($type, $request),
		    ]
		]));

		return json_decode($data, true);
	}

	protected function array_map_assoc( $callback , $array )
	{
  		$r = array();
  		foreach ($array as $key=>$value)
    		$r[$key] = $callback($key,$value);
  		return $r;
	}

	/*
	* 	Build Args string
	*
	* 	array 	=> 	ex.: ['ids'=>212121,'name'=>'teste']
	* 
	* 	@return =>	ex.: (ids:212121,name:"teste")
	*/
	protected function buildArguments( Array $array )
	{
		if(empty($array))
			return '';

		return '(' . implode(',',$this->array_map_assoc(function($k,$v){
			if(is_string($v)){
				return $k.':"'.$v.'"';
			}elseif(is_array($v)){
				return $k.':'.json_encode($v).'';
			}
			return "$k:$v";
		},$array)). ')';
	}

	/*
	*	Build ArgsArray for buildArgs. 
	*	This function checks your DATA with the given data structure
	*
	*	struct 	=> ex.: ['ids'=>'Int','name'=>'String']
	*	key 	=> ex.: ["name"=>"value"] or "name"
	*	value 	=> ex.: "value"
	*
	* 	@return => ex.: ["name"=>"value"]
	*/
	protected function buildArgsFields( $struct, $key, $value = false )
	{
		$builded = array();
		if(is_array($key)){
			if(!empty($key)){
				foreach ($key as $_key => $_value) {
					$extra = $this->buildArgsFields( $struct, $_key, $_value);
					if(is_array($extra)&&!empty($extra))
						$builded = array_merge($builded, $extra);
				}
			}
		}else{
			if(isset($struct[$key])){
				$builded[$key] = $value;
			}
		}
		return $builded;
	}

	/*
	*	Create final request string. 
	*
	*	name 		=> ex.: boards
	*	arguments 	=> ex.: (ids:212121,name:"teste")
	*	fields 		=> ex.: ['id', 'type', 'name']
	*
	* 	@return => ex.: boards($arguments){ $fields }
	*/
	protected function create( String $name, String $arguments = '', Array $fields = [] )
	{
		$_fields_ = (is_array($fields)&&!empty($fields))?implode(' ', $fields):'';
		return $name.$arguments.'{ '.$_fields_.' }';
	}

	public function collection( Array $struct, Array $args = [] )
	{	
		$collection = array();
		if(empty($args)){
			foreach ($struct as $key => $value) {
				$collection[]=$key;
			}
		}else{
			foreach ($args as $value) {
				if(isset($struct[$value])){
					$collection[]=$value;
				}
			}
		}
		return $collection;;
	}
}

?>