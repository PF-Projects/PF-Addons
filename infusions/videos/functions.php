<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| https://www.phpfusion.com/
+--------------------------------------------------------+
| Filename: functions.php
| Author: RobiNN
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
defined('IN_FUSION') || exit;

function get_video_data($url, $type = 'youtube') {
    $json_url = '';

    if ($type === 'youtube') {
        $url = filter_var($url, FILTER_VALIDATE_URL) == FALSE ? 'https://www.youtube.com/watch?v='.$url : $url;
        $json_url = 'https://www.youtube.com/oembed?url='.$url.'&format=json';
    } else if ($type === 'vimeo') {
        $json_url = 'https://vimeo.com/api/oembed.json?url='.$url;
    }

    if (!empty($json_url)) {
        $json_data = cache_curl($json_url);
        $json = json_decode($json_data, TRUE);

        if ($type === 'youtube') {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            $json['video_id'] = $match[1];
        }

        return $json;
    }

    return NULL;
}

function get_video_thumb($data, $full_url = FALSE) {
    $full_url = $full_url == TRUE ? fusion_get_settings('siteurl').'infusions/videos/' : VIDEOS;

    if ($data['video_type'] == 'youtube' || $data['video_type'] == 'vimeo') {
        if (!empty($data['video_image']) && file_exists(VIDEOS.'images/'.$data['video_image'])) {
            $thumb = $full_url.'images/'.$data['video_image'];
        } else {
            $video_data = get_video_data($data['video_url'], $data['video_type']);

            if (!empty($video_data['thumbnail_url'])) {
                $thumb = $video_data['thumbnail_url'];
            } else {
                $thumb = $full_url.'images/default_thumbnail.jpg';
            }
        }
    } else if (!empty($data['video_image']) && file_exists(VIDEOS.'images/'.$data['video_image'])) {
        $thumb = $full_url.'images/'.$data['video_image'];
    } else {
        $thumb = $full_url.'images/default_thumbnail.jpg';
    }

    return $thumb;
}

function cache_curl($url) {
    $cache_time = 604800; // One week
    $cache_dir = dirname(__FILE__).'/cache/';

    if (!is_dir($cache_dir)) {
        mkdir($cache_dir, 0777, TRUE);
    }

    $hash = md5($url);
    $file = $cache_dir.$hash.'.cache';
    $file_time = 0;

    if (file_exists($file)) {
        $file_time = filemtime($file);
    }

    $filetimemod = $file_time + $cache_time;

    if ($filetimemod < time()) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HEADER         => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_USERAGENT      => 'Googlebot/2.1 (+http://www.google.com/bot.html)',
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT        => 30
        ]);

        $data = curl_exec($ch);
        curl_close($ch);

        if ($data) {
            file_put_contents($file, $data);
        }
    } else {
        $data = file_get_contents($file);
    }

    return $data;
}

// Delete cache files older than two weeks
$files = glob(dirname(__FILE__).'/cache/*.cache');
$now = time();

if ($files) {
    foreach ($files as $file) {
        if (is_file($file)) {
            if ($now - filemtime($file) >= 1209600) {
                unlink($file);
            }
        }
    }
}
