<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function generate_navigation($HTML, $TAG = 'h2'): ?string
{
    if (!$HTML) return $HTML;
    $DOM = new DOMDocument();
    $DOM->encoding = 'UTF-8';
    $DOM->loadHTML(mb_convert_encoding($HTML, 'HTML-ENTITIES', 'UTF-8'));
    $navigation = '<div class="entry-content"><h6 class="title">İçindekiler</h6><ol class="list-group list-group-numbered">';
    $tagStatus = 0;

    foreach ($DOM->getElementsByTagName($TAG) as $element) {
        $tagStatus = 1;
        if ($element->textContent)
            $navigation .= '<li><a href="#' . Str::slug($element->textContent) . '">' . $element->textContent . '</a>';
    }

    if ($tagStatus) $navigation .= '</li>';

    return $navigation . '</ol></div>';
}

function generate_content($HTML)
{
    return $HTML ? preg_replace_callback("#<(h[1-6])>(.*?)</\\1>#", function ($match) {
        list($_unused, $h2, $title) = $match;
        $id = Str::slug($title);
        return "<$h2 id='$id'>$title</$h2>";
    }, $HTML) : $HTML;
}

// Site logo url
function site_logo()
{
    return url(config("settings.general.site_logo"));
}

function site_dark_logo()
{
    return url(config("settings.general.site_dark_logo"));
}

// Site favicon url
function site_favicon()
{
    return url(config("settings.general.site_favicon"));
}

function translations($json)
{
    if (!file_exists($json)) {
        return [];
    }
    return json_decode(file_get_contents($json), true);
}

function getBrowser($user_agent)
{
    $t = strtolower($user_agent);
    $t = " " . $t;
    if (strpos($t, 'opera') || strpos($t, 'opr/')) return 'Opera';
    elseif (strpos($t, 'edge')) return 'Edge';
    elseif (strpos($t, 'chrome')) return 'Chrome';
    elseif (strpos($t, 'safari')) return 'Safari';
    elseif (strpos($t, 'firefox')) return 'Firefox';
    elseif (strpos($t, 'msie') || strpos($t, 'trident/7')) return 'Internet Explorer';
    return 'Unkown';
}

