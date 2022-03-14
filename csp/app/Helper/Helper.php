<?php

use App\Models\Customer;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;



function breadcrumburl()
{
    $url = request()->path();
    $values = str_replace("-", " ", $url);

    $values = explode("/", $values);

    return $values;
}

function getUserImage()
{
    if (Auth::check()) {
        $path = Auth::user()->image;

        if ($path && file_exists($path)) {
            return asset($path);
        }

        return Auth::user()->gender == 1 ? asset('assets/images/users/user-4.jpg') : asset('assets/images/users/user-9.jpg');
    }
}

function get_image($path)
{
    if (str_contains($path, "http://") || str_contains($path, "https://")) {
        return $path;
    }

    return $path && file_exists($path) ? asset($path) : "https://via.placeholder.com/150";
}


function getProfileImage()
{
    if (Auth::check()) {
        $path = Auth::user()->image;
        $gender = Auth::user()->gender;

        if ($path && file_exists($path)) {
            return asset($path);
        }

        switch ($gender) {
            case '1':
                $imagePath = asset("backend/images/users/mal-avatar.jpeg");
                break;
            case '2':
                $imagePath = asset("backend/images/users/femal-avatar.jpg");
                break;
            default:
                $imagePath = "https://via.placeholder.com/150";
                break;
        }

        return $imagePath;
    }
}
function generatePhoneNumber($type = "")
{
    switch ($type) {
        case '1':
            $phone = "032" . (string)random_int(1111111, 9999999);
            break;
        case '2':
            $phone = "034" . (string)random_int(1111111, 9999999);
            break;
        case '3':
            $phone = "033" . (string)random_int(1111111, 9999999);
            break;
        default:
            $phone = "034" . (string)random_int(1111111, 9999999);
            break;
    }
    return  $phone;
}

function generateNewUniqueId($min = 11111111, $max = 99999999)
{
    return  (string) random_int($min, $max);
}

function format_date($date, $separator = "/")
{
    return date("d" . $separator . "m" . $separator . "Y", strtotime($date));
}

function randomDate($start_date, $end_date)
{
    $min = strtotime($start_date);
    $max = strtotime($end_date);
    $val = rand($min, $max);
    return date('Y-m-d H:i:s', $val);
}

function getUserPermission()
{
    $permission = Auth::user()->permission;

    switch ($permission) {
        case 1:
            $permission = "admin";
            break;
        case 2:
            $permission = "manager";
            break;
        case 3:
            $permission = "staff";
            break;

        default:
            $permission = "unknown";
            break;
    }

    return $permission;
}

function deleteImage($image)
{
    if ($image && file_exists($image)) {
        unlink($image);
        return true;
    }

    return false;
}
function get_user_id()
{
    if (Auth::check()) {
        return Auth::user()->id;
    }
    return null;
}

function get_nullable_val($instance, $attribute, $return = "")
{
    return $instance && $instance->$attribute != null ? $instance->$attribute : $return;
}

function get_user_fullname($model = null, $default = null)
{
    if ($model) {
        $fullName = $model->user->full_name;
        if ($model->user->id == Auth::user()->id) {
            $fullName = "Benim";
        }
        return  $fullName ?? "Girilmemiş";
    }

    if (Auth::check()) {
        return $default ?? Auth::user()->name . " " . Auth::user()->surname;
    }

    return null;
}


function getBadgeStatus($model, $status)
{
    $name = "\App\Models\\$model::getStatuses";

    try {
        $statuses = call_user_func($name);
    } catch (\Throwable $th) {
        return false;
    }

    $value = $statuses[$status] ?? "Girilmemiş";

    $class = "";
    switch ($status) {
        case '0':
            $class = "bg-danger";
            break;
        case '1':
            $class = "bg-success";
            break;
        case '2':
            $class = "bg-primary";
            break;
        default:
            $class = "text-white bg-dark";
            break;
            break;
    }

    return '<label class="badge ' . $class . '">' . $value . '</label>';
}

function get_user_name()
{
    if (Auth::check()) {
        return Auth::user()->name;
    }
    return null;
}

function getAge($entryDate)
{
    $result = null;

    if ($entryDate) {

        if (gettype($entryDate) == "object") {
            $entryDate = $entryDate->toDateString();
        }

        $entryDate = explode("-", $entryDate);

        $startDate = Carbon::createMidnightDate(date("Y"), date("m"), date("d")); //Start date
        $entryDate = Carbon::createMidnightDate($entryDate[0], $entryDate[1], $entryDate[2]); //End date

        $difference = [
            "day" => $startDate->diffInDays($entryDate),
            "weeks" => $startDate->diffInWeeks($entryDate),
            "months" => $startDate->diffInMonths($entryDate),
            "years" => $startDate->diffInYears($entryDate)
        ];

        $result = $difference["day"] . " days";

        if ($difference["years"] > 1) {
            $result = $difference["years"] . " years";
        } else if ($difference["months"] >= 1) {
            $result = $difference["months"] . " months";
        } else if ($difference["day"] > 7) {
            $result = $difference["weeks"] . " weeks";
        }
    }

    return $result;
}
