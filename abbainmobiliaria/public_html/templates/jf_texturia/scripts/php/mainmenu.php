<?php
/*------------------------------------------------------------------------
# JF TEXTURIA - JOOMFREAK.COM JOOMLA 1.5.0 TEMPLATE 09-2011
# ------------------------------------------------------------------------
# COPYRIGHT: (C) 2011 JOOMFREAK.COM / KREATIF MULTIMEDIA GMBH
# LICENSE: Creative Commons Attribution
# AUTHOR: JOOMFREAK.COM
# WEBSITE:  http://www.joomfreak.com - http://www.kreatif-multimedia.com
# EMAIL:  info@joomfreak.com
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access');

ini_set('arg_separator.output','&amp;');
function mosShowListMenu($menutype) {
	global  $my, $cur_template, $Itemid;
		
		$rt = "";
		
		$database = &JFactory::getDBO();
	
		$class_sfx = null;
		$hilightid = null;
		
		$database->setQuery("SELECT m.*, sum(case when p.published=1 then 1 else 0 end) as cnt" .
		"\nFROM #__menu AS m" .
		"\nLEFT JOIN #__menu AS p ON p.parent = m.id" .
		"\nWHERE m.menutype='$menutype' AND m.published='1' AND m.access <= '$my->gid'" .
		"\nGROUP BY m.id ORDER BY m.parent, m.ordering ");
	
		$rows = $database->loadObjectList( 'id' );
		
		echo $database->getErrorMsg();
		
		//work out if this should be highlighted
		$sql = "SELECT m.* FROM #__menu AS m"
		. "\nWHERE menutype='". $menutype ."' AND m.published='1'"; 
		$database->setQuery( $sql );
		$subrows = $database->loadObjectList( 'id' );
		$maxrecurse = 5;
		$parentid = $Itemid;
	
		//this makes sure toplevel stays hilighted when submenu active
		while ($maxrecurse-- > 0) {
			$parentid = getParentRow($subrows, $parentid);
			if (isset($parentid) && $parentid >= 0 && $subrows[$parentid]) {
				$hilightid = $parentid;
			} else {
				break;	
			}
		}
	
		$indents = array(
		// block prefix / item prefix / item suffix / block suffix
		array( "<ul id=\"smartMenuUL\">", "<li class=\"topLevel\">" , "</li>", "</ul>" ),
		array( "<ul>", "<li>" , "</li>", "</ul>")
		);
	
		// establish the hierarchy of the menu
		$children = array();
	
		// first pass - collect children
		foreach ($rows as $v ) {
			$pt = $v->parent;
			$list = @$children[$pt] ? $children[$pt] : array();
			array_push( $list, $v );	
			$children[$pt] = $list;	
		}
	
		// second pass - collect 'open' menus
		$open = array( $Itemid );
		$count = 20; // maximum levels - to prevent runaway loop
		$id = $Itemid;
		while (--$count) {
			if (isset($rows[$id]) && $rows[$id]->parent > 0) {
				$id = $rows[$id]->parent;
				$open[] = $id;
			} else {
				break;
			}
		}
	
		$class_sfx = null;
	
		$rt = mosRecurseListMenu( 0, 0, $children, $open, $indents, $class_sfx, $hilightid );
		print_r($rt);
	}
	
	function mosRecurseListMenu( $id, $level, &$children, $open, &$indents, $class_sfx, $highlight ) {
		global $Itemid;
		global $HTTP_SERVER_VARS;
	
		$database = &JFactory::getDBO();
		
		$rt = "";
		if (@$children[$id]) {
			$n = min( $level, count( $indents )-1 );
			
		
			if($level != 0 )
				$rt .= "<ul class=\"subLevel_".$level."\">";
			else
				$rt .= $indents[$n][0];
			$l = 0;
			$number = count($children[$id]);
			foreach ($children[$id] as $row) {
							
				switch ($row->type) {
					case 'separator':
					$row->link = "seperator";	
					break;
			  
					case 'url':
						if ( eregi( 'index.php\?', $row->link ) ) {
								if ( !eregi( 'Itemid=', $row->link ) ) {
									$row->link .= '&amp;Itemid='. $row->id;
								}
							}
					break;
			  
					default:
						if ( !eregi( 'Itemid=', $row->link ) ) {
								$row->link .= '&amp;Itemid='. $row->id;
						}
					break;
				}
				$last = "";
				$l++;
				
								
				$li =  "\n".$indents[$n][1] ;
				
				if($l==$number) {
					$last = " last";
					$li = "<li class=\"topLevel last\">";
				}
				
				$current_itemid = trim( JRequest::getInt('Itemid', 0) );
				if ($row->link != "seperator" &&
									$current_itemid == $row->id || 
						$row->id == $highlight || 
					(sefRelToAbsRewrite( substr($_SERVER['PHP_SELF'],0,-9) . $row->link)) == $_SERVER['REQUEST_URI'] ||
					(sefRelToAbsRewrite( substr($_SERVER['PHP_SELF'],0,-9) . $row->link)) == $HTTP_SERVER_VARS['REQUEST_URI']) {
								if($level == 0 )
									$li = "<li class=\"topLevel active".$last."\">";
								else
									$li = "<li class=\"active".$last."\">";
							}
							
				  $rt .= $li;
									
				$rt .= mosGetLink( $row, $level, $class_sfx );
				$rt .= mosRecurseListMenu( $row->id, $level+1, $children, $open, $indents, $class_sfx, "");
				$rt .= $indents[$n][2];
	
			}
			$rt .= "\n".$indents[$n][3];
	
		}
		
		return $rt;
	}
	
	function sefRelToAbsRewrite($link) {
			$uri    = JURI::getInstance();
			$prefix = $uri->toString(array('scheme', 'host', 'port'));
			$link = str_replace('&amp;', '&', $link);
			
			return $link;
	}
	
	function getParentRow($rows, $id) {
		if (isset($rows[$id]) && $rows[$id]) {
			if($rows[$id]->parent > 0) {
				return $rows[$id]->parent;
			}	
		}
		return -1;
	}
	
	function mosGetLink( $mitem, $level, $class_sfx='' ) {
	
		$mitem->link = str_replace( '&', '&amp;', $mitem->link );
	
		if (strcasecmp(substr($mitem->link,0,4),"http"))
			$mitem->link = sefRelToAbsRewrite($mitem->link);
		
		
		$mitem->name = "<span>".$mitem->name."</span>";
		switch ($mitem->browserNav) {
			case 1:
				$txt = "<a href=\"$mitem->link\" class=\"a_level$level\" target=\"_window\" >$mitem->name</a>\n";
				break;
				
			case 2:
				$txt = "<a href=\"#\" class=\"a_level$level\" onClick=\"javascript: window.open('$mitem->link', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');\" >$mitem->name</a>\n";
			break;
			
			case 3:
				$txt = "<a class=\"a_level$level\">$mitem->name</a>\n";
				break;
	
			default:
			$txt = "<a href=\"$mitem->link\" class=\"a_level$level\">$mitem->name</a>";
			break;
		}
		return $txt;
		
	}
