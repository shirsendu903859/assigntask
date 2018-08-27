<?php
/*
 * Random Number is Alpha-numeric Number 
 * Its Contain Length is 12
 * 
 */
if(!function_exists("random_number"))
{
	function random_number()
	{
		$rand = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz654654165416846845802132145649798"), 0, 6) . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz01237896544569871230"), 0, 6);
		$timestamp = time();
		$finalcode = $rand.$timestamp;
		return $finalcode;
	}
}


/*
 * make_diretory is Directory create function 
 * 
 */
if (!function_exists('make_diretory')) {
	function make_diretory($dirpath)
	{  
		if($dirpath != "" && !is_dir($dirpath))
		{
			if(mkdir($dirpath,0777,true))
			{return true;}else{return false;}
		}
		else{return false;}
	}
}
/*




/*
 * OTP is 4 Digit Number 
 * 
 */
if(!function_exists("OTP"))
{
	function OTP()
	{
		$rand = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
		return $rand;
	}
}

/*
 * sending mails
 *
 */


if (!function_exists('send_email')) {
	/*Function Declare*/
	function send_email($data = array())
	{ 
		if(!empty($data))
		{
			$CI = &get_instance();
			$CI->load->library('email');
			$CI->load->helper('email');
			$CI->email->set_mailtype("html");
		// check is email addrress valid or no
			if (valid_email($data['to'])){  
			// compose email
				$CI->email->from($data['from'], $data['title']);
				$CI->email->to($data['to']); 
				$CI->email->subject($data['subject']);
				$CI->email->message($data['message']);  
				// try send mail and if not able print debug
				if (!$CI->email->send()){return false;}else{return true;}
			}
			else{return false;}
		}
	}
}

	

if ( !class_exists('NumbersToWords') ){
  /**
  * NumbersToWords
  */
  class NumbersToWords{
    
    public static $hyphen      = '-';
    public static $conjunction = ' and ';
    public static $separator   = ', ';
    public static $negative    = 'negative ';
    public static $decimal     = ' point ';
    public static $dictionary  = array(
      0                   => 'zero',
      1                   => 'one',
      2                   => 'two',
      3                   => 'three',
      4                   => 'four',
      5                   => 'five',
      6                   => 'six',
      7                   => 'seven',
      8                   => 'eight',
      9                   => 'nine',
      10                  => 'ten',
      11                  => 'eleven',
      12                  => 'twelve',
      13                  => 'thirteen',
      14                  => 'fourteen',
      15                  => 'fifteen',
      16                  => 'sixteen',
      17                  => 'seventeen',
      18                  => 'eighteen',
      19                  => 'nineteen',
      20                  => 'twenty',
      30                  => 'thirty',
      40                  => 'fourty',
      50                  => 'fifty',
      60                  => 'sixty',
      70                  => 'seventy',
      80                  => 'eighty',
      90                  => 'ninety',
      100                 => 'hundred',
      1000                => 'thousand',
      1000000             => 'million',
      1000000000          => 'billion',
      1000000000000       => 'trillion',
      1000000000000000    => 'quadrillion',
      1000000000000000000 => 'quintillion'
    );
    public static function convert($number){
      if (!is_numeric($number) ) return false;
      $string = '';
      switch (true) {
        case $number < 21:
            $string = self::$dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = self::$dictionary[$tens];
            if ($units) {
                $string .= self::$hyphen . self::$dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = self::$dictionary[$hundreds] . ' ' . self::$dictionary[100];
            if ($remainder) {
                $string .= self::$conjunction . self::convert($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = self::convert($numBaseUnits) . ' ' . self::$dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? self::$conjunction : self::$separator;
                $string .= self::convert($remainder);
            }
            break;
      }
      return $string;
    }
  }//end class
}//end if
/**
 * usage:
 */
//echo NumbersToWords::convert(2839);

/*
 *
 *
Safe base64 encode and decode function for pursing in url
*/
if (!function_exists('safe_b64encode')){
			function safe_b64encode($string){
				$data = base64_encode($string);
				$data = str_replace(array('+','/','='),array('-','_',''),$data);
				return $data;
			}
		}		
if (!function_exists('safe_b64decode')){
			function safe_b64decode($string) {
				$data = str_replace(array('-','_'),array('+','/'),$string);
				$mod4 = strlen($data) % 4;
				if ($mod4) {
					$data .= substr('====', $mod4);
				}
				return base64_decode($data); 
			}
		}
/*
 *
 *
 */


/*
 * GET ADMIN DATA is used to fetch the admin data
 * 
 */
if(!function_exists("getadmindata")) {
	function getadmindata() {
		$CI = & get_instance();
		$CI->load->model('admin_model');
		$data = $CI->admin_model->getadmindetail();
		return $data;
	}
}

/*
 * GET SITE MANAGEMENT DATA is used to fetch the site management data
 * 
 */
if(!function_exists("getsitemanagementdata")) {
	function getsitemanagementdata() {
		$CI = & get_instance();
		$CI->load->model('admin_model');
		$data = $CI->admin_model->getsitemanagementdetail();
		return $data;
	}
}

/*
 * GET PARENT CATEGORY NAME is used to fetch the name of the parent category
 * 
 */
if(!function_exists("getparentcategoryname")) {
	function getparentcategoryname($parentid) {
		$CI = & get_instance();
		$data = $CI->db->get_where('categorymanagement', array('id'=>$parentid))->row_array();
		return $data['title'];	
	}
}


/*
 * GET CHILD CATEGORY is used to fetch the name of the parent category
 * 
 */
if(!function_exists("getchildcategory")) {
	function getchildcategory($id) {
		$CI = & get_instance();
		$data = $CI->db->get_where('categorymanagement', array('parent'=>$id))->result_array();
		return $data;	
	}
}

/*
 * GET SHIPPING BY PRODUCT ID is used to fetch the shipping charge of the product
 * 
 */
if(!function_exists("getshippingbyproductid")) {
	function getshippingbyproductid($id) {
		$CI = & get_instance();
		$data = $CI->db->get_where('productmanagement', array('productid'=>$id))->row_array();
		return $data['shipping'];	
	}
}

/*
 * GET DELIVERY BY PRODUCT ID is used to fetch the delivery charge of the product
 * 
 */
if(!function_exists("getdeliverybyproductid")) {
	function getdeliverybyproductid($id) {
		$CI = & get_instance();
		$data = $CI->db->get_where('productmanagement', array('productid'=>$id))->row_array();
		return $data['delivrey'];	
	}
}


/*
 * get seo data from page id
 * 
 */
if(!function_exists("getseobypageid")) {
	function getseobypageid($pageid) {
		$CI = & get_instance();
		$seo = $CI->db->get_where('seomanagement', array('pageid'=>$pageid))->row_array();
		return $seo;
	}
}


?>