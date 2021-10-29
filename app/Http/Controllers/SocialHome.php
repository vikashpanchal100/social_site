<?php

namespace App\Http\Controllers;

use App\models\Home as homeModel;
use Illuminate\Http\Request;

class SocialHome extends Controller
{

    public function ajax(Request $request){
        $ajaxResponse = array('status' => false, 'message' => 'Something went wrong.');
        $aRequest = $request->all();
        if(isset($aRequest['control']) && $aRequest['control']){
            switch ($aRequest['control']){
                case 'GET_USER_LIST':
                    $ajaxResponse = $this->mainPageData($request);
                    break;
                case 'FOLLOW_USER':
                    $ajaxResponse = $this->followUser($request);
                    break;
                case 'LOG_OUT':
                    $ajaxResponse = $this->logOut($request);
                    break;
                case 'VIEW_STATUS_OF_PARTICULAR_USER':
                    $ajaxResponse = $this->viewStatusOfParticularUser($request);
                    break;
            }
        }
        echo json_encode($ajaxResponse);die;
    }

    public function login(){
        if(session('user_data') && is_array(session('user_data')) && count(session('user_data'))){
            return redirect('dashboard');
        }
        return view('welcome');
    }

    public function register(){
        if(session('user_data') && is_array(session('user_data')) && count(session('user_data'))){
            return redirect('dashboard');
        }
        return view('register');
    }

    public function logOut($aData){
        $ajaxResponse = array('status' => false, 'message' => 'Something went wrong.');
        if($aData->session()->has('user_data') && is_array(session('user_data')) && count(session('user_data'))){
            unsetSession('user_data');
            if(!$aData->session()->has('user_data')){
                $ajaxResponse['status'] = true;
                $ajaxResponse['message'] = 'Logged out successfully.';
            }
        }
        return $ajaxResponse;
    }

    public function authenticateLogin(Request $request){
        $ajaxResponse = array('status' => false, 'email_error' => true, 'message' => 'Either email or password is wrong.');
        $aRequestInput = $request->input();
        $this->validate($request, [
            'email' => ['bail', 'required', 'email', 'regex:/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+){0,1})\.([A-Za-z]{2,})$/'],
            'password' => ['bail', 'required'],
        ], [
            'email.required' => 'Please enter email.',
            'email.regex' => 'The email must be a valid email address.',
            'password.required' => 'Please enter passwrod.',
        ]);

        $aUserCondition['email'] = $aRequestInput['email'];
        $aUserCondition['password'] = $aRequestInput['password'];
        $aUserData = homeModel::getUsersData($aUserCondition, true);
        if($aUserData && is_array($aUserData) && count($aUserData)){
            session(['user_data' => $aUserData]);
            $ajaxResponse['message'] = 'Something went wrong. Session could not be saved';
            if(session('user_data') && is_array(session('user_data')) && count(session('user_data'))){
                $ajaxResponse['status'] = true;
                unset($ajaxResponse['error_email']);
                $ajaxResponse['message'] = 'Logged in successfully.';
            }
        }
        return $ajaxResponse;
    }


    public function registerNewUser(Request $request){
        $ajaxResponse = array('status' => false, 'name_error' => true, 'message' => 'Something went wrong.');
        $aRequestInput = $request->input();
        $this->validate($request, [
            'name' => ['bail', 'required'],
            'email' => ['bail', 'required', 'email', 'regex:/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+){0,1})\.([A-Za-z]{2,})$/'],
            'mobile' => ['bail', 'required', 'regex:/^[0-9]{10}+$/'],
            'password' => ['bail', 'required'],
        ], [
            'name.required' => 'Please enter name.',
            'email.required' => 'Please enter email.',
            'email.regex' => 'The email must be a valid email address.',
            'mobile.required' => 'Please enter mobile.',
            'mobile.regex' => 'The mobile must be a valid mobile number.',
            'password.required' => 'Please enter password.',
        ]);
        $aUserCondition['email'] = $aRequestInput['email'];
        $aUserEmailData = homeModel::getUsersData($aUserCondition, true);
        $aUserCondition['mobile'] = $aRequestInput['mobile'];
        $aUserMobileData = homeModel::getUsersData($aUserCondition, true);
        if(($aUserEmailData && is_array($aUserEmailData) && count($aUserEmailData)) || ($aUserMobileData && is_array($aUserMobileData) && count($aUserMobileData))){
            $ajaxResponse['message'] = 'User already registered.';
        } else{
            $aUserProvidedData['name'] = $aRequestInput['name'];
            $aUserProvidedData['email'] = $aRequestInput['email'];
            $aUserProvidedData['mobile'] = $aRequestInput['mobile'];
            $aUserProvidedData['password'] = $aRequestInput['password'];
            $bUserSavedId = homeModel::saveUserData($aUserProvidedData);
            if($bUserSavedId){
                $aUserData = homeModel::getUsersData(array('id' => $bUserSavedId), true);
                if($aUserData){
                    session(['user_data' => $aUserData]);
                    if(session('user_data') && is_array(session('user_data')) && count(session('user_data'))){
                        $ajaxResponse['status'] = true;
                        unset($ajaxResponse['name_error']);
                        $ajaxResponse['message'] = 'Registration successfully.';
                    }
                }
            }

        }
        return $ajaxResponse;
    }

