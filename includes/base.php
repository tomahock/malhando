<?php
/**
 * Created by PhpStorm.
 * User: tomahock
 * Date: 17/11/13
 * Time: 14:36
 */

//session_start();

require_once( 'actions.php' );
function pre_print_r( $foo )
{
	echo '<pre>';
	print_r( $foo );
	echo '</pre>';
}