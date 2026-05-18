<?php
Cache::config('default', array('engine' => 'File'));
App::build(array(
  'Controller' => array(
    ROOT . DS . APP_DIR . DS . 'Controller' . DS . 'Api' . DS
  )
));

Configure::write('Dispatcher.filters', array(
  'AssetDispatcher',
  'CacheDispatcher'
));

App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
  'engine' => 'File',
  'types' => array('notice', 'info', 'debug'),
  'file' => 'debug',
));

CakeLog::config('error', array(
  'engine' => 'File',
  'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
  'file' => 'error',
));
 
function d ($code) {
  var_dump($code);
}

function slug ($string) {
  return strtolower(str_replace(' ', '-', $string));
}

function slug2 ($string) {
  return strtolower(str_replace(' ', '_', $string));
}

function token() {
  return strval(bin2hex(openssl_random_pseudo_bytes(16)));
}

function fdate($date, $format = 'm/d/Y') {
  if (!empty($date))
    return date($format, strtotime($date));
  else
    return null;
}

function fnumber($number, $decimal = 2) {
  if (!empty($number))
    return number_format($number, $decimal);
  else
    return 0.00;
}


function properCase($string) {
  return ucwords(strtolower($string));
}

function lowerCase($string) {
  return strtolower($string);
}

function branchId() {
  return AuthComponent::user('branchId');
}

function session($code) {
  return AuthComponent::user($code);
}

 function ordinalSuffix( $n )
{
  return date('S',mktime(1,1,1,1,( (($n>=10)+($n>=20)+($n==0))*10 + $n%10) ));
}

function hasAccess($code = null, $user) {
  $result = false;
  if ($user['User']['roleId'] == 1) {
    $result = true;
  } 
  if (isset($user['UserPermission'])) {
    if (in_array($code, $user['UserPermission'])) {
      $result = true;
    }
  }  
  return $result;
}

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


  function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
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

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;


}
