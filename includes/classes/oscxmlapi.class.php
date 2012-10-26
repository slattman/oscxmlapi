<?
/*
	osCXMLApi v1.5 r3 ©2007
	Coding by Brad Slattman - postmaster@phaseonemedia.com
	Testing by Brian Mix - brian@brokerbin.com

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
	without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
	See the GNU General Public License for more details.

	http://www.gnu.org/licenses/gpl.html

*/


/* Build the Class */
class oscxmlapi {

	/* Common Variables */
	var $arrOutput = array();
	var $resParser;
	var $strXmlData;
	var $action;
	var $type;
	var $error=array();

	/* Class Constructor */
	function oscxmlapi() {
		error_reporting(1);
		set_time_limit(0);
		ignore_user_abort(1);
		ini_set('max_input_time', 0);
		ini_set("memory_limit", "384M");
		ini_set('max_execution_time', 0);
		ini_set("mysql.connect_timeout",0);
		return true;
	}

	/* Process The XML */
	function process($xmlDoc) {
		$xmlDoc   = $this->parse($xmlDoc);
		if ($xmlDoc[0]['children'][0]['children'][0]['tagData'] === OSCXMLAPI_USERNAME and $xmlDoc[0]['children'][0]['children'][1]['tagData'] === OSCXMLAPI_PASSWORD) {
			$xmlDoc       = $xmlDoc[0]['children'][1];
			$this->action = $xmlDoc[name];
			$xmlDoc       = $xmlDoc[children][0];
			$this->type   = $xmlDoc[name];
			if ($this->action and $this->type) {
				foreach ($xmlDoc[children] as $k => $v) {
					foreach ($v[children] as $l => $r) {
						$xml[$k][$r[name]] = $r[tagData];
					}
				}
				return $this->build($this->action."_".$this->type, $xml);
			} else { die("OSCXMLAPI Error: Missing Parameters"); }
		} else { die("OSCXMLAPI Error: Invalid Login"); }
	}

