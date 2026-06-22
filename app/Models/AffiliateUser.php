<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AffiliateUser  extends Authenticatable
{
    use HasFactory;

    use HasApiTokens, HasFactory, Notifiable;



    public function get_affiliate_unique_id()
    {
        $id = $this->id;
        $postfix = ''; // Initialize $postfix here

        if ($id >= 1 && $id <= 99999) {
            $prefix = 'F';
        } elseif ($id >= 100000 && $id <= 1099999) {
            $prefix = 'F';
            if ($id <= 199999) {
                $postfix = 'A';
                $id -= 100000;
            } elseif ($id <= 299999) {
                $postfix = 'B';
                $id -= 200000;
            } elseif ($id <= 399999) {
                $postfix = 'C';
                $id -= 300000;
            } elseif ($id <= 499999) {
                $postfix = 'D';
                $id -= 400000;
            } elseif ($id <= 599999) {
                $postfix = 'E';
                $id -= 500000;
            } elseif ($id <= 699999) {
                $postfix = 'F';
                $id -= 600000;
            } elseif ($id <= 799999) {
                $postfix = 'G';
                $id -= 700000;
            } elseif ($id <= 899999) {
                $postfix = 'H';
                $id -= 800000;
            } elseif ($id <= 999999) {
                $postfix = 'I';
                $id -= 900000;
            } elseif ($id <= 1099999) {
                $postfix = 'J';
                $id -= 1000000;
            }
        }

        $num = sprintf("%05d", $id);

        $this->unique_id = $prefix . $num . $postfix;
        $this->save();
        return true;
    }
}