    public function mainPageData($aRequestData){
        $ajaxResponse = array('status' => false, 'message' => 'Something went wrong.');
        $aUserSessionData = getSession('user_data');
        if(!$aUserSessionData){
            $ajaxResponse['message'] = 'Please refresh and login first.';
        } else{
            $aMainPagesCondition['total_count'] = true;
            $aTotalUserCount = homeModel::getUsersData($aMainPagesCondition, true);
            unset($aMainPagesCondition['total_count']);
            $aMainPagesCondition['offset'] = $aRequestData['iDisplayStart'];
            $aMainPagesCondition['limit'] = $aRequestData['iDisplayLength'];
            $aMainPagesData = homeModel::getUsersData($aMainPagesCondition);
            $aFinalUserData = array();
            if($aMainPagesData && is_array($aMainPagesData) && count($aMainPagesData)){
                foreach($aMainPagesData as $userData){
                    if($userData['user_id'] !== $aUserSessionData['user_id']){
                        $aToFollowingData = homeModel::getFollowUserData(array('follower_id' => $aUserSessionData['user_id'], 'following_to_id' => $userData['user_id'], 'currently_following' => 'YES'), true);
                        $userData['isToFollowUser'] = false;
                        if($aToFollowingData && is_array($aToFollowingData) && count($aToFollowingData)){
                            $userData['isToFollowUser'] = true;
                        }

                        $aSubArray = array();
                        $aSubArray[] = $userData['user_id'];
                        $aSubArray[] = $userData['name'];
                        $aSubArray[] = $userData['email'];
                        $aSubArray[] = $userData['mobile'];
                        $aSubArray[] = $userData['created_at'];
                        $aSubArray[] = $userData['updated_at'];
                        $sStatusText = 'Please follow users to see their status';
                        if($userData['isToFollowUser']){
                            $sStatusText = 'No Status Available';
                            if($aToFollowingData['last_viewed_status_id'] !== $userData['current_status_id'] ){
                                $sStatusText = "See New Status";
                            } else if($aToFollowingData['last_viewed_status_id'] && $aToFollowingData['last_viewed_status_id'] === $userData['current_status_id'] ){
                                $sStatusText = "Status already seen! Click to view again";
                            }
                        }
                        $aSubArray[] = $this->getUserActionDropdownHtml($userData).'<a href="javascript:void(0)" onclick="viewStatusOfParticularUser({user_id: '.$userData["user_id"].'})">'.$sStatusText.'</a>';
                        $aFinalUserData[] = $aSubArray;
                    }
                }
                $ajaxResponse['status'] = true;
                $ajaxResponse['message'] = 'User Data found successfully.';
            }
            $ajaxResponse["sEcho"] = intval($aRequestData['sEcho']);
            $ajaxResponse["iTotalRecords"] = $aTotalUserCount ? $aTotalUserCount-1 : 0;
            $ajaxResponse["iTotalDisplayRecords"] = $aTotalUserCount ? $aTotalUserCount-1 : 0;
            $ajaxResponse["aaData"] = $aFinalUserData;
        }
        return $ajaxResponse;
    }

    public function dashBoardPage(){
        return view('dashboard');
    }

    public function getUserActionDropdownHtml($aData = array()){
        if(isset($aData['user_id']) && $aData['user_id']){
            return view('common.user_action_dropdown', ['aUserData' => $aData])->render();
        }
    }


