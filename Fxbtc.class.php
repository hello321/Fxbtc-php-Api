<?php

/**
 * @package Fxbtc API
 * @author buluzhai
 * @version 0.1
 * @access public
 * @license http://www.opensource.org/licenses/LGPL-3.0
 */

class Fxbtc
{
	private $username;
	private $password;
	private $api_path;

	public function __construct($username, $password)
	{
		if (isset($password) && isset($username))
		{
			$this->username = $username;
			$this->password = $password;
	                $this->api_path='https://trade.fxbtc.com/api';
		} else
			die("NO USERNAME/PASSWORD");
	}
	/**
	 * Fxbtc::fxbtc_query()
	 *
	 * @param API Path $path
	 * @param POST Data $req
	 * @return Array containing data returned from the API path
	 */
	public function fxbtc_query($path, array $req = array())
	{
		// API settings
		$key = $this->key;
		$secret = $this->secret;
                if($path!='')$this->api_path='https://data.fxbtc.com/api';

		$mt = explode(' ', microtime());
		$req['nonce'] = $mt[1] . substr($mt[0], 2, 6);
		$req['username'] = $key;
		$req['password'] = $secret;

		$post_data = http_build_query($req, '', '&');

		static $ch = null;
		if (is_null($ch))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT,
				'Mozilla/4.0 (compatible; Fxbtc PHP client; ' . php_uname('s') . '; PHP/' .
				phpversion() . ')');
		}
		curl_setopt($ch, CURLOPT_URL, $this->api_path . $path);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

		// run the query
		$res = curl_exec($ch);
		if ($res === false)
			throw new Exception('Could not get reply: ' . curl_error($ch));
		$dec = json_decode($res, true);
		if (!$dec)
			throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
		return $dec;
	}
	/**
	 * Fxbtc::ticker()
	 * Returns current ticker from MtGOX
	 * @return $ticker
	 */
	function ticker($pair = "btc_cny") {
		$ticker = $this->fxbtc_query('?op=query_ticker&symbol='.$pair);
		$this->ticker = $ticker; // Another variable to contain it.
		return $ticker;
	}
	/**
	 * Fxbtc::depth()
	 * Returns market depth from MtGOX
	 * @return $ticker
	 */
	function depth($pair = "btc_cny") {
		$depth= $this->fxbtc_query('?op=query_depth&symbol='.$pair);
		return $depth;
	}
	/**
	 * Fxbtc::last_trade()
	 * Returns market depth from MtGOX
	 * @return $ticker
	 */
	function last_trade($pair = "btc_cny") {
		$depth= $this->fxbtc_query('?op=query_last_trades&symbol='.$pair.'&count=100');
		return $depth;
	}
         /**
	 * Fxbtc::history_trade()
	 * Returns market depth from MtGOX
	 * @return $ticker
	 */
	function history_trade($pair = "btc_cny") {
		$depth= $this->fxbtc_query('?op=query_history_trades&symbol='.$pair.'&since=0');
		return $depth;
	}
         /**
	 * Fxbtc::get_token()
	 * Returns token
	 * @return $token
	 */
	function get_token() {
		$token= $this->fxbtc_query('',array("op"=>'get_token'));
		return $token;
	}
        /**
	 * Fxbtc::check_token()
	 * Returns token
	 * @return $token
	 */
	function check_token($token) {
		$token= $this->fxbtc_query('',array("op"=>'check_token',"token"=>$token));
		return $token;
	}
        /**
	 * Fxbtc::get_info()
	 * Returns token
	 * @return $token
	 */
	function get_info($token) {
		$token= $this->fxbtc_query('',array("op"=>'get_info',"token"=>$token));
		return $token;
	}


}
