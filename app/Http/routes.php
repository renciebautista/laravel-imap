<?php
use Webklex\IMAP\Facades\Client;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    //return view('welcome');

    $oClient = Webklex\IMAP\Facades\Client::account('default');
	$oClient->connect();

	//Get all Mailboxes
	$aMailboxes = $oClient->getFolders();

	//Loop through every Mailbox
	/** @var \Webklex\IMAP\Folder $oMailbox */
	foreach($aMailboxes as $oMailbox){

	    //Get all Messages of the current Mailbox
	    /** @var \Webklex\IMAP\Message $oMessage */
	    foreach($oMailbox->getMessages() as $oMessage){
	    	
	        echo $oMessage->subject.'<br />';
	        echo 'Attachments: '.$oMessage->getAttachments()->count().'<br />';
	        echo $oMessage->getHTMLBody(true);
	        
	        //Move the current Message to 'INBOX.read'
	        // if($oMessage->moveToFolder('INBOX.read') == true){
	        //     echo 'Message has ben moved';
	        // }else{
	        //     echo 'Message could not be moved';
	        // }
	    }
	}
});
