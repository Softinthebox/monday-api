<?php 

namespace TBlack\MondayAPI;

class MondayAPI
{	
	private $APIV2_Token;
	private $API_Url 	= "https://api.monday.com/v2/";

	const TYPE_QUERY    = 'query';
    const TYPE_MUTAT    = 'mutation';
	
	function __construct()
	{
	}

	public function setToken($token)
	{
		$this->APIV2_Token = $token;
		return $this;
	}

	protected function request( $type = self::TYPE_QUERY, $request )
	{
		$headers = [ 
			'Content-Type: application/json', 
			'User-Agent: [MYTEAM] GraphQL Client', 
			'Authorization: ' . $this->APIV2_Token
		];

		$data = @file_get_contents($this->API_Url, false, stream_context_create([
		    'http' => [
		        'method' => 'POST',
		        'header' => $headers,
		        'content' => json_encode([$type => ' { '.$request.' } ']),
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

	protected function buildArgs($array)
	{
		if(empty($array))
			return '';

		return '(' . implode(',',$this->array_map_assoc(function($k,$v){return "$k:$v ";},$array)). ')';
	}

	protected function build( $struct, $key, $value = false )
	{
		$builded = array();
		if(property_exists($this, $struct)){
			if(is_array($key)){
				if(!empty($key)){
					foreach ($key as $_key => $_value) {
						$extra = $this->build( $struct, $_key, $_value);
						if(is_array($extra)&&!empty($extra))
							$builded = array_merge($builded, $extra);
					}
				}
			}else{
				if(isset($this->{$struct}[$key])){
					$builded[$key] = $value;
				}
			}
		}
		return $builded;
	}
}

?>