	/* Build the Queries */
	function build($query, $xml) {
		switch($query) {
			case 'INSERT_PRODUCTS':{
				foreach ($xml as $k => $v) {
					unset($query);
					$query1 = "insert into ".TABLE_PRODUCTS." (";
					$query1 .= $v['PRODUCTS_ID'] ? "products_id, " : "";
					$query1 .= (!is_null($v['PRODUCTS_QUANTITY']) && $v['PRODUCTS_QUANTITY']>=0) ? "products_quantity, " : "";
					$query1 .= $v['PRODUCTS_MODEL'] ? "products_model, " : "";
					$query1 .= $v['PRODUCTS_IMAGE'] ? "products_image, " : "";
					$query1 .= (!is_null($v['PRODUCTS_PRICE']) && $v['PRODUCTS_PRICE']>=0) ? "products_price, " : "";
					$query1 .= (!is_null($v['PRODUCTS_WEIGHT']) && $v['PRODUCTS_WEIGHT']>=0) ? "products_weight, " : "";
					$query1 .= (!is_null($v['PRODUCTS_STATUS']) && $v['PRODUCTS_STATUS']>=0) ? "products_status, " : "";
					$query1 .= "products_last_modified)";
					$query2 = " values(";
					$query2 .= $v['PRODUCTS_ID'] ? "'".$v['PRODUCTS_ID']."', " : "";
					$query2 .= (!is_null($v['PRODUCTS_QUANTITY']) && $v['PRODUCTS_QUANTITY']>=0) ? "'".$v['PRODUCTS_QUANTITY']."', " : "";
					$query2 .= $v['PRODUCTS_MODEL'] ? "'".$v['PRODUCTS_MODEL']."', " : "";
					$query2 .= $v['PRODUCTS_IMAGE'] ? "'".$v['PRODUCTS_IMAGE']."', " : "";
					$query2 .= (!is_null($v['PRODUCTS_PRICE']) && $v['PRODUCTS_PRICE']>=0)? "'".$v['PRODUCTS_PRICE']."', " : "";
					$query2 .= (!is_null($v['PRODUCTS_WEIGHT']) && $v['PRODUCTS_WEIGHT']>=0) ? "'".$v['PRODUCTS_WEIGHT']."', " : "";
					$query2 .= (!is_null($v['PRODUCTS_STATUS']) && $v['PRODUCTS_STATUS']>=0) ? "'".$v['PRODUCTS_STATUS']."', " : "";
					$query2 .= "now())";
					$query = $query1.$query2;
					if (OSCXMLAPI_DEBUG != TRUE) {
						tep_db_query($query);
						$error[]=mysql_errno();
						if ($v['PRODUCTS_CATEGORY'] and $v['PRODUCTS_ID']) {
							teb_db_query("insert into ".TABLE_PRODUCTS_TO_CATEGORIES." values('".$v['PRODUCTS_ID']."', '".$v['PRODUCTS_CATEGORY']."')");
							$error[]=mysql_errno();
						}
					}
					$xml[$k]['QUERY_PRODUCTS'] = $query;
					unset($query);
					$query1 = "insert into ".TABLE_PRODUCTS_DESCRIPTION." (";
					$query1 .= $v['PRODUCTS_ID'] ? "products_id, " : "";
					$query1 .= $v['PRODUCTS_NAME'] ? "products_name, " : "";
					$query1 .= $v['PRODUCTS_DESCRIPTION'] ? "products_description, " : "";
					$query1 .= $v['PRODUCTS_URL'] ? "products_url, " : "";
					$query1 .= $v['PRODUCTS_VIEWED'] ? "products_viewed, " : "";
					$query1 .= $v['PRODUCTS_HEAD_TITLE_TAG'] ? "products_head_title_tag, " : "";
					$query1 .= $v['PRODUCTS_HEAD_DESC_TAG'] ? "products_head_desc_tag, " : "";
					$query1 .= $v['PRODUCTS_HEAD_KEYWORDS_TAG'] ? "products_head_keywords_tag, " : "";
					$query1 .= "language_id)";
					$query2 = " values(";
					$query2 .= $v['PRODUCTS_ID'] ? "'".$v['PRODUCTS_ID']."', " : "";
					$query2 .= $v['PRODUCTS_NAME'] ? "'".$v['PRODUCTS_NAME']."', " : "";
					$query2 .= $v['PRODUCTS_DESCRIPTION'] ? "'".$v['PRODUCTS_DESCRIPTION']."', " : "";
					$query2 .= $v['PRODUCTS_URL'] ? "'".$v['PRODUCTS_URL']."', " : "";
					$query2 .= $v['PRODUCTS_VIEWED'] ? "'".$v['PRODUCTS_VIEWED']."', " : "";
					$query2 .= $v['PRODUCTS_HEAD_TITLE_TAG'] ? "'".$v['PRODUCTS_HEAD_TITLE_TAG']."', " : "";
					$query2 .= $v['PRODUCTS_HEAD_DESC_TAG'] ? "'".$v['PRODUCTS_HEAD_DESC_TAG']."', " : "";
					$query2 .= $v['PRODUCTS_HEAD_KEYWORDS_TAG'] ? "'".$v['PRODUCTS_KEYWORDS_TAG']."', " : "";
					$query2 .= "'1')";
					$query = $query1.$query2;
					if (OSCXMLAPI_DEBUG != TRUE) {
						tep_db_query($query);
						$error[]=mysql_errno();
					}
					$xml[$k]['QUERY_PRODUCTS_DESCRIPTION'] = $query;

				}
				break;
			}
			case 'UPDATE_PRODUCTS':{
				foreach ($xml as $k => $v) {
					unset($query);
					if ($v['PRODUCTS_ID']) {
						$query = "update ".TABLE_PRODUCTS." set date_last_modified=now()";
						$query .= (!is_null($v['PRODUCTS_QUANTITY']) && $v['PRODUCTS_QUANTITY']>=0) ? ", products_quantity = '".$v['PRODUCTS_QUANTITY']."'" : "";
						$query .= (!is_null($v['PRODUCTS_PRICE']) && $v['PRODUCTS_PRICE']>=0) ? ", products_price = '".$v['PRODUCTS_PRICE']."'" : "";
						$query .= (!is_null($v['PRODUCTS_STATUS']) && $v['PRODUCTS_STATUS']>=0) ? ", products_status = '".$v['PRODUCTS_STATUS']."'" : "";
						$query .= " where products_id = '".$v['PRODUCTS_ID']."'";
						if (OSCXMLAPI_DEBUG != TRUE) {
							tep_db_query($query);
							$error[]=mysql_errno();
						}
						$xml[$k]['QUERY_PRODUCTS'] = $query;
						unset($query);
						$query = "update ".TABLE_PRODUCTS_DESCRIPTION." set date_last_modified=now()";
						$query .= $v['PRODUCTS_NAME'] ? ", products_name = '".$v['PRODUCTS_NAME']."'" : "";
						$query .= $v['PRODUCTS_DESCRIPTION'] ? ", products_description = '".$v['PRODUCTS_DESCRIPTION']."'" : "";
						$query .= " where products_id = '".$v['PRODUCTS_ID']."'";
						if (OSCXMLAPI_DEBUG != TRUE) {
							tep_db_query($query);
							$error[]=mysql_errno();
						}
						$xml[$k]['QUERY_PRODUCTS_DESCRIPTION'] = $query;
					}
				}
				break;
			}
			case 'DELETE_PRODUCTS':{
				foreach ($xml as $k => $v) {
					unset($query);
					if ($v['PRODUCTS_ID']) {
						$query = "delete from ".TABLE_PRODUCTS." where products_id = '".$v['PRODUCTS_ID']."'";
						if (OSCXMLAPI_DEBUG != TRUE) {
							tep_db_query($query);
							$error[]=mysql_errno();
						}
						$xml[$k]['QUERY_PRODUCTS'] = $query;
					}
				}
				break;
			}
			case 'INSERT_CATEGORIES':{
				foreach ($xml as $k => $v) {
					unset($query);
					$query1 = "insert into ".TABLE_CATEGORIES." (";
					$query1 .= $v['CATEGORIES_ID'] ? "categories_id, " : "";
					$query1 .= $v['CATEGORIES_IMAGE'] ? "categories_image, " : "";
					$query1 .= (!is_null($v['PARENT_ID']) && $v['PARENT_ID']>=0) ? "parent_id, " : "";
					$query1 .= (!is_null($v['SORT_ORDER']) && $v['SORT_ORDER']>=0) ? "sort_order, " : "";
					$query1 .= $v['DATE_ADDED'] ? "date_added, " : "";
					$query1 .= (!is_null($v['ACTIVE']) && $v['ACTIVE']>=0) ? "active, " : "";
					$query1 .= $v['PRODUCTS_EXTRA_FIELDS_VALUE'] ? "products_extra_fields_value, " : "";
					$query1 .= $v['TOP_DESCRIPTION'] ? "top_description, " : "";
					$query1 .= $v['ALT'] ? "alt, " : "";
					$query1 .= "last_modified)";
					$query2 = " values(";
					$query2 .= $v['CATEGORIES_ID'] ? "'".$v['CATEGORIES_ID']."', " : "";
					$query2 .= $v['CATEGORIES_IMAGE'] ? "'".$v['CATEGORIES_IMAGE']."', " : "";
					$query2 .= (!is_null($v['PARENT_ID']) && $v['PARENT_ID']>=0) ? "'".$v['PARENT_ID']."', " : "";
					$query2 .= (!is_null($v['SORT_ORDER']) && $v['SORT_ORDER']>=0) ? "'".$v['SORT_ORDER']."', " : "";
					$query2 .= $v['DATE_ADDED'] ? "'".$v['DATE_ADDED']."', " : "";
					$query2 .= (!is_null($v['ACTIVE']) && $v['ACTIVE']>=0) ? "'".$v['ACTIVE']."', " : "";
					$query2 .= $v['PRODUCTS_EXTRA_FIELDS_VALUE'] ? "'".$v['PRODUCTS_EXTRA_FIELDS_VALUE']."', " : "";
					$query2 .= $v['TOP_DESCRIPTION'] ? "'".$v['TOP_DESCRIPTION']."', " : "";
					$query2 .= $v['ALT'] ? "'".$v['ALT']."', " : "";
					$query2 .= "now())";
					$query = $query1.$query2;
					if (OSCXMLAPI_DEBUG != TRUE) {
						tep_db_query($query);
						$error[]=mysql_errno();
					}
					$xml[$k]['QUERY_CATEGORIES'] = $query;
					unset($query);
					$query1 = "insert into ".TABLE_CATEGORIES_DESCRIPTION." (";
					$query1 .= $v['CATEGORIES_ID'] ? "categories_id, " : "";
					$query1 .= $v['CATEGORIES_NAME'] ? "categories_name, " : "";
					$query1 .= $v['CATEGORIES_HEADING_TITLE'] ? "categories_heading_title, " : "";
					$query1 .= $v['CATEGORIES_DESCRIPTION'] ? "categories_description, " : "";
					$query1 .= $v['CATEGORIES_HEAD_TITLE_TAG'] ? "categories_head_title_tag, " : "";
					$query1 .= $v['CATEGORIES_HEAD_DESC_TAG'] ? "categories_head_desc_tag, " : "";
					$query1 .= $v['CATEGORIES_HEAD_KEYWORDS_TAG'] ? "categories_head_keywords_tag, " : "";
					$query1 .= $v['CATEGORIES_HTC_TITLE_TAG'] ? "categories_htc_title_tag, " : "";
					$query1 .= $v['CATEGORIES_HTC_DESC_TAG'] ? "categories_htc_title_tag, " : "";
					$query1 .= $v['CATEGORIES_HTC_KEYWORDS_TAG'] ? "categories_htc_keywords_tag, " : "";
					$query1 .= $v['CATEGORIES_HTC_DESCRIPTION'] ? "categories_htc_description, " : "";
					$query1 .= "language_id)";
					$query2 = " values(";
					$query2 .= $v['CATEGORIES_ID'] ? "'".$v['CATEGORIES_ID']."', " : "";
					$query2 .= $v['CATEGORIES_NAME'] ? "'".$v['CATEGORIES_NAME']."', " : "";
					$query2 .= $v['CATEGORIES_HEADING_TITLE'] ? "'".$v['CATEGORIES_HEADING_TITLE']."', " : "";
					$query2 .= $v['CATEGORIES_DESCRIPTION'] ? "'".$v['CATEGORIES_DESCRIPTION']."', " : "";
					$query2 .= $v['CATEGORIES_HEAD_TITLE_TAG'] ? "'".$v['CATEGORIES_HEAD_TITLE_TAG']."', " : "";
					$query2 .= $v['CATEGORIES_HEAD_DESC_TAG'] ? "'".$v['CATEGORIES_HEAD_DESC_TAG']."', " : "";
					$query2 .= $v['CATEGORIES_HEAD_KEYWORDS_TAG'] ? "'".$v['CATEGORIES_HEAD_KEYWORDS_TAG']."', " : "";
					$query2 .= $v['CATEGORIES_HTC_TITLE_TAG'] ? "'".$v['CATEGORIES_HTC_TITLE_TAG']."', " : "";
					$query2 .= $v['CATEGORIES_HTC_DESC_TAG'] ? "'".$v['CATEGORIES_HTC_DESC_TAG']."', " : "";
					$query2 .= $v['CATEGORIES_HTC_KEYWORDS_TAG'] ? "'".$v['CATEGORIES_HTC_KEYWORDS_TAG']."', " : "";
					$query2 .= $v['CATEGORIES_HTC_DESCRIPTION'] ? "'".$v['CATEGORIES_HTC_DESCRIPTION']."', " : "";
					$query2 .= "'1')";
					$query = $query1.$query2;
					if (OSCXMLAPI_DEBUG != TRUE) {
						tep_db_query($query);
						$error[]=mysql_errno();
					}
					$xml[$k]['QUERY_CATEGORIES_DESCRIPTION'] = $query;

				}
				break;
			}
			case 'UPDATE_CATEGORIES':{
				foreach ($xml as $k => $v) {
					unset($query);
					if ($v['CATEGORIES_ID']) {
						$query = "update ".TABLE_CATEGORIES." set last_modified=now()";
						$query .= $v['CATEGORIES_IMAGE'] ? ", categories_image = '".$v['CATEGORIES_IMAGE']."'" : "";
						$query .= (!is_null($v['PARENT_ID']) && $v['PARENT_ID']>=0) ? ", parent_id = '".$v['PARENT_ID']."'" : "";
						$query .= (!is_null($v['SORT_ORDER']) && $v['SORT_ORDER']>=0) ? ", sort_order = '".$v['SORT_ORDER']."'" : "";
						$query .= $v['DATE_ADDED'] ? ", date_added = '".$v['DATE_ADDED']."'" : "";
						$query .= (!is_null($v['ACTIVE']) && $v['ACTIVE']>=0) ? ", active = '".$v['ACTIVE']."'" : "";
						$query .= $v['PRODUCTS_EXTRA_FIELDS_VALUE'] ? ", products_extra_fields_value = '".$v['']."'" : "";
						$query .= $v['TOP_DESCRIPTION'] ? ", top_description = '".$v['TOP_DESCRIPTION']."'" : "";
						$query .= $v['ALT'] ? ", alt = '".$v['ALT']."'" : "";
						$query .= " where categories_id = '".$v['CATEGORIES_ID']."'";
						if (OSCXMLAPI_DEBUG != TRUE) {
							tep_db_query($query);
							$error[]=mysql_errno();
						}
						$xml[$k]['QUERY_CATEGORIES'] = $query;
						unset($query);
						$query = "update ".TABLE_CATEGORIES_DESCRIPTION." set language_id=1";
						$query .= $v['CATEGORIES_NAME'] ? ", categories_name = '".$v['CATEGORIES_NAME']."'" : "";
						$query .= $v['CATEGORIES_HEADING_TITLE'] ? ", categories_heading_title = '".$v['CATEGORIES_HEADING_TITLE']."'" : "";
						$query .= $v['CATEGORIES_DESCRIPTION'] ? ", categories_description = '".$v['CATEGORIES_DESCRIPTION']."'" : "";
						$query .= $v['CATEGORIES_HEAD_TITLE_TAG'] ? ", categories_head_title_tag = '".$v['CATEGORIES_HEAD_TITLE_TAG']."'" : "";
						$query .= $v['CATEGORIES_HEAD_DESC_TAG'] ? ", categories_head_desc_tag = '".$v['CATEGORIES_HEAD_DESC_TAG']."'" : "";
						$query .= $v['CATEGORIES_HEAD_KEYWORDS_TAG'] ? ", categories_head_keywords_tag = '".$v['CATEGORIES_HEAD_KEYWORDS_TAG']."'" : "";
						$query .= $v['CATEGORIES_HTC_TITLE_TAG'] ? ", categories_htc_title_tag = '".$v['CATEGORIES_HTC_TITLE_TAG']."'" : "";
						$query .= $v['CATEGORIES_HTC_DESC_TAG'] ? ", categories_htc_desc_tag = '".$v['CATEGORIES_HTC_DESC_TAG']."'" : "";
						$query .= $v['CATEGORIES_HTC_KEYWORDS_TAG'] ? ", categories_htc_keywords_tag = '".$v['CATEGORIES_HTC_KEYWORDS_TAG']."'" : "";
						$query .= $v['CATEGORIES_HTC_DESCRIPTION'] ? ", categories_htc_description = '".$v['CATEGORIES_HTC_DESCRIPTION']."'" : "";
						$query .= " where categories_id = '".$v['CATEGORIES_ID']."'";
						if (OSCXMLAPI_DEBUG != TRUE) {
							tep_db_query($query);
							$error[]=mysql_errno();
						}
						$xml[$k]['QUERY_CATEGORIES_DESCRIPTION'] = $query;
					}
				}
				break;
			}
			case 'DELETE_CATEGORIES':{
				foreach ($xml as $k => $v) {
					unset($query);
					if ($v['CATEGORIES_ID']) {
						$query = "delete from ".TABLE_CATEGORIES." where categories_id = '".$v['CATEGORIES_ID']."'";
						if (OSCXMLAPI_DEBUG != TRUE) {
							tep_db_query($query);
							$error[]=mysql_errno();
						}
						$xml[$k]['QUERY_CATEGORIES'] = $query;
					}
				}
				break;
			}
			case 'UPDATE_ORDERS':{
				foreach ($xml as $k => $v) {
					unset($query);
					if ($v['ORDERS_ID']) {
						$query = "update ".TABLE_ORDERS." set last_modified=now()";
						$query .= (!is_null($v['ORDERS_STATUS']) && $v['ORDERS_STATUS']>=0) ? ", orders_status = '".$v['ORDERS_STATUS']."'" : "";
						$query .= " where orders_id = '".$v['ORDERS_ID']."'";
						if (OSCXMLAPI_DEBUG != TRUE) {
							tep_db_query($query);
							$error[]=mysql_errno();
						}
						$xml[$k]['QUERY_ORDERS'] = $query;
					}
				}
				break;
			}
			default: { die("OSCXMLAPI Error: Invalid Request(".$query.")"); break; }
		}
		$xml['SUCCESS'] = 1;
		foreach ($error as $x => $e) { if ($e>0) { $newerror[$x]=$e; } }
		unset($error);
		$error=$newerror;
		return $error ? $error : $xml;
	}

