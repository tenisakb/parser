<?php

require 'Dispatcher.php';
require 'Grabber.php';
require 'Parser.php';
require 'Output.php';

$dispatcher = new Dispatcher(new Grabber(), new Output(), new Parser());
$dispatcher->run();
