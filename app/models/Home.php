<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Home extends Model
{
    public static function getUsersData($aData = array(), $isSingle = false){
        $aResult = null;
        $aQueryData = DB::table(config('constants.TBL_USER') . '  AS TU');
        if(isset($aData['id']) && !empty($aData['id']) && $aData['id']){
            $aQueryData->where('id', '=', $aData['id']);
        }
        if(isset($aData['mobile']) && !empty($aData['mobile']) && $aData['mobile']){
            $aQueryData->where('mobile', '=', $aData['mobile']);
        }
        if(isset($aData['email']) && !empty($aData['email']) && $aData['email']){
            $aQueryData->where('email', '=', $aData['email']);
        }
        if(isset($aData['currently_following']) && in_array($aData['currently_following'], array('YES', 'NO'))){
            $aQueryData->where('currently_following', '=', $aData['currently_following']);
        }

        if(isset($aData['password']) && !empty($aData['password']) && $aData['password']){
            $aQueryData->where('password', '=', $aData['password']);
        }
        if(isset($aData['total_count']) && $aData['total_count']){
            $aResult = $aQueryData->count();
        } else {
            $aQueryData->select('TU.id as user_id', 'TU.name as name', 'TU.mobile as mobile', 'TU.email as email', 'TU.current_status_id as current_status_id', 'TU.created_at as created_at', 'TU.updated_at as updated_at');
            if (isset($aData['order_by']) && !empty($aData['order_by']) && $aData['order_by']) {
                $aFieldNameAndOrder = explode('_', $aData['order_by']);
                if (isset($aFieldNameAndOrder[0]) && $aFieldNameAndOrder[0] && isset($aFieldNameAndOrder[1]) && $aFieldNameAndOrder[1])
                    $aQueryData->orderBy($aFieldNameAndOrder[0], $aFieldNameAndOrder[1]);
            } else {
                $aQueryData->orderBy('TU.id', 'desc');
            }
            if (isset($aData['offset']) && isset($aData['limit'])) {
                $aQueryData->offset($aData['offset']);
                $aQueryData->limit($aData['limit']);
            }

            if ($isSingle) {
                $aQueryData->limit(1);
                $aResult = $aQueryData->first();
            } else {
                $aResult = $aQueryData->get();
            }
        }

        return json_decode(json_encode($aResult), true);
    }


    public static function saveUserData($aData = array(), $sAction = "add"){
        $oData = array();
        $iIdOrAffectedRows = 0;
        if(isset($aData['id']) && $aData['id']){
            $sAction = 'edit';
        }
        if(isset($aData['name'])){
            $oData['name'] = $aData['name'];
        }
        if(isset($aData['mobile'])){
            $oData['mobile'] = $aData['mobile'];
        }
        if(isset($aData['email'])){
            $oData['email'] = $aData['email'];
        }
        if(isset($aData['password'])){
            $oData['password'] = $aData['password'];
        }
        if(isset($aData['current_status_id'])){
            $oData['current_status_id'] = $aData['current_status_id'];
        }

        if($sAction === 'add'){
            $iIdOrAffectedRows = DB::table(config('constants.TBL_USER'))->insertGetId($oData);
        }else if($sAction === 'edit'){
            $oData['updated_at'] = date('Y-m-d H:i:s');
            $iIdOrAffectedRows = DB::table(config('constants.TBL_USER'))
                ->where('id', $aData['id'])
                ->update($oData);
        }
        return $iIdOrAffectedRows;
    }

    public static function getFollowUserData($aData = array(), $isSingle = false){
        $aResult = null;
        $aQueryData = DB::table(config('constants.TBL_FOLLOW_USER') . '  AS TFU');
        if(isset($aData['id']) && !empty($aData['id']) && $aData['id']){
            $aQueryData->where('id', '=', $aData['id']);
        }
        if(isset($aData['follower_id']) && !empty($aData['follower_id']) && $aData['follower_id']){
            $aQueryData->where('follower_id', '=', $aData['follower_id']);
        }
        if(isset($aData['following_to_id']) && !empty($aData['following_to_id']) && $aData['following_to_id']){
            $aQueryData->where('following_to_id', '=', $aData['following_to_id']);
        }
        if(isset($aData['total_count']) && $aData['total_count']){
            $aResult = $aQueryData->count();
        } else {
            $aQueryData->select('TFU.id as follow_id', 'TFU.follower_id as follower_id', 'TFU.following_to_id as following_to_id', 'TFU.last_viewed_status_id as last_viewed_status_id', 'TFU.created_at as created_at', 'TFU.updated_at as updated_at');
            if (isset($aData['order_by']) && !empty($aData['order_by']) && $aData['order_by']) {
                $aFieldNameAndOrder = explode('_', $aData['order_by']);
                if (isset($aFieldNameAndOrder[0]) && $aFieldNameAndOrder[0] && isset($aFieldNameAndOrder[1]) && $aFieldNameAndOrder[1])
                    $aQueryData->orderBy($aFieldNameAndOrder[0], $aFieldNameAndOrder[1]);
            } else {
                $aQueryData->orderBy('TFU.id', 'desc');
            }
            if (isset($aData['offset']) && isset($aData['limit'])) {
                $aQueryData->offset($aData['offset']);
                $aQueryData->limit($aData['limit']);
            }

            if ($isSingle) {
                $aQueryData->limit(1);
                $aResult = $aQueryData->first();
            } else {
                $aResult = $aQueryData->get();
            }
        }

        return json_decode(json_encode($aResult), true);
    }


    public static function saveFollowUserData($aData = array(), $sAction = "add"){
        $oData = array();
        $iIdOrAffectedRows = 0;
        if(isset($aData['id']) && $aData['id']){
            $sAction = 'edit';
        }
        if(isset($aData['follower_id'])){
            $oData['follower_id'] = $aData['follower_id'];
        }
        if(isset($aData['following_to_id'])){
            $oData['following_to_id'] = $aData['following_to_id'];
        }
        if(isset($aData['last_viewed_status_id'])){
            $oData['last_viewed_status_id'] = $aData['last_viewed_status_id'];
        }

        if($sAction === 'add'){
            $iIdOrAffectedRows = DB::table(config('constants.TBL_FOLLOW_USER'))->insertGetId($oData);
        }else if($sAction === 'edit'){
            $oData['updated_at'] = date('Y-m-d H:i:s');
            $iIdOrAffectedRows = DB::table(config('constants.TBL_FOLLOW_USER'))
                ->where('id', $aData['id'])
                ->update($oData);
        }
        return $iIdOrAffectedRows;
    }

    public static function getUserStatusData($aData = array(), $isSingle = false){
        $aResult = null;
        $aQueryData = DB::table(config('constants.TBL_USER_STATUS') . '  AS TUS');
        if(isset($aData['id']) && !empty($aData['id']) && $aData['id']){
            $aQueryData->where('id', '=', $aData['id']);
        }
        if(isset($aData['user_id']) && !empty($aData['user_id']) && $aData['user_id']){
            $aQueryData->where('user_id', '=', $aData['user_id']);
        }
        if(isset($aData['total_count']) && $aData['total_count']){
            $aResult = $aQueryData->count();
        } else {
            $aQueryData->select('TUS.id as status_id', 'TUS.user_id as user_id', 'TUS.post_status_content as post_status_content', 'TUS.post_status_image as post_status_image', 'TUS.created_at as created_at', 'TUS.updated_at as updated_at');
            if (isset($aData['order_by']) && !empty($aData['order_by']) && $aData['order_by']) {
                $aFieldNameAndOrder = explode('_', $aData['order_by']);
                if (isset($aFieldNameAndOrder[0]) && $aFieldNameAndOrder[0] && isset($aFieldNameAndOrder[1]) && $aFieldNameAndOrder[1])
                    $aQueryData->orderBy($aFieldNameAndOrder[0], $aFieldNameAndOrder[1]);
            } else {
                $aQueryData->orderBy('TUS.id', 'desc');
            }
            if (isset($aData['offset']) && isset($aData['limit'])) {
                $aQueryData->offset($aData['offset']);
                $aQueryData->limit($aData['limit']);
            }

            if ($isSingle) {
                $aQueryData->limit(1);
                $aResult = $aQueryData->first();
            } else {
                $aResult = $aQueryData->get();
            }
        }

        return json_decode(json_encode($aResult), true);
    }

    public static function saveUserStatusData($aData = array(), $sAction = "add"){
        $oData = array();
        $iIdOrAffectedRows = 0;
        if(isset($aData['id']) && $aData['id']){
            $sAction = 'edit';
        }
        if(isset($aData['user_id'])){
            $oData['user_id'] = $aData['user_id'];
        }
        if(isset($aData['post_status_content'])){
            $oData['post_status_content'] = $aData['post_status_content'];
        }
        if(isset($aData['post_status_image'])){
            $oData['post_status_image'] = $aData['post_status_image'];
        }

        if($sAction === 'add'){
            $iIdOrAffectedRows = DB::table(config('constants.TBL_USER_STATUS'))->insertGetId($oData);
        }else if($sAction === 'edit'){
            $oData['updated_at'] = date('Y-m-d H:i:s');
            $iIdOrAffectedRows = DB::table(config('constants.TBL_USER_STATUS'))
                ->where('id', $aData['id'])
                ->update($oData);
        }
        return $iIdOrAffectedRows;
    }
}
