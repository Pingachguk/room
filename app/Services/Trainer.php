<?php

namespace App\Services;

use App\Services\RequestDB;
use Illuminate\Support\Facades\Http;

class Trainer
{
    public static function getServices($clubId, $utoken)
    {
        $response = RequestDB::getServices($clubId, $utoken);
        $services = array();

        if ($response['result']) {
            foreach ($response['data'] as $item) {
                if ($item['title'] == "Персональная тренировка") {
                    $services['trainer'] = $item["id"];
                } elseif ($item["title"] == "АРЕНДА СТУДИИ ДЛЯ ТРЕНЕРА") {
                    $services['office'] = $item["id"];
                }
            }
        }

        return $services;
    }

    public static function getAllTrainers($clubId, $utoken)
    {
        $response = RequestDB::getTrainers($clubId, $utoken);

        if ($response["result"]) {
            foreach ($response["data"] as $item) {
//                Получили тренеров и заменили фотки на локальный сервер (1С не даёт смотреть фото без авторизации)
                if ($item["photo"]) {
                    $photoName = basename(parse_url($item["photo"])['path']);
                    $checkPhoto = file_exists('images/'.$photoName);

                    if ($checkPhoto) {
                        $item['photo'] = env('SERVER_IMAGES_DEBUG').$photoName;
                    } else {
                        $photoRead = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
                        ->get($item['photo']);
                        $content = $photoRead->body();
                        $photoWrite = fopen('images/'.$photoName, 'w');
                        fwrite($photoWrite, $content);
                        $item['photo'] = env('SERVER_IMAGES_DEBUG').$photoName;
                    }
                }
            }
        }

//        return $photoName;
    }
}
