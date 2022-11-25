<?php
// !!! Author : Truong Quoc Bao
// !!! Date : 2022-11-20
// !!! Description : Utils for laravel project

use App\Models\Config;
use App\Models\Notice;

function get_config($key, $default = '')
{
    return Config::firstOrCreate(['key' => $key], ['value' => $default])?->value;
}

function get_notice($key, $default = '')
{
    return Notice::firstOrCreate(['key' => $key], ['value' => $default])?->value;
}

function settings($key = null)
{
    $settings = (get_config('settings'));
    if ($key) {
        return $settings->$key ?? null;
    }
    return $settings;
}

function script_header()
{
    $script = get_config('script_header', '');
    if ($script) {
        return base64_decode($script);
    }
}

function script_footer()
{
    $script = get_config('script_footer', '');
    if ($script) {
        return base64_decode($script);
    }
}

// extra functions
function vnd_to_usd($number, $format = false, $prefix = '$')
{
    $number = $number / 24000;
    if ($format) {
        return $prefix . number_format($number, 2, '.', ',');
    }
    return $number;
}

function domain()
{
    return $_SERVER['HTTP_HOST'];
}

function get_date()
{
    return date('Y-m-d H:i:s');
}

function get_country_name($code, $lng = 'vi_VN')
{
    return Locale::getDisplayRegion('-' . strtoupper($code), $lng);
}

function check_recaptcha($response)
{
    $secret = $_ENV['G_RECAPTCHA_SECRET'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret'    => $secret,
        'response'  => $response
    );
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        return false;
    } else {
        $json = json_decode($result);
        if ($json->success) {
            return true;
        } else {
            return false;
        }
    }
}

function hideUsername($username)
{
    $username = substr_replace($username, str_repeat('*', 5), 3, 5);
    return $username;
}

function sendMessageTelegram($chat_id, $message)
{
    $token = env('TELEGRAM_BOT_TOKEN', '');
    $url = 'https://api.telegram.org/bot' . $token . '/sendMessage';
    $data = array(
        'chat_id' => $chat_id,
        'text' => $message
    );
    // curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($server_output, true);
    if (isset($result['ok']) && $result['ok'] == true) {
        return true;
    }
    return false;
}

function parse_order_id($des, $MEMO_PREFIX)
{
    //global $MEMO_PREFIX;
    $re = '/' . $MEMO_PREFIX . '\w+/im';
    preg_match_all($re, $des, $matches, PREG_SET_ORDER, 0);
    if (count($matches) == 0)
        return null;
    // Print the entire match result
    $orderCode = $matches[0][0];
    $prefixLength = strlen($MEMO_PREFIX);
    $orderId = intval(substr($orderCode, $prefixLength));
    return $orderId;
}

function parse_order_name($des, $MEMO_PREFIX)
{
    //global $MEMO_PREFIX;
    $re = '/' . $MEMO_PREFIX . '\w+/im';
    preg_match_all($re, $des, $matches, PREG_SET_ORDER, 0);
    if (count($matches) == 0)
        return null;
    // Print the entire match result
    $orderCode = $matches[0][0];
    $prefixLength = strlen($MEMO_PREFIX);
    $orderId = substr($orderCode, $prefixLength);
    return $orderId;
}

function get_leveL_name($level)
{
    switch ($level) {
        case 'member':
            return 'Thành Viên';
        case 'collaborators':
            return 'Cộng Tác Viên';
        case 'agency':
            return 'Đại Lý';
        case 'distributor':
            return 'Nhà Phân Phối';
        default:
            return 'Unknown';
    }
}

function getHtmlStatus($status, $type = 'transaction')
{
    // transactions
    switch ($status) {
        case 'pending':
            return '<span class="badge bg-warning w-100" style="font-size: 0.8rem">Chờ xử lý</span>';
        case 'success':
            return '<span class="badge bg-success w-100" style="font-size: 0.8rem">Thành công</span>';
        case 'canceled':
            return '<span class="badge  w-100" style="font-size: 0.8rem; background-color: #6c5ce7">Đã bị huỷ</span>';
        case 'failed':
            return '<span class="badge bg-danger  w-100" style="font-size: 0.8rem">Thất bại</span>';
        default:
            return '<span class="badge  w-100" style="font-size: 0.8rem; background-color: #2d3436">Unkown</span>';
    }
}

function randomString($length, $uppercase = false)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $uppercase ? strtoupper($randomString) : $randomString;
}

function get_time_ago($timestamp)
{
    $time =  strtotime($timestamp) ? strtotime($timestamp) : $timestamp;
    // $time  = time() - $time_ago;

    $time_difference = time() - $time;

    if ($time_difference < 1) {
        return 'vài giây trước';
    }
    $condition = array(
        12 * 30 * 24 * 60 * 60 =>  'năm',
        30 * 24 * 60 * 60       =>  'tháng',
        24 * 60 * 60            =>  'ngày',
        60 * 60                 =>  'giờ',
        60                      =>  'phút',
        1                       =>  'giây'
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return $t . ' ' . $str . ' trước';
        }
    }
}

function convert_user_date($date, $userTimeZone = 'Asia/Ho_Chi_Minh', $serverTimeZone = 'UTC', $format = 'Y-m-d H:i:s')
{
    try {
        if (is_numeric($date)) {
            $date = date('Y-m-d H:i:s', $date);
        }
        $dateTime = new \DateTime($date, new \DateTimeZone($serverTimeZone));
        $dateTime->setTimezone(new \DateTimeZone($userTimeZone));
        return $dateTime->format($format);
    } catch (\Exception $e) {
        return $date;
    }
}

function convert_server_date($date, $userTimeZone = 'Asia/Ho_Chi_Minh', $serverTimeZone = 'UTC', $format = 'Y-m-d H:i:s')
{
    try {
        if (is_numeric($date)) {
            $date = date('Y-m-d H:i:s', $date);
        }
        $dateTime = new \DateTime($date, new \DateTimeZone($userTimeZone));
        $dateTime->setTimezone(new \DateTimeZone($serverTimeZone));
        return $dateTime->format($format);
    } catch (\Exception $e) {
        return $date;
    }
}

function get_day_count($end)
{
    $startTimeStamp = time();
    $endTimeStamp =  strtotime($end) ? strtotime($end) : $end;

    $timeDiff = abs($endTimeStamp - $startTimeStamp);

    $numberDays = $timeDiff / 86400;  // 86400 seconds in one day

    // and you might want to convert to integer
    $numberDays = intval($numberDays);

    return $numberDays;
}

function get_hours_count($end, $format = '%dd %hh')
{
    $end = !strtotime($end) ? date('Y-m-d H:i:s', $end) : $end;
    $date1 = new \DateTime($end);
    $date2 = new \DateTime(date('Y-m-d H:i:s'));
    $diff = $date2->diff($date1);
    $diffDays = $diff->format($format);
    return $diffDays;
}

function curl($url, $data_curl = false, $header_curl = false, $header = false)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 40000);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.5 Safari/533.2");
    // curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.80 Safari/537.36");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    if ($header) {
        curl_setopt($ch, CURLOPT_HEADER, $header);
    }
    if ($header_curl) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_curl);
    }
    if ($data_curl) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_curl);
    }
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    $output = curl_exec($ch);
    return $output;
}
