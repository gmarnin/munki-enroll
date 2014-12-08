<?php

namespace CFPropertyList;

// Updated Marnin 4/2014 | Verison 1.20

# Add Logging
error_reporting( E_ALL );
ini_set( 'display_errors', 'on' );

require_once( 'CFPropertyList-master/classes/CFPropertyList/CFPropertyList.php' );


// Get the varibles passed by the enroll script
$computername		= $_GET["computername"];
$serial 			= $_GET["serial"];
$mostfrequentuser	= $_GET["mostfrequentuser"];

// Email notification when new manifest is created
$from = "munki-enroll@domain.com";
$to = "user@domain.com";
$subject = "Munki Enroll Notice for $computername";

// Check if manifest already exists for this machine
if ( file_exists( '../manifests/' . $computername ) )
    {
    	// Manifest already exists
    	$message = "manifest already exists for $computername. Exiting";
        (mail($to, $subject, $message, "From: " . $from));
        echo("Manifest already exists for $computername. Exiting");
        exit();
    } 
 
 else
 
    {
    	// Manifest needs to get created
    	$message = "Client $mostfrequentuser on $computername with serial $serial created a new manifest in munki";
        (mail($to, $subject, $message, "From: " . $from));
    	echo("Client $mostfrequentuser on $computername with serial $serial created a new manifest in munki");
    }

                
        // Create the new manifest plist
		$plist = new CFPropertyList();
		$dict = new CFDictionary();
		$plist->add( $dict );
        
		// Add manifest to production catalog by default
        $dict->add( 'catalogs', $array = new CFArray() );
        $array->add( new CFString( 'production' ) );
       
       	// Add Computer Name and most frequently logged in user. Can be used to verify correct manifest
        $dict->add( 'notes', $array = new CFArray() );
	    $array->add( new CFString( 'Serial Number: ' . $serial . ' | Client NetID: ' . $mostfrequentuser ) );
		
	    // This format also works. Computer Name and NetID on seprate lines 
	    // $dict->add( 'Note: Computer Name for this Mac is ' . $computername, $array = new CFArray() );
	    // $dict->add( 'Note: Client NetID: ' . $mostfrequentuser, $array = new CFArray() );
						      
	    // Add parent manifest to included_manifests to achieve waterfall effect
        $dict->add( 'included_manifests', $array = new CFArray() );
        $array->add( new CFString( 'standard_config' ) );
		
		$dict->add( 'managed_installs', $array = new CFArray() );
		$dict->add( 'managed_updates', $array = new CFArray() );
		$dict->add( 'optional_installs', $array = new CFArray() );
		$dict->add( 'managed_uninstalls', $array = new CFArray() );
		
				
		// Save the newly created plist
		$plist->saveXML( '../manifests/' . $computername );

//	}
  
  
?>