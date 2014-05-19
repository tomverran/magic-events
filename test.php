<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tom
 * Date: 19/05/14
 * Time: 23:32
 * To change this template use File | Settings | File Templates.
 */
use tomverran\MagicEvent\Dispatcher;
use tomverran\MagicEvent\Event;

require_once( 'vendor/autoload.php' );
$dispatcher = new Dispatcher();


$dispatcher->on( function(Event $e) {
    echo 'THIS IS VERY MAGIC';
} );

$dispatcher->fire( new Event );
$dispatcher->fire( new StdClass );