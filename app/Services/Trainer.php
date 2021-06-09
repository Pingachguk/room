<?php

namespace App\Services;

use App\Services\RequestDB;
use Illuminate\Support\Facades\Http;
use PhpOption\None;

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
        $trainers = RequestDB::getTrainers($clubId, $utoken);
        $services = self::getServices($clubId, $utoken);

        if ($trainers["result"]) {
            foreach ($trainers["data"] as $item) {
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

                if (!$item["position"]["id"]) {
                    $trainers["data"]["office_id"] = $item["id"];
                    $nameSplit = explode(" ", $item["name"]);
                    $item["name"] = $nameSplit[0].' '.$nameSplit[1];
                }

//                ПОЛУЧАЕМ ВРЕМЯ ТРЕНЕРА С ПАРАМЕТРОМ УСЛУГИ
                $serviceId = Null;
                if (key_exists("office_id", $trainers['data'])) {
                    if ($item['id'] == $trainers["data"]["office_id"]) {
                        $serviceId = $services['office'];
                    } else {
                        $serviceId = $services['trainer'];
                    }
                } else {
                    $serviceId = $services['trainer'];
                }

                $timesJson = RequestDB::getTimesOfService($clubId, $utoken, $item["id"], $serviceId)["data"];
                if (count($timesJson)) {
                    $times = [];

                    foreach ($timesJson as $itemTime) {
////                    item_date_convert = datetime.fromisoformat(item_time['date_time'])
////                    item_date_string = datetime.strftime(item_date_convert, '%Y-%m-%d')
////                    item_hour = int(datetime.strftime(item_date_convert, '%H'))
////                    item_season = None
                        $itemDateConvert = 0;
                        $itemDateString = 0;
                        $itemHour = 0;
                        $itemSeason = Null;
                    }
                }
            }
        }

        return $trainers;
    }
}
