<?php

require_once('app/autoloader.php');

use shoow\util\SourceParser;

$data = SourceParser::loadPosters('Strasbourg');
