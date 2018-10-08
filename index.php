<?php
require_once 'setup.php';

require_once ROOT.'lib/TokenManager.php';
use Utils\TokenManager;

$token = TokenManager::create();
require 'form.php';
