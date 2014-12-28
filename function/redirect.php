<?
/*--------------------------------------------- 
common functions file for PHP (1.5.6) [partial] 
Created: 2004 by Chris Bloom [ chrisbloom7[AT]gmail[DOT]com ] 
Last Updated: 2008-05-03 
---------------------------------------------*/ 

if (!defined('POSTBACK_PARAMETER_PREFIX')) define('POSTBACK_PARAMETER_PREFIX','__postback__'); 

/** 
 * Generates a redirect statement based on current state of output/headers 
 * 
 * @access private 
 * @param mixed $targetURL Optional complete URL to redirect to. If not specified, returns false. 
 * @param mixed $dataArray Optional array of name=>value parameters to pass along. 
 * @param boolean $pauseBefore Optional flag. Useful for debugging - will force to redirect by manual form/POST. 
 * @return null Result dependant on redirect method. May be a JavaScript redirect string if output has already started. 
 *   Otherwise, PHP headers will be added directly. Processing will halt directly after in either case. 
 */
class Redirect{
	function redirect($targetURL = false, $dataArray = false, $pauseBefore = false) { 
		if (!strlen($targetURL)) return false; 
	
		$search = ''; 
		if (strrpos($targetURL,'#') !== false) { 
			list($targetURL,$search) = explode('#',$targetURL); 
		} 
		if (strlen($search)) $search = '#'.rawurlencode($search); 
	
		if (strrpos($targetURL,'?') !== false) { 
			list($targetURL,$extraParams) = explode('?',$targetURL); 
			$extraParams = explode('&',$extraParams); 
			foreach ($extraParam as $name => $value) { 
				$dataArray[$name] = $value; 
			} 
		} 
		if (is_array($dataArray)) $dataArray = array_merge($dataArray); 
	
		if ($pauseBefore !== false) { 
			$this->redirectByForm($targetURL.$search,$dataArray,true,false); 
		} 
		else { 
			$sep = '?'; 
			foreach ($dataArray as $name => $value) { 
				$targetURL .= $sep.rawurlencode($name).'='.rawurlencode($value); 
				$sep = '&'; 
			} 
			if (!headers_sent()) { 
				session_write_close(); 
				header('Location: '.$targetURL.$search); 
				exit(); 
			} 
			else { 
				echo "<script type=\"text/javascript\" language=\"javascript\">window.location.replace('".addslashes(htmlentities($targetURL.$search))."');</script>"; 
				session_write_close(); 
				exit; 
			} 
		} 
	} 
	
