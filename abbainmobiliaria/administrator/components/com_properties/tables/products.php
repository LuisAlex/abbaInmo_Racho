<?php
/*------------------------------------------------------------------------
# com_properties
# ------------------------------------------------------------------------
# author Fabio Esteban Uzeltinger
# copyright Copyright (C) 2011 com-property.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:  www.com-property.com
# Technical Support: www.com-property.com/forum-v4
*/
// no direct access
defined('_JEXEC') or die('Restricted access'); 

class Tableproducts extends JTable
{    
	var $id = null;
	var $name = null;
	var $alias = null;
	var $agent_id = null;
	var $agent = null;
	var $ref = null;
	var $type = null;
	var $parent = null;
	var $cid = null;
	var $lid = null;
	var $sid = null;
	var $cyid = null;	
	var $postcode = null;
	var $address = null;
	var $description = null;
	var $text = null;
	var $price = null;
	var $currency = null;
	var $published = null;
	var $use_booking = null;
	var $ordering = null;
	var $panoramic = null;	
	var $video = null;	
	var $lat = null;	
	var $lng = null;	
	var $available = null;	
	var $featured = null;	
	var $years = null;	
	var $capacity = null;	
	var $bedrooms = null;	
	var $bathrooms = null;	
	var $garage = null;	
	var $area = null;	
	var $covered_area = null;	
	var $hits = null;	
	var $listdate = null;	
	var $refresh_time = null;	
	var $checked_out = null;	
	var $checked_out_time = null;
	var $language = null;	
	var $params = null;
	var $metatitle = null;
	var $metadesc = null;
	var $metakey = null;
	var $layout = null;	
  var $extra1 = null;
  var $extra2 = null;
  var $extra3 = null;
  var $extra4 = null;
  var $extra5 = null;
  var $extra6 = null;
  var $extra7 = null;
  var $extra8 = null;
  var $extra9 = null;
  var $extra10 = null;
  var $extra11 = null;
  var $extra12 = null;
  var $extra13 = null;
  var $extra14 = null;
  var $extra15 = null;
  var $extra16 = null;
  var $extra17 = null;
  var $extra18 = null;
  var $extra19 = null;
  var $extra20 = null;
  var $extra21 = null;
  var $extra22 = null;
  var $extra23 = null;
  var $extra24 = null;
  var $extra25 = null;
  var $extra26 = null;
  var $extra27 = null;
  var $extra28 = null;
  var $extra29 = null;
  var $extra30 = null;
  var $extra31 = null;
  var $extra32 = null;
  var $extra33 = null;
  var $extra34 = null;
  var $extra35 = null;
  var $extra36 = null;
  var $extra37 = null;
  var $extra38 = null;
  var $extra39 = null;
  var $extra40 = null;
  
   function __construct(&$db)
  {
    parent::__construct( '#__properties_products', 'id', $db );
  }
  function check()
	{		
		if(empty($this->alias)) {
			$this->alias = $this->name;
		}
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		$datenow =& JFactory::getDate();
		
		if(trim(str_replace('-','',$this->alias)) == '') {			
			$this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}
		
		$query = 'SELECT alias FROM #__properties_products'
				.' WHERE alias = ' . $this->_db->Quote( $this->alias ) 
				.' AND id <>' . intval( $this->id );
        	$this->_db->setQuery( $query );
			$aliasrow = $this->_db->loadResult();	
			//print_r($aliasrow);
			
        		if ( $aliasrow )
				{
				
				$this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
				$this->setError(JText::_('Property alias already exists, is replaced to : '.$this->alias));
				JError::raiseNotice(400, 'Property alias already exists [ '.$aliasrow.' ], is replaced to : '.$this->alias );
				}		
		
		
		if(empty($this->ref)) 
		{
		while($x!=1)
			{
			$this->ref = $this->generateIdent('AAA999');		
       		 $query = 'SELECT ref FROM #__properties_products WHERE ref=' . $this->_db->Quote( $this->ref ) 
               . ' AND id <>' . intval( $this->id );
        	$this->_db->setQuery( $query );
			$this->row = $this->_db->loadResult();	
        		if ( !$this->row )
				{
				$x=1;
				}
			}
		}
		
		
		if(empty($this->metatitle)) {
			$this->metatitle = $this->name;
		}
		if(empty($this->metadesc)) {
			$this->metadesc = $this->getMeta();
		}
		if(empty($this->metakey)) {
			$this->metakey = $this->getMeta();
		}
		
		$this->refresh_time = $datenow->toFormat("%Y:%m:%d %H:%M:%S");
		
		return true;
	}
		
	 function generateIdent($pattern='AAA999')
    	{
        $alpha = array("A","B","C","D","E","F","G","H",
             "J","K","L","M","N","P","Q","R","S","T","U","V","W","Y","Z");
        $digit = array("1","2","3","4","5","6","7","8","9");
        // :: TODO :: add check in table for duplicates
        $return = "";
        $pattern_array = str_split($pattern, 1);
        foreach ( $pattern_array as $v ) {
            if ( is_numeric($v) ) {
                $return .= $digit[array_rand($digit)];
            } elseif ( in_array(strtoupper($v), $alpha) ) {
                $return .= $alpha[array_rand($alpha)];
            } else {
                $return .= " ";
            }
        }
        return $return;
    	}
			
	function getMeta()
		{
		$db 	=& JFactory::getDBO();	
		$query = 	"SELECT c.name as category,t.name as type,l.name as locality "
				. " from #__properties_category as c "
				. " LEFT JOIN #__properties_type as t ON t.id = ".$this->type
				. " LEFT JOIN #__properties_locality as l ON l.id = ".$this->lid
				. " WHERE c.id = ".$this->cid;			
		$db->setQuery( $query );					
		$row = $db->loadObject();
			
		return $this->name.', '.$row->type.', '.$row->category.', '.$this->postcode.', '.$this->address.', '.$row->locality;
		}

}
?>