<?php

namespace App\Helper;

trait FormatDate
{
    public function getDateAttribute()
    {
        return  date("d-m-Y", strtotime($this->date_time));
    }

    public function getTimeAttribute()
    {
        return date("H:i", strtotime($this->date_time));
    }

    public function getDateTimeInputAttribute()
    {
        return  date("Y-m-d", strtotime($this->date_time)) . "T" . date("h:i:s", strtotime($this->date_time));
    }

    public function getDateTimeAttribute($value)
    {
        return  date("d-m-Y H:i", strtotime($value));
    }
}
