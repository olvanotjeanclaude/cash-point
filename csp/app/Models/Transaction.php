<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\Return_;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeOrange($q)
    {
        return $q->where("operator", 1);
    }

    public function scopeTelma($q)
    {
        return $q->where("operator", 2);
    }

    public function scopeAirtel($q)
    {
        return $q->where("operator", 3);
    }

    public function getOperatorAttribute($value)
    {
        switch ($value) {
            case '1':
                $operator = "ORANGE";
                break;
            case '2':
                $operator = "TELMA";
                break;
            case '3':
                $operator = "AIRTEL";
                break;
            default:
                $operator = "INCONU";
                break;
        }

        return $operator;
    }

    public function getTypeAttribute($value)
    {
        switch ($value) {
            case '1':
                $action = "dépôt";
                break;
            case '2':
                $action = "retrait";
                break;

            default:
                $action = "inconnu";
                break;
        }

        return $action;
    }

    public function getAmountAttribute($value){
        return number_format($value,3,",",".");
    }

    public static function getStatuses()
    {
        return [
            "1" => "payé",
            "2" => "en attente",
            "3" => "annulé"
        ];
    }
}
