<?php

namespace TBlack\MondayAPI\Querying;

class Query
{
    public static function validate( $field, $field_typedata )
    {
        if( $field_typedata['type'] === 'Int' || $field_typedata['type'] === '!Int' || $field_typedata['type'] === '[Int]'){
            return true;
        }else if( $field_typedata['type'] === 'String' || $field_typedata['type'] === '!String'){
            return true;
        }else if( $field_typedata['type'] === 'Boolean' ){
            return true;
        }else if( isset($field_typedata['object']) ){
            $class_name = 'TBlack\MondayAPI\ObjectTypes\\' . $field_typedata['object'];
            if( class_exists($class_name) ){
                $Object = new $class_name();
                return $Object->getBuildFieldsArgs();
            }else{
                return true;
            }
        }else if( $field_typedata['type'][0] === '[' && $field_typedata['type'][strlen($field_typedata['type']) - 1] === ']' ){
        }else{
            return true;
        }
        return true;
    }

    public static function array_map_assoc( $callback , $array )
    {
        $r = array();
        foreach ($array as $key=>$value)
          $r[$key] = $callback($key,$value);
        return $r;
    }

    /*
    *   Build Args string
    *
    *   array   =>   ex.: ['ids'=>212121,'name'=>'teste']
    *
    *   @return =>  ex.: (ids:212121,name:"teste")
    */
    public static function buildArguments( Array $array , String $prepend = '')
    {
        if(empty($array))
            return '';
        return '(' . $prepend . implode(',',self::array_map_assoc(function($k,$v){
            if(is_string($v)){
                return $k.':"'.$v.'"';
            }elseif(is_array($v)){
                return $k.':'.json_encode($v).'';
            }
            return "$k:$v";
        },$array)). ')';
    }

    /*
    *  Build ArgsArray for buildArguments.
    *  This function checks your DATA with the given data structure
    *
    *  struct   => ex.: ['ids'=>'Int','name'=>'String']
    *  key   => ex.: ["name"=>"value"] or "name"
    *  value   => ex.: "value"
    *
    *   @return => ex.: ["name"=>"value"]
    */
    public static function buildArgsFields( $struct, $key, $value = false )
    {
        $builded = array();
        if(is_array($key)){
            if(!empty($key)){
                foreach ($key as $_key => $_value) {
                    $extra = self::buildArgsFields( $struct, $_key, $_value);
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

    public static function buildFieldsArgs( Array $fields, Array $fields_arguments = [] )
    {
        $builded = array();
        if( is_array($fields) && !empty($fields) ){
            foreach ($fields as $field => $field_typedata ) {
                if( !empty($fields_arguments) ){
                    // To Do........
                    if(isset($fields_arguments[$field])){
                        $builded[$field] = true;
                    }
                    if( in_array($field, $fields_arguments)){
                        $builded[$field] = true;
                    }
                }else{
                    $validated = self::validate( $field, $field_typedata  );
                    if( $validated !== false ){
                        $builded[$field] = $validated;
                    }
                }
            }
        }
        return $builded;
    }

    public static function buildFields( Array $array )
    {
        if(empty($array))
            return '';
        return '' . implode(' ',self::array_map_assoc(function($k,$v){
            if( is_bool($v) && $v ){
                return $k;
            }
            return "$k $v";
        },$array)). '';
    }

    /*
    *  Create final request string.
    *
    *  scope     => ex.: boards
    *  arguments   => ex.: (ids:212121,scope:"teste")
    *  fields     => ex.: id type column { id } ]
    *
    *   @return => ex.: boards($arguments){ $fields }
    */
    public static function create( String $scope, String $arguments = '', Array $fields = [] )
    {
        if(is_array($fields)&& !empty($fields)){
            $fields = '{ '.implode(' ', $fields).' }';
        }
        return $scope.$arguments.$fields;
    }
}
?>
