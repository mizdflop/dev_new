<?php

/**
 * Captcha
 */
	Router::connect('/captcha/image', array('plugin' => 'Captcha','controller' => 'captcha','action' => 'display'));