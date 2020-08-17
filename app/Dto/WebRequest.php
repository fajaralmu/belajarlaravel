<?php 
namespace App\Dto;

use App\Models\AppProfile;
use App\Models\Member;
use App\Models\MemberFee;
use App\Models\Menu;
use App\Models\Page;
use App\Models\RegisteredRequest;
use App\Models\ScheduledFoodTaskGroup;
use App\Models\UserRole;
use App\User;

class WebRequest {

    public Filter $filter;

    public ScheduledFoodTaskGroup $scheduledfoodtaskgroup;
    public RegisteredRequest $registeredrequest;
    public Page $page;
    public Menu $menu;
    public Member $member;
    public MemberFee $memberfee;
    public AppProfile $appprofile;
    public UserRole $userrole;
    public User $user;

    /**
     * entityName
     */
    public string $entity = "";

    public function __construct(){
        $this->filter = new Filter();
    }
}
