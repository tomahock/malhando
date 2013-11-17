<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tomahock
 * Date: 5/20/13
 * Time: 2:43 PM
 * To change this template use File | Settings | File Templates.
 */

// set developer or prod
$mode = 'dev';
//$mode = 'prod';

if( $mode === 'dev' ) {
	define( 'DEVELOPER', true );
} else {
	define( 'DEVELOPER', false );
}


$database =  array(
	'host' => 'localhost',
	'user' => 'CHANGE-HERE',
	'pass' => 'CHANGE-HERE',
	'table' => 'CHANGE-HERE'
);


define( 'DATABASE', serialize( $database ) );

// salt for password hashing
DEFINE( 'SALT', 'w[lWeLXs.PJzvCP.ia9*;%%P.o`wt< 2G+_ dan_Lz{2s2]2eokc]>0lN?mTP-%;' );