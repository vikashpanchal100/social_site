<?php
use App\models\Home;

if(! function_exists('getSession')){
    function getSession($sKey = ''){
        if($sKey){
            if(session($sKey) && is_array(session($sKey)) && count(session($sKey)))
            return session($sKey);
        }
        return false;
    }
}

if(! function_exists('setSession')){
    function setSession($sKey = '',$sValue = ''){
        if($sKey && $sValue){
            session([$sKey => $sValue]);
            return true;
        }
        return false;
    }
}

if(! function_exists('unsetSession')){
    function unsetSession($sKey = ''){
        if($sKey){
            session()->forget($sKey);
            Session()->save();
            return true;
        }
        return false;
    }
}