function getOS($user_agent = null)
{
    if (!isset($user_agent) && isset($_SERVER['HTTP_USER_AGENT'])) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    }

    // https://stackoverflow.com/questions/18070154/get-operating-system-info-with-php
    $os_array = [
        'windows nt 10' => 'Windows 10',
        'windows nt 6.3' => 'Windows 8.1',
        'windows nt 6.2' => 'Windows 8',
        'windows nt 6.1|windows nt 7.0' => 'Windows 7',
        'windows nt 6.0' => 'Windows Vista',
        'windows nt 5.2' => 'Windows Server 2003/XP x64',
        'windows nt 5.1' => 'Windows XP',
        'windows xp' => 'Windows XP',
        'windows nt 5.0|windows nt5.1|windows 2000' => 'Windows 2000',
        'windows me' => 'Windows ME',
        'windows nt 4.0|winnt4.0' => 'Windows NT',
        'windows ce' => 'Windows CE',
        'windows 98|win98' => 'Windows 98',
        'windows 95|win95' => 'Windows 95',
        'win16' => 'Windows 3.11',
        'mac os x 10.1[^0-9]' => 'Mac OS X Puma',
        'macintosh|mac os x' => 'Mac OS X',
        'mac_powerpc' => 'Mac OS 9',
        'ubuntu' => 'Linux - Ubuntu',
        'iphone' => 'iPhone',
        'ipod' => 'iPod',
        'ipad' => 'iPad',
        'android' => 'Android',
        'blackberry' => 'BlackBerry',
        'webos' => 'Mobile',
        'linux' => 'Linux',

        '(media center pc).([0-9]{1,2}\.[0-9]{1,2})' => 'Windows Media Center',
        '(win)([0-9]{1,2}\.[0-9x]{1,2})' => 'Windows',
        '(win)([0-9]{2})' => 'Windows',
        '(windows)([0-9x]{2})' => 'Windows',

        // Doesn't seem like these are necessary...not totally sure though..
        //'(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'Windows NT',
        //'(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})'=>'Windows NT', // fix by bg

        'Win 9x 4.90' => 'Windows ME',
        '(windows)([0-9]{1,2}\.[0-9]{1,2})' => 'Windows',
        'win32' => 'Windows',
        '(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})' => 'Java',
        '(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}' => 'Solaris',
        'dos x86' => 'DOS',
        'Mac OS X' => 'Mac OS X',
        'Mac_PowerPC' => 'Macintosh PowerPC',
        '(mac|Macintosh)' => 'Mac OS',
        '(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}' => 'SunOS',
        '(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}' => 'BeOS',
        '(risc os)([0-9]{1,2}\.[0-9]{1,2})' => 'RISC OS',
        'unix' => 'Unix',
        'os/2' => 'OS/2',
        'freebsd' => 'FreeBSD',
        'openbsd' => 'OpenBSD',
        'netbsd' => 'NetBSD',
        'irix' => 'IRIX',
        'plan9' => 'Plan9',
        'osf' => 'OSF',
        'aix' => 'AIX',
        'GNU Hurd' => 'GNU Hurd',
        '(fedora)' => 'Linux - Fedora',
        '(kubuntu)' => 'Linux - Kubuntu',
        '(ubuntu)' => 'Linux - Ubuntu',
        '(debian)' => 'Linux - Debian',
        '(CentOS)' => 'Linux - CentOS',
        '(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)' => 'Linux - Mandriva',
        '(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)' => 'Linux - SUSE',
        '(Dropline)' => 'Linux - Slackware (Dropline GNOME)',
        '(ASPLinux)' => 'Linux - ASPLinux',
        '(Red Hat)' => 'Linux - Red Hat',
        // Loads of Linux machines will be detected as unix.
        // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
        //'X11'=>'Unix',
        '(linux)' => 'Linux',
        '(amigaos)([0-9]{1,2}\.[0-9]{1,2})' => 'AmigaOS',
        'amiga-aweb' => 'AmigaOS',
        'amiga' => 'Amiga',
        'AvantGo' => 'PalmOS',
        //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}'=>'Linux',
        //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}'=>'Linux',
        //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})'=>'Linux',
        '[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}' => 'Linux',
        '(webtv)/([0-9]{1,2}\.[0-9]{1,2})' => 'WebTV',
        'Dreamcast' => 'Dreamcast OS',
        'GetRight' => 'Windows',
        'go!zilla' => 'Windows',
        'gozilla' => 'Windows',
        'gulliver' => 'Windows',
        'ia archiver' => 'Windows',
        'NetPositive' => 'Windows',
        'mass downloader' => 'Windows',
        'microsoft' => 'Windows',
        'offline explorer' => 'Windows',
        'teleport' => 'Windows',
        'web downloader' => 'Windows',
        'webcapture' => 'Windows',
        'webcollage' => 'Windows',
        'webcopier' => 'Windows',
        'webstripper' => 'Windows',
        'webzip' => 'Windows',
        'wget' => 'Windows',
        'Java' => 'Unknown',
        'flashget' => 'Windows',

        // delete next line if the script show not the right OS
        //'(PHP)/([0-9]{1,2}.[0-9]{1,2})'=>'PHP',
        'MS FrontPage' => 'Windows',
        '(msproxy)/([0-9]{1,2}.[0-9]{1,2})' => 'Windows',
        '(msie)([0-9]{1,2}.[0-9]{1,2})' => 'Windows',
        'libwww-perl' => 'Unix',
        'UP.Browser' => 'Windows CE',
        'NetAnts' => 'Windows',
    ];

    // https://github.com/ahmad-sa3d/php-useragent/blob/master/core/user_agent.php
    $arch_regex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
    $arch = preg_match($arch_regex, $user_agent) ? '64' : '32';

    foreach ($os_array as $regex => $value) {
        if (preg_match('{\b(' . $regex . ')\b}i', $user_agent)) {
            return $value . ' x' . $arch;
        }
    }

    return 'Unknown';
}

