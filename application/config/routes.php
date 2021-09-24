<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['register'] = 'ApiController/register';
$route['login'] = 'ApiController/login';

$route['default_controller'] = 'ApiController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
