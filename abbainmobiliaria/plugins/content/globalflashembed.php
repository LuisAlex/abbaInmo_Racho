<?php
/**
 * @copyright   Copyright (c) 2010-2011 Mediaparts Interactive. All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl.html
 */

defined('_JEXEC') or die('Restricted access');	// No direct access

jimport('joomla.plugin.plugin');

class plgContentGlobalFlashEmbed extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatibility we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access  protected
	 * @param   object  $subject The object to observe
	 * @param   array   $config  An array that holds the plugin configuration
	 */
	function plgContentGlobalFlashEmbed( &$subject, $config )
	{
		parent::__construct($subject, $config);

		// Do some extra initialisation in this constructor if required
		$this->componentDir = JPATH_ROOT.DS.'components'.DS.'com_globalflashgalleries';
	}

	/**
	 * Before display content method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param   object  The article object.  Note $article->text is also available
	 * @param   object  The article params
	 * @param   int     The 'page' number
	 * @return  string
	 */
	function onBeforeDisplayContent( &$article, &$params, $page = 0 )
	{
		if ( isset($article->text) )
		{
			$article->text = preg_replace_callback('/{globalflash\.gallery\s+(\d+)\s*}/i', array(&$this, 'legacyGallery'), $article->text);
			$article->text = $this->replaceShortcode($article->text, 'globalflash.gallery', array(&$this, 'gallery'));
		}
		return '';
	}

	/**
	 * @since   Joomla 1.6
	 */
	function onContentBeforeDisplay( $context, &$article, &$params, $page = 0 )
	{
		return $this->onBeforeDisplayContent($article, $params, $page);
	}

	function replaceShortcode( $text, $tag, $callback )
	{
		$tag = preg_quote($tag, '/');
		if (preg_match_all('/{'.$tag.'(\s+.*?|)\/?}/i', $text, $m)) {
			foreach ($m[0] as $key => $shortcode) {
				$a = array();
				if (preg_match_all('/(\w+)=([\'"](.*?)[\'"]|(\S+))/', $m[1][$key], $m1)) {
					foreach ($m1[1] as $key1 => $name)
						$a[$name] = $m1[3][$key1] == null ? $m1[4][$key1] : $m1[3][$key1];
				}
				$result = call_user_func($callback, $a);
				$text = str_replace($shortcode, $result, $text);
			}
		}
		return $text;
	}

	function gallery( $a )
	{
		if ( is_dir($this->componentDir) && !empty($a['id']) )
		{
			$id = JRequest::getVar('id');
			JRequest::setVar('id', (int)$a['id']);

			include_once $this->componentDir.DS.'defines.php';
			include_once $this->componentDir.DS.'views'.DS.'gallery'.DS.'view.html.php';

			$view = new GlobalFlashGalleriesViewGallery();
			$view->options = $a;
			$view->addTemplatePath($this->componentDir.DS.'views'.DS.'gallery'.DS.'tmpl');

			ob_start();
			$view->display();
			$html = ob_get_clean();

			JRequest::setVar('id', $id);

			return $html;
		}
	}

	function legacyGallery( $m )
	{
		if ( is_dir($this->componentDir) )
		{
			$id = JRequest::getVar('id');
			JRequest::setVar('id', $m[1]);

			include_once $this->componentDir.DS.'defines.php';
			include_once $this->componentDir.DS.'views'.DS.'gallery'.DS.'view.html.php';

			$view = new GlobalFlashGalleriesViewGallery();
			$view->addTemplatePath($this->componentDir.DS.'views'.DS.'gallery'.DS.'tmpl');

			ob_start();
			$view->display();
			$html = ob_get_clean();

			JRequest::setVar('id', $id);

			return $html;
		}
	}

}
