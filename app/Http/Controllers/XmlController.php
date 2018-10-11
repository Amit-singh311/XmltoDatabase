<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class XmlController extends Controller
{
    public function xmlExtract() 
    {
    	if (file_exists(public_path().'/xml/users.xml')) {
    	    $xml = simplexml_load_file(public_path().'/xml/users.xml');
    	   /* echo "<pre />";
    	    print_r($xml);
    	    die;*/
    	    foreach ($xml->user as $user ) {
    	    	$id               = $user->id;
    	    	$usertype             = $user->roles;
    	    	$username             = $user->name;
    	    	$telephone           = $user->phone;
    	    	$clientid           = $user->{'organization-id'};
    	    	$email            = $user->email;
    	    	$active      = (int)$user->{'is-verified'};
    	    	$image        = $user->{'photo-url'};   	    	 

    	    	
    	    	 DB::insert('insert into users (id, UserType, UserName, Telephone,  EMail, ClientID, Active, Image) values (?, ?, ?, ?, ?, ?, ?, ?)', [$id, $usertype, $username, $telephone, $email, $clientid,  $active, $image ]);
    	    	
    	    }
    	  
    	 
    	} else {
    	    exit('Failed to open test.xml.');
    	}

    }

    public function xmlExtractTickets() 
    {

    	if (file_exists(public_path().'/xml/tickets.xml')) {
    	    $xml = simplexml_load_file(public_path().'/xml/tickets.xml');
    	   /* echo "<pre />";
    	    print_r($xml);
    	    die;*/

    	    foreach ($xml->ticket as $k=>$ticket ) {
                    
    	    	$requester    = $ticket->{'requester-id'};
    	    	$created_by   = $ticket->{'submitter-id'};
    	    	$assigned_to  = $ticket->{'assignee-id'};
    	    	$status       = $ticket->{'status-id'};
    	    	$created_at   = $ticket->{'created-at'};
    	    	$updated_at   = $ticket->{'updated-at'};
    	    	$message      = (string)$ticket->description;
    	    	$client_id    = $ticket->{'organization-id'};
    	    	$subject      = $ticket->{'subject'}; 
    	    	$array = array(
    	    		'requester'   => $requester,
    	    		'created_by'  => $created_by,
    	    		'assigned_to' => $assigned_to,
    	    		'status'      => $status,
    	    		'created_at'  => $created_at,
    	    		'updated_at'  => $updated_at,
    	    		'message'     => $message,
    	    		'client_id'   => $client_id,
    	    		'subject'     => $subject,
    	    	);

    	    	$id = DB::table('tickets')->insertGetId($array);    	    	
	    		$ticket_id  = $id;
	    		$reply      = $message;
	    		$type       = 1;
	    		$created_at = $ticket->{'created-at'};
	    		$replied_by = $requester;
	    		$success = DB::insert('insert into conversations (ticket_id, reply, type, created_at, replied_by) values(?, ?, ?, ?, ?)',[$ticket_id, $reply, $type, $created_at, $replied_by]);

    	    	foreach ($ticket->comments->comment as $comment) {
    	    		    
    	    			$ticket_id  = $id;
    	    			$reply      = $comment->value;
    	    			$type       = 1;
    	    			$created_at = $comment->{'created-at'};
    	    			$replied_by = $comment->{'author-id'};
    	    			$success    = DB::insert('insert into conversations (ticket_id, reply, type, created_at, replied_by) values(?, ?, ?, ?, ?)',[$ticket_id, $reply, $type, $created_at, $replied_by]);		
    	    					
    	    		}   	    		 	    	

    	    }
    	    if ($success) {
    	    		return "done";
    	    	}  

    	} else {
    		exit('failed to open tickets.xml');
    	}    

    }

 /*   public function xmlExtractPosts()
    {
    	if (file_exists(public_path().'/xml/posts.xml')) {
    	    $xml = simplexml_load_file(public_path().'/xml/posts.xml');
    	    echo "<pre />";
    	    print_r($xml);
    	    die;
    	} else {
    		exit('failed to open posts.xml');
    	}  
    }*/

    public function xmlExtractOrganizations()
    {

    	if (file_exists(public_path().'/xml/organizations.xml')) {
    	    $xml = simplexml_load_file(public_path().'/xml/organizations.xml');
    	    /*echo "<pre />";
    	    print_r($xml);*/
    	    foreach ($xml->organization as $organization )  {
    	    	$id   = $organization->id;
    	    	$name = $organization->name;
    	    	/*echo "<pre />".$name;*/    	    	
    	    DB::insert('insert into clients (ID, ClientName) values (?, ?)', [$id,$name]);	
    	    }
    	    
    	} else {
    		exit('failed to open organizations.xml');
    	}  
    }

 /*   public function xmlExtractGroups()
    {
    	if (file_exists(public_path().'/xml/groups.xml')) {
    	    $xml = simplexml_load_file(public_path().'/xml/groups.xml');
    	    echo "<pre />";
    	    print_r($xml);
    	    die;
    	} else {
    		exit('failed to open groups.xml');
    	}  
    }

    public function xmlExtractForums()
    {
    	if (file_exists(public_path().'/xml/forums.xml')) {
    	    $xml = simplexml_load_file(public_path().'/xml/forums.xml');
    	    echo "<pre />";
    	    print_r($xml);
    	    die;
    	} else {
    		exit('failed to open forums.xml');
    	} 
    }

    public function xmlExtractEntries()
    {
    	if (file_exists(public_path().'/xml/entries.xml')) {
    	    $xml = simplexml_load_file(public_path().'/xml/entries.xml');
    	    echo "<pre />";
    	    print_r($xml);
    	    die;
    	} else {
    		exit('failed to open entries.xml');
    	} 
    }

    public function xmlExtractCategories() 
    {
    	if (file_exists(public_path().'/xml/categories.xml')) {
    	    $xml = simplexml_load_file(public_path().'/xml/categories.xml');
    	    echo "<pre />";
    	    print_r($xml);
    	    die;
    	} else {
    		exit('failed to open categories.xml');
    	} 
    }

    public function xmlExtractAccounts()
    {
    	if (file_exists(public_path().'/xml/accounts.xml')) {
    	    $xml = simplexml_load_file(public_path().'/xml/accounts.xml');
    	    echo "<pre />";
    	    print_r($xml);
    	    die;
    	} else {
    		exit('failed to open accounts.xml');
    	} 
    }*/

}
