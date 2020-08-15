<?php

namespace App\Dto;

use App\Models\AppProfile;
use App\Models\Page; 
use App\User as AppUser;

class PageModel {
    public string $page_code, $request_id, $title, $message;
    public object $content; 
    public AppProfile $profile; 
	public array $additional_style_paths;
	public array $additional_script_paths;
	public array  $additional_pages;
    public Page $page; 
    public EntityProperty $entity_property;

    //header 
	public array $pages;
    public AppUser $user;
	public bool $authenticated = false;
    public string $greeting;
    
    //footer
    public int $year;
    
	 
}