    public function followUser($request){
        $ajaxResponse = array('status' => false, 'message' => 'Something went wrong.');
        $aUserData = getSession('user_data');
        if(!$aUserData){
            $ajaxResponse['message'] = 'Please refresh and login first.';
        } else{
            $aRequestInput = $request->input();
            $this->validate($request, [
                'user_id' => ['bail', 'required'],
            ], [
                'user_id.required' => 'Please enter email.',
            ]);
            $toFollowUserData = homeModel::getUsersData(array('id' =>  $aRequestInput['user_id']), true);
            if($toFollowUserData && is_array($toFollowUserData) && count($toFollowUserData)){
                $ajaxResponse['message'] = "You can't follow yourself.";
                if($aUserData['user_id'] !== $toFollowUserData['user_id']){
                    $aUserCondition['follower_id'] = $aUserData['user_id'];
                    $aUserCondition['following_to_id'] = $aRequestInput['user_id'];
                    $aFollowUserData = homeModel::getFollowUserData($aUserCondition, true);
                    if($aFollowUserData && is_array($aFollowUserData) && count($aFollowUserData)){
                        $ajaxResponse['message'] = 'You are already following this user.';
                    } else{
                        $aFollowUserData['follower_id'] = $aUserData['user_id'];
                        $aFollowUserData['following_to_id'] = $aRequestInput['user_id'];
                        $bFollowSavedId = homeModel::saveFollowUserData($aFollowUserData);
                        if($bFollowSavedId){
                            $ajaxResponse['status'] = true;
                            $ajaxResponse['message'] = 'Your request processed successfully. Now you are following '.$toFollowUserData['name'];
                        }
                    }
                }
            }
        }
        return $ajaxResponse;
    }


    public function submitStatus(Request $request){
        $ajaxResponse = array('status' => false, 'message' => 'Something went wrong.');
        $aUserData = getSession('user_data');
        if(!$aUserData){
            $ajaxResponse['message'] = 'Please refresh and login first.';
        } else {

            $this->validate($request, [
                'post_status_content' => ['bail', 'required'],
                'post_status_image' => ['bail', 'required', 'image'],
            ], [
                'post_status_content.required' => 'Please enter status content.',
                'post_status_image.required' => 'Please upload a picture.',
                'post_status_image.image' => 'Please upload an image file.',
            ]);
            $sStatusImage = $request->file('post_status_image');
            $sStatusImage->getMimeType();
            $destinationPath = 'images/status_images';
            $ajaxResponse['message']= 'Something went wrong while submitting status. Image could not be uploaded.';
            if($sStatusImage->move($destinationPath,$aUserData['user_id'].$sStatusImage->getClientOriginalName())){
                $bStatusSavedId = homeModel::saveUserStatusData(array('user_id' =>$aUserData['user_id'], 'post_status_content' => $request->post_status_content,'post_status_image' => $aUserData['user_id'].$sStatusImage->getClientOriginalName()));
                $ajaxResponse['message']= 'Something went wrong while submitting status.';
                if($bStatusSavedId){
                    $bUserDataUpdated = homeModel::saveUserData(array('id' => $aUserData['user_id'], 'current_status_id' => $bStatusSavedId),'edit');
                    $ajaxResponse['message']= 'Data could not be updated properly.';
                    if($bUserDataUpdated){
                        $ajaxResponse['status'] = true;
                        $ajaxResponse['message'] = 'Status has been uploaded successfully.';
                    }
                }
            }
        }
        setSession('user_status_updated', $ajaxResponse);
        return redirect('dashboard');
    }


    function viewStatusOfParticularUser($request){
        $ajaxResponse = array('status' => false, 'message' => 'Something went wrong.');
        if(!isset($request['user_id']) || !$request['user_id']){
            $ajaxResponse['message']= 'Something went wrong.';
        } else{
            $aUserStatusData = homeModel::getUserStatusData(array('user_id'=> $request['user_id']), true);
            $ajaxResponse['message'] = 'No status uploaded by this user till yet.';
            if($aUserStatusData && is_array($aUserStatusData) && count($aUserStatusData)){
                $aFollowUserData = homeModel::getFollowUserData(array('following_to_id' => $request['user_id']), true);
                if($aFollowUserData && is_array($aFollowUserData) && count($aFollowUserData)){
                    $bSaveFollowStatus = homeModel::saveFollowUserData(array('id' => $aFollowUserData['follow_id'], 'last_viewed_status_id' => $aUserStatusData['status_id']), 'edit');
                    if($bSaveFollowStatus){
                        $ajaxResponse['status']= true;
                        $ajaxResponse['message'] = 'User status data found successfully.';
                        $ajaxResponse['htmlData'] = view('modal_contents.user_status_modal_content', ['aUserData' => $aUserStatusData])->render();
                    }
                }else{
                    $ajaxResponse['message'] = 'Please follow users to see their status.';
                }
            }
        }
        return $ajaxResponse;
    }
}
