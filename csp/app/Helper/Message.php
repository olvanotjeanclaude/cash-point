<?php

namespace App\Helper;

class Message
{
    public const SUCCESS = "Başarılı bir şekilde kaydedildi.";
    public const ERROR = "bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!";

    public static $message;
    public static $type;

    public function set($data = null, $action = null, $name = null)
    {
        switch ($action) {
            case 'store':
                if ($data) {
                    self::$message = "$name başarılı bir şekilde kaydedildi.";
                    $this::$type = "success";
                } else {
                    $this::$message = "$name kaydı sırasında bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!";
                    $this::$type = "error";
                }
                break;

            case 'update':
                if ($data) {
                    $this::$message = "$name başarılı bir şekilde güncellendi.";
                    $this::$type = "success";
                } else {
                    $this::$message = "$name güncelleme sırasında bir sorun oluştu. Lütfen daha sonra tekrar deneyiniz!";
                    $this::$type = "error";
                }
                break;
            default:
                $this::$message = "Anlamadım";
                $this::$type = "warning";
                break;
        }
    }

    public static function getDeleteMessage($data, $name = "Veri")
    {
        $result = [];

        if ($data && $name) {
            $result["success"] = "$name başarılı bir şekilde silindi.";
            $result["type"] = "success";
        } else {
            $result["type"] = "error";
            $result["error"] = "$name silinirken sırasında bir sorun oluştu. Daha sonra tekrar deneyiniz!";
        }

        return $result;
    }
}