	/** 
	 * Outputs a form to use in request redirection. May submit automatically if browser allows. 
	 * 
	 * @access private 
	 * @param mixed $targetURL Complete URL to redirect to. 
	 * @param mixed $dataArray Optional array of name=>value parameters to write as input fields. 
	 * @param boolean $redirectByPost Optional flag. Useful for debugging - will force to redirect by manual form/POST instead of form/GET. 
	 * @param boolean $autoSubmit Optional flag. Adds an onload javascript directive to submit form automatically. 
	 * @return null Outputs an HTML form set and terminates script execution. 
	 */ 
	function redirectByForm($targetURL, $dataArray = false, $redirectByPost = true, $autoSubmit = true, $failStats = false, $showButton = true) { 
		if (!strlen($targetURL)) return false; 
		$method = (($redirectByPost === true) ? 'post' : 'get'); 
	
		$search = ''; 
		if (strrpos($targetURL,'#') !== false) { 
			list($targetURL,$search) = explode('#',$targetURL); 
		} 
		if (strlen($search)) $search = '#'.rawurlencode($search); 
	
		/*if (strrpos($targetURL,'?') !== false) { 
			list($targetURL,$extraParams) = explode('?',$targetURL); 
			$extraParamsA = explode('&',$extraParams);
			//foreach ($extraParam as $name => $value) { 
			//	$dataArray[$name] = $value; 
			//}
			$targetURL = $targetURL."?".$extraParams;
		}*/
		if (is_array($dataArray)) $dataArray = array_merge($dataArray);
		echo '<html><body'.(($autoSubmit == true) ? ' onload="document.forms[0].submit()"' : '').'><form method="'.$method.'"'. 
        ' action="'.htmlentities($targetURL.$search).'">';
		echo (($failStats===true) ? '<input type="hidden" name="fail" />' : '');
		$this->writeHiddenFormFields($dataArray);
		echo (($showButton===true) ? '<input type="submit" name="'.POSTBACK_PARAMETER_PREFIX.'submit" value="กำลังดำเนินการ คลิกที่นี่เพื่อไปยังหน้าต่อไป" />' : '');
		echo '</form></body></html>';
		session_write_close(); 
		exit; 
	} 
	/** 
	 * Outputs values from the dataArray as hidden form field elements. 
	 * 
	 * @param array $dataArray Array of name=>value pairs to output. Nested arrays are processed recursively. 
	 * @param mixed $clean_array Optional parameter used to trim off array elements that start with specified string. Ignored if false. 
	 * @param string $id_prefix Optional string to append to beginning of element names when used as element ID attribute 
	 * @return null Outputs hidden HTML <input> fields directly 
	 */ 
	private function writeHiddenFormFields($dataArray, $clean_array = false, $id_prefix = '') { 
		if (!is_array($dataArray)) return false; 
		if (!sizeof($dataArray)) return true; 
		if ($clean_array) { 
			$dataArray = $this->array_clean($dataArray, $clean_array); 
		} 
		foreach ($dataArray as $name => $value) { 
			// repeat any POST params verbatim (except for the login page's internal POST params) 
			// If this page is included by another page as a result of password timeout, 
			// we want to preserve the GET or POST in progress 
	
			// POST param name doesn't begin with $loginParamPrefix? Include it as a hidden form item. 
			if (is_array($value)) { 
				foreach ($value as $name2 => $value2) { 
					$this->writeHiddenFormFields(array("{$name}[{$name2}]" => $value2), $clean_array, $id_prefix); 
				} 
			} 
			else { 
				echo '<input type="hidden" name="'.htmlentities($name).'" id="'.htmlentities($id_prefix.preg_replace('/[^0-9a-z\-_]/i','_',$name)).'" value="'.htmlentities($value).'" />'."\n"; 
			} 
		} 
	} 
	
	private function intercept_request($targetURL, $returnURL) { 
		$targetURL = (($targetURL) ? $targetURL : 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']); 
		$returnURL = ((strlen($returnURL)) ? $returnURL : false); 
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
			$dataArray = $this->array_clean(array_merge($_GET, $_POST), POSTBACK_PARAMETER_PREFIX); 
			$dataArray[POSTBACK_PARAMETER_PREFIX.'return_method'] = 'post'; 
			if ($returnURL) $dataArray[POSTBACK_PARAMETER_PREFIX.'return'] = $returnURL; 
			if ( 
				strpos($_SERVER['CONTENT_TYPE'],'multipart/form-data') === 0 
				&& 
				isset($_FILES) 
				&& 
				sizeof($_FILES) 
			) { 
				//set error message to be displayed on the next page. 
				$dataArray[POSTBACK_PARAMETER_PREFIX.'error'] = 'Your login expired before the form could be submitted. After signing in you will need to upload the file again.'; 
			} 
			$this->redirectByForm($targetURL,$dataArray); 
		} else { 
			$dataArray = $_GET; 
			if ($returnURL) $dataArray[POSTBACK_PARAMETER_PREFIX.'return'] = $returnURL; 
			$this->redirect($targetURL,$dataArray); 
		} 
	} 
	
	private function array_clean ($array, $todelete = false, $caseSensitive = false) { 
		//removes elements from an array by comparing the value of each key 
		foreach($array as $key => $value) { 
			if(is_array($value)) { 
				$array[$key] = $this->array_clean($array[$key], $todelete, $caseSensitive); 
			} 
			else { 
				if($todelete) { 
					if($caseSensitive) { 
						if(strstr($key ,$todelete) !== false) { 
							unset($array[$key]); 
						} 
					} 
					else { 
						if(stristr($key, $todelete) !== false) { 
							unset($array[$key]); 
						} 
					} 
				} 
				elseif (empty($key)) { 
					unset($array[$key]); 
				} //END: if($todelete) 
			} //END: if(is_array($value)) 
		} //END: foreach 
		return $array; 
	}
}
?>