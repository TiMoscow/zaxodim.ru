<?php
/**
 * @package     Joomla.site
 * @subpackage  Plugin.system.hwd_updateauthentication
 *
 * @copyright   Copyright (C) 2013 Highwood Design Limited. All rights reserved.
 * @license     GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @author      Dave Horsfall
 */

defined('_JEXEC') or die;

class PlgSystemHWD_UpdateAuthentication extends JPlugin
{
	/**
	 * Plugin that manipulates HTML in the update manager for HWD extensions.
	 *
         * @access  public
	 * @return  void
	 */
	public function onAfterRender()
	{
                // Initialise variables.
		$app = JFactory::getApplication();
                $doc = JFactory::getDocument();

		// Check that we are in the admin application.
		if ($app->isAdmin())
		{
                        if ($app->input->get('option') == 'com_installer' && $app->input->get('view') == 'update') 
                        {
                                // Get the response body.
                                $body = $app->getBody();
                                
                                // Simple performance check to determine whether plugin should process further.
                                if (strpos($body, 'http://hwdmediashare.co.uk/authorise-your-website-for-updates') === false)
                                {
                                        //return true;
                                }

                                if ($this->checkStatus()) 
                                {
                                        $row = JTable::getInstance('extension');
                                        $eid = $row->find(array('type' => 'plugin', 'element' => 'hwd_updateauthentication'));
                                        $link = $eid ? 'index.php?option=com_plugins&task=plugin.edit&extension_id=' . $eid : 'http://hwdmediashare.co.uk/authorise-your-website-for-updates';                                     
                                        $button = '<a class="btn btn-success" href="' . JRoute::_($link) . '" style="margin:5px 0;">Authorised</a>';
                                }
                                else
                                {
                                        $row = JTable::getInstance('extension');
                                        $eid = $row->find(array('type' => 'plugin', 'element' => 'hwd_updateauthentication'));
                                        $link = $eid ? 'index.php?option=com_plugins&task=plugin.edit&extension_id=' . $eid : 'http://hwdmediashare.co.uk/authorise-your-website-for-updates'; 
                                        $button = '<br /><p><a class="btn btn-large btn-danger" href="' . JRoute::_($link) . '">Update Not Authorised</a></p>';
                                }

                                // Get the response body.
                                $body = $app->getBody();

                                // Match any HWD links.
                                $pattern = "/<a\\s+href=\"http\:\/\/hwdmediashare\.co\.uk\/authorise-your-website-for-updates\"\\s+[^>]+>[^<]+<\/a>/";

                                $app->setBody(preg_replace($pattern, $button, $body));  
                        }

		}

		return true;
	}
        
	/**
	 * Method to check current authorisation status.
	 *
         * @access  public
	 * @return  boolean
	 */
	public function checkStatus()
	{
                // Initialise variables.
		$app = JFactory::getApplication();
                $http = JHttpFactory::getHttp();

                // Check credentials have been entered.
                if (!$this->params->get('username') || !$this->params->get('password'))
                {
                        return false;
                }
                
                // Define cookie location.
                if (is_writable(JPath::clean(session_save_path() . '/hwd_' . md5(JURI::root()))))
                {
                        $cookie = JPath::clean(session_save_path() . '/hwd_' . md5(JURI::root()));
                } 
                elseif (is_writable(JPath::clean(sys_get_temp_dir() . '/hwd_' . md5(JURI::root()))))
                {
                        $cookie = JPath::clean(sys_get_temp_dir() . '/hwd_' . md5(JURI::root()));
                }
                else
                {
                        $cookie = JPath::clean($app->getCfg('tmp_path') . '/hwd_' . md5(JURI::root()));
                }                
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://hwdmediashare.co.uk/downloads?task=downloads.status');
                curl_setopt($ch, CURLOPT_USERAGENT, 'JB/1.0');                
                curl_setopt($ch, CURLOPT_REFERER, 'http://hwdmediashare.co.uk');       
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);                
                curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $buffer = curl_exec($ch);

                // Display curl error.
                if ($buffer === false) 
                {                                    
                        $this->setError('Curl error #'.curl_errno($curl_handle).': ' . curl_error($curl_handle));
                        return false;
                }

                curl_close($ch);

                $response = $this->getResponse($buffer);

                // Decode response.
                $result = json_decode($response->body, true);

                if (!is_array($result) || !isset($result['status']))
                {
                        return false;
                }

