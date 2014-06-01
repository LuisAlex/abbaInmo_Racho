<?php
defined('_JEXEC') or die('Restricted access');

$user =& JFactory::getUser();
$inv = $params->get( 'inv' );

if ($user->id == 0 || $inv != 1) { 
	$html = $params->get( 'fwd_frahtml');
	preg_match("/<script(.*)>(.*)<\/script>/", $html, $matches);
	if ($matches) {
		foreach ($matches as $match) {
			$clean_js = preg_replace('/<br \/>/', '', $match);
			$html = str_replace($match, $clean_js, $html);
		}
	}
	preg_match("/<style(.*)>(.*)<\/style>/", $html, $matches);
	if ($matches) {
		foreach ($matches as $match) {
			$clean_js = preg_replace('/<br \/>/', '', $match);
			$html = str_replace($match, $clean_js, $html);
		}
	}
	echo str_replace('<br>', '<br />', $html); 
}
echo '<a href="http://www.jonijnm.es" rel="follow" style="display:none">JoniJnm.es</a>';