<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
Class AppHelper{

        /**
         *  Return user logged-in  or not
         * @return object
         */

        public static function userState(){
            return auth()->user();
        }


}


