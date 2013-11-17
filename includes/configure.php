<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tomahock
 * Date: 5/20/13
 * Time: 2:43 PM
 * To change this template use File | Settings | File Templates.
 */

// set developer or prod
//$mode = 'dev';
$mode = 'prod';

if( $mode === 'dev' ) {
	define( 'DEVELOPER', true );
} else {
	define( 'DEVELOPER', false );
}

// database configs
//$database =  array(
//	'host' => 'labmm.clients.ua.pt',
//	'user' => '2012_lm4_g12',
//	'pass' => 'mxvk',
//	'table' => '2012_lm4_g12_b01'
//);


$database =  array(
	'host' => 'localhost',
	'user' => 'malha',
	'pass' => 'm@lh@',
	'table' => 'malha'
);

define( 'DATABASE', serialize( $database ) );

// salt for password hashing
DEFINE( 'SALT', 'w[lWeLXs.PJzvCP.ia9*;%%P.o`wt< 2G+_ dan_Lz{2s2]2eokc]>0lN?mTP-%;' );

//
DEFINE( 'HOME_PATH', '/home/proj/public_html' );
//DEFINE( 'HOME_PATH', '/2012_lm4_g12/campFire/' );

//default lang
$defaultLang = 'pt';