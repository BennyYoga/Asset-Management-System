<?php

namespace App\Helpers;

class Button {

    public static function Action ($buttons) {
        $res = "<div class='btn-group' role='group' aria-label='Action'>";
        foreach($buttons as $k => $v){
            if($k=="Href") $res .= static::Href($v);
            if($k=="Detail") $res .= static::Detail($v);
            if($k=="Edit") $res .= static::Edit($v);
            if($k=="Activate") $res .= static::Activate($v);
            if($k=="Deactivate") $res .= static::Deactivate($v);
            if($k=="Delete") $res .= static::Delete($v);
        }
        $res .= "</div>";
        return $res;
    }

    public static function Href ($data) {
        return "<a href='$data[url]' class='btn btn-default btn-sm text-$data[color]' title='$data[title]'>
            <i class='$data[icon]'></i>
        </a>";
    }

    public static function Detail ($url) {
        return "<a href='$url' class='btn btn-default btn-sm text-primary' title='Detail'>
            <i class='fa-solid fa-eye'></i>
        </a>";
    }

    public static function Edit ($url) {
        return "<a href='$url' class='btn btn-default btn-sm text-warning' title='Edit'>
            <i class='fa-solid fa-pencil'></i>
        </a>";
    }

    public static function Activate ($url) {
        return "<button href='$url' class='btn btn-default btn-sm text-success' title='Activate'>
            <i class='fa-solid fa-check'></i>
        </button>";
    }

    public static function Deactivate ($url) {
        return "<button href='$url' class='btn btn-default btn-sm text-danger' title='Deactivate'>
            <i class='fa-solid fa-xmark'></i>
        </button>";
    }

    public static function Delete ($url) {
        return "<button href='$url' class='btn btn-default btn-sm text-danger' title='Delete'>
            <i class='fa-solid fa-trash'></i>
        </button>";
    }

    public static function Status ($active) {
        $variant = $active==0 ? "secondary" : "success";
        $text = $active==0 ? "Inactive" : "Active";
        return "<div class='btn btn-$variant btn-sm'>$text</div>";
    }
}