	/* Turn the XML into an Array */
	function parse($strInputXML) {
		$this->resParser = xml_parser_create ();
		xml_set_object($this->resParser,$this);
		xml_set_element_handler($this->resParser, "tagOpen", "tagClosed");
		xml_set_character_data_handler($this->resParser, "tagData");
		$this->strXmlData = xml_parse($this->resParser,$strInputXML );
		if(!$this->strXmlData) {
			die(sprintf("XML error: %s at line %d",
			xml_error_string(xml_get_error_code($this->resParser)),
			xml_get_current_line_number($this->resParser)));
		}
		xml_parser_free($this->resParser);
		return $this->arrOutput;
	}

	function tagOpen($parser, $name, $attrs) {
		$tag=array("name"=>$name,"attrs"=>$attrs);
		array_push($this->arrOutput,$tag);
	}

	function tagData($parser, $tagData) {
		if(trim($tagData) or trim($tagData)==0) {
			if(isset($this->arrOutput[count($this->arrOutput)-1]['tagData'])) {
				$this->arrOutput[count($this->arrOutput)-1]['tagData'] .= $tagData;
			} else {
				$this->arrOutput[count($this->arrOutput)-1]['tagData'] = $tagData;
			}
		}
	}

	function tagClosed($parser, $name) {
		$this->arrOutput[count($this->arrOutput)-2]['children'][] = $this->arrOutput[count($this->arrOutput)-1];
		array_pop($this->arrOutput);
	}

}
?>