function saveImageUrl($url, $name, $path)
{
    try {
        $temp = tempnam(sys_get_temp_dir(), 'TMP_');
        file_put_contents($temp, file_get_contents($url));

        $image_resolution = file_get_contents($temp);
        $size = getimagesize($temp);
        if ($size) {
            $extension = image_type_to_extension($size['2']);
            $mime_type = $size['mime'];
        } else {
            $extension = Str::after(get_headers($url, 1)['Content-Type'], '/');
            $extension = str_replace('svg+xml', 'svg', $extension);
            $mime_type = get_headers($url, 1)['Content-Type'];
        }
        if ($extension[0] != '.') {
            $extension = '.' . $extension;
        }

        $file_name = $path . $name . $extension;
        Storage::disk('public')->put($file_name, $image_resolution);
        $attributes = [
            'author_id' => 2,
            'path' => $file_name,
            'full_name' => Str::afterLast($file_name, '/'),
            'slug' => Str::before(Str::afterLast($file_name, '/'), '.'),
            'type' => 'default',
            'size' => 0,
            'resolution' => $size ? $size[0] . 'x' . $size[1] : 'resolution',
            'mime_type' => $mime_type
        ];
        $data = \App\Models\File::query()->create($attributes);
        Storage::disk('public')->put($file_name, $image_resolution);

        return $data->id;
    } catch (Exception $e) {
        echo $e->getMessage();
        return false;
    }
}

function newSaveImage($name, $path)
{
    try {
        $full_path = storage_path('app/public') . '' . $path . '' . $name;
        $full_name = $path . '' . $name;
        $size = getimagesize($full_path);
        $mime_type = 'video';
        if ($size) {
            $mime_type = $size['mime'];
        }
        $attributes = [
            'author_id' => 2,
            'path' => $full_name,
            'full_name' => Str::afterLast($name, '/'),
            'slug' => Str::before(Str::afterLast($name, '/'), '.'),
            'type' => 'default',
            'size' => 0,
            'resolution' => $size ? $size[0] . 'x' . $size[1] : 'resolution',
            'mime_type' => $mime_type
        ];
        $data = \App\Models\File::query()->create($attributes);

//        echo $data->id;

        return $data->id;
    } catch (Exception $e) {
//        echo $e->getMessage();
        return false;
    }
}


function imagex($url, $params = [], $auto = true)
{
    return $url;
//    if ($auto) {
//        $params = array_merge(['auto' => 'format,compress', 'lossless' => "true"], $params);
//    }
    return ((string)str_replace('%2C', ',', imgix('astrotomic')->createURL($url, $params)));

}

function calculateDistanceBetweenTwoAddresses($lat1, $lng1, $lat2, $lng2)
{
    $lat1 = deg2rad($lat1);
    $lng1 = deg2rad($lng1);

    $lat2 = deg2rad($lat2);
    $lng2 = deg2rad($lng2);

    $delta_lat = $lat2 - $lat1;
    $delta_lng = $lng2 - $lng1;

    $hav_lat = (sin($delta_lat / 2)) ** 2;
    $hav_lng = (sin($delta_lng / 2)) ** 2;

    $distance = 2 * asin(sqrt($hav_lat + cos($lat1) * cos($lat2) * $hav_lng));

    $distance = 6371 * $distance;
    // If you want calculate the distance in miles instead of kilometers, replace 6371 with 3959.

    return $distance;
}

function statusArray()
{
    return [
        true => 'Aktif',
        false => 'Pasif',
    ];
}

function pageStatusArray()
{
    return [
        1 => 'Taslak',
        2 => 'İncelemede',
        3 => 'Yayımlanmış',
    ];
}

function postStatusArray()
{
    return [
        1 => 'Taslak',
        2 => 'Yayımlanmış',
        3 => 'Gizli',
        4 => 'Zamanlanmış',
        5 => 'İnceleme Bekliyor',
        6 => 'Çöp'
    ];
}

function countryArray()
{

    $countries = \App\Models\Country::all();
    $formatCountries = [];
    foreach ($countries as $country) {
        $formatCountries[$country->id] = $country->name;
    }

    return $formatCountries;
}

function pageArray()
{

    $pages = \App\Models\Page::query()->orWhere('parent_id', 0)->orWhere('parent_id', null)->orWhere('parent_id', '')->get();
    $formatPages = [];
    foreach ($pages as $page) {
        $formatPages[$page->id] = $page->title;
    }

    return $formatPages;
}