                if ($result['status'] == 'success')
                {
                        return true;
                }
                else
                {
                        if ($this->authorise())
                        {
                                return true;
                        }
                        else 
                        {
                                return false;
                        }
                }     
	}  
        
	/**
	 * Method to attempt login and authorisation.
         * 
         * @access  public
	 * @return  void
	 */
	public function authorise()
	{
                // Initialise variables.
		$app = JFactory::getApplication();
                $http = JHttpFactory::getHttp();
                
                // Define cookie location.      
                if (is_writable(JPath::clean(session_save_path() . '/hwd_' . md5(JURI::root()))))
                {
                        $cookie = JPath::clean(session_save_path() . '/hwd_' . md5(JURI::root()));
                } 
                elseif (is_writable(JPath::clean(sys_get_temp_dir() . '/hwd_' . md5(JURI::root()))))
                {
                        $cookie = JPath::clean(sys_get_temp_dir() . '/hwd_' . md5(JURI::root()));
                }
                else
                {
                        $cookie = JPath::clean($app->getCfg('tmp_path') . '/hwd_' . md5(JURI::root()));
                }

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://hwdmediashare.co.uk/index.php?option=com_users&view=login');
                curl_setopt($ch, CURLOPT_USERAGENT, 'JB/1.0');                
                curl_setopt($ch, CURLOPT_REFERER, 'http://hwdmediashare.co.uk');       
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);                
                curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $buffer = curl_exec($ch);

                // Display curl error.
                if ($buffer === false) 
                {                                    
                        $this->setError('Curl error #'.curl_errno($curl_handle).': ' . curl_error($curl_handle));
                        return false;
                }

                curl_close($ch);

                $response = $this->getResponse($buffer);
                
                // Get session token.
                $pattern = "/input type=\"hidden\" name=\"(.*?)\" value=\"1\"/";
                $result = preg_match($pattern, $response->body, $matches);
                $code = preg_replace('/[^0-9a-zA-Z]/', '', $matches[1]);
                if ($code)
                {
                        // Attempt login.
                        $headers = array(
                                     'username' => $this->params->get('username'),
                                     'password' => $this->params->get('password'),
                                     $code => '1'
                                   );

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://hwdmediashare.co.uk/index.php?option=com_users&task=user.login');
                        curl_setopt($ch, CURLOPT_USERAGENT, 'JB/1.0');                
                        curl_setopt($ch, CURLOPT_REFERER, 'http://hwdmediashare.co.uk');       
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);                
                        curl_setopt($ch, CURLOPT_POST, TRUE);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $headers);
                        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
                        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                        $buffer = curl_exec($ch);

                        // Display curl error.
                        if ($buffer === false) 
                        {                                    
                                $this->setError('Curl error #'.curl_errno($curl_handle).': ' . curl_error($curl_handle));
                                return false;
                        }

                        curl_close($ch);

                        // Verify login.
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'http://hwdmediashare.co.uk/downloads?task=downloads.status');
                        curl_setopt($ch, CURLOPT_USERAGENT, 'JB/1.0');                
                        curl_setopt($ch, CURLOPT_REFERER, 'http://hwdmediashare.co.uk');       
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);                
                        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
                        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                        $buffer = curl_exec($ch);

                        // Display curl error.
                        if ($buffer === false) 
                        {                                    
                                $this->setError('Curl error #'.curl_errno($curl_handle).': ' . curl_error($curl_handle));
                                return false;
                        }

                        curl_close($ch);

                        $response = $this->getResponse($buffer);

                        // Decode response.
                        $result = json_decode($response->body, true);

                        if (!is_array($result) || !isset($result['status']))
                        {
                                return false;
                        }

                        if ($result['status'] == 'success')
                        {
                                return true;
                        }
                }

                $app->enqueueMessage(JText::_('The login attempt at HWDMediaShare.co.uk failed, please check your credentials are correct.'));
                return false;   
	}        
        
	/**
	 * Method to manipulate extension download URL.
         * 
         * @access  public
	 * @param   string  $url      URL of file to download
	 * @param   array   $headers  Headers
	 * @return  boolean
	 */
	public function onInstallerBeforePackageDownload(&$url, $headers)
	{
                // Initialise variables.
		$app = JFactory::getApplication();
                $doc = JFactory::getDocument();
		$config = JFactory::getConfig();

		// Check that we are in the admin application.
		if ($app->isAdmin())
		{
                        $host = parse_url($url,  PHP_URL_HOST);
                        if ($host == 'hwdmediashare.co.uk') 
                        {
                                // Define cookie location.      
                                if (is_writable(JPath::clean(session_save_path() . '/hwd_' . md5(JURI::root()))))
                                {
                                        $cookie = JPath::clean(session_save_path() . '/hwd_' . md5(JURI::root()));
                                } 
                                elseif (is_writable(JPath::clean(sys_get_temp_dir() . '/hwd_' . md5(JURI::root()))))
                                {
                                        $cookie = JPath::clean(sys_get_temp_dir() . '/hwd_' . md5(JURI::root()));
                                }
                                else
                                {
                                        $cookie = JPath::clean($app->getCfg('tmp_path') . '/hwd_' . md5(JURI::root()));
                                }
                                                                
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $url);
                                curl_setopt($ch, CURLOPT_USERAGENT, 'JB/1.0');                
                                curl_setopt($ch, CURLOPT_REFERER, 'http://hwdmediashare.co.uk');       
                                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);                
                                curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
                                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                                $buffer = curl_exec($ch);

                                // Display curl error.
                                if ($buffer === false) 
                                {                                    
                                        $this->setError('Curl error #'.curl_errno($curl_handle).': ' . curl_error($curl_handle));
                                        return false;
                                }

                                curl_close($ch);

                                $response = $this->getResponse($buffer);

                                // Decode response.
                                $result = json_decode($response->body, true);

                                if (!is_array($result) || !isset($result['status']) || !isset($result['data']))
                                {
                                        $this->setError(JText::_('PLG_SYSTEM_HWD_UPDATEAUTHENTICATION_ERROR_NOT_VALID_RESPONSE'));
                                        return false;
                                }

                                if ($result['status'] == 'success')
                                {
                                        // Pull parameters from the url.
                                        $query = parse_url($url, PHP_URL_QUERY);
                                        parse_str($query, $variables);

                                        if (isset($variables['id']))
                                        {
                                                $url = 'http://hwdmediashare.co.uk/downloads?task=downloads.push&id=' . (int) $variables['id'] . '&token=' . $result['data']['token'];     
                                        }
                                }
                                elseif ($result['status'] == 'fail' && isset($result['message']))
                                {
					$app->enqueueMessage($result['message'], 'error');
                                        $this->setError($result['message']);
                                        return false;
                                }     
                                else
                                {
                                        $this->setError(JText::_('PLG_SYSTEM_HWD_UPDATEAUTHENTICATION_ERROR_NOT_VALID_RESPONSE'));
                                        return false;
                                }                             
                        }

		}

		return true;                
        }   
        
	/**
	 * Method to get a response object from a server response.
	 *
         * @access  protected
	 * @param   string     $content  The complete server response, including headers
	 *                               as a string if the response has no errors.
	 * @param   array      $info     The cURL request information.
	 * @return  JHttpResponse
	 * @throws  UnexpectedValueException
	 */
	protected function getResponse($content, $info = array())
	{
		// Create the response object.
		$return = new JHttpResponse;

		// Get the number of redirects that occurred.
		$redirects = isset($info['redirect_count']) ? $info['redirect_count'] : 0;

		/*
		 * Split the response into headers and body. If cURL encountered redirects, the headers for the redirected requests will
		 * also be included. So we split the response into header + body + the number of redirects and only use the last two
		 * sections which should be the last set of headers and the actual body.
		 */
		$response = explode("\r\n\r\n", $content, 2 + $redirects);

		// Set the body for the response.
		$return->body = array_pop($response);

		// Get the last set of response headers as an array.
		$headers = explode("\r\n", array_pop($response));

		// Get the response code from the first offset of the response headers.
		preg_match('/[0-9]{3}/', array_shift($headers), $matches);

		$code = count($matches) ? $matches[0] : null;

		if (is_numeric($code))
		{
			$return->code = (int) $code;
		}

		// No valid response code was detected.
		else
		{
			throw new UnexpectedValueException('No HTTP response code found.');
		}

		// Add the response headers to the response object.
		foreach ($headers as $header)
		{
			$pos = strpos($header, ':');
			$return->headers[trim(substr($header, 0, $pos))] = trim(substr($header, ($pos + 1)));
		}

		return $return;
	}
}
