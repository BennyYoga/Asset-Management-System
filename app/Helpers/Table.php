<?php

namespace App\Helpers;

class Table {

    public static function Center ($id,$data) {
        $res = "";
        foreach($data as $k => $v){
            if($k=="head"){
                $section = "thead";
                $column = "th";
            }else if($k=="body"){
                $section = "tbody";
                $column = "td";
            }else if($k=="foot"){
                $section = "tfoot";
                $column = "td";
            }
            if($v=="all"){
                $res .= "#"."$id > $section > tr > $column,";
            }else if(is_array($v)){
                foreach($v as $value) $res .= "#"."$id > $section > tr > $column:nth-child($value),";
            }
        }
        if($res!=""){
            $res = substr($res,0,-1);
            $res .= "{ text-align: center; }";
        }
        return $res;
    }

    public static function PaddingRight ($id,$data,$value="26px") {
        $res = "";
        $section = "tbody";
        $column = "td";
        if($data=="all"){
            $res .= "#"."$id > $section > tr > $column,";
        }else if(is_array($data)){
            foreach($data as $v) $res .= "#"."$id > $section > tr > $column:nth-child($v),";
        }
        if($res!=""){
            $res = substr($res,0,-1);
            $res .= "{ padding-right: $value; }";
        }
        return $res;
    }

    public static function Gap ($id,$value) {
        return "#"."$id"."_wrapper {
            display: grid;
            gap: $value;
        }";
    }

}
