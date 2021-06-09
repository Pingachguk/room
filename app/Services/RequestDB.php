<?php

namespace App\Services;

use http\Env\Request;
use Illuminate\Support\Facades\Http;

class RequestDB
{
    public static function getClient(string $apiKey, string $utoken)
    {
        $client = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apiKey,
                'usertoken' => $utoken,
            ])
            ->get(env('API_ADDR') . '/client/');

        return $client;
    }

    public static function getTickets(string $apiKey, string $utoken)
    {
        $ticket = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apiKey,
                'usertoken' => $utoken,
            ])
            ->get(env('API_ADDR') . '/tickets/');
        return $ticket;
    }

    public static function getAppointments(string $apiKey, string $utoken)
    {
        $appointments = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apiKey,
                'usertoken' => $utoken,
            ])
            ->get(env('API_ADDR') . '/appointments/');
        return $appointments;
    }

    public static function getAppoint(string $apiKey, string $utoken, $clubId, $appointmentId)
    {
        $appoint = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apiKey,
                'usertoken' => $utoken,
            ])
            ->get(env('API_ADDR') . '/appoint/', [
                'club_id' => $clubId,
                'appointment_id' => $appointmentId
            ]);

        return $appoint;
    }

    public static function updateClient($utoken, $data)
    {
        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'usertoken' => $utoken,
            ])
            ->put(env('API_ADDR') . '/client/', $data);

        return $response;
    }

    public static function getCodeOnPhone($clubId, $data)
    {
        $apikey = Clubs::getKeyByClub($clubId);
        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apikey,
            ])
            ->post(env('API_ADDR') . '/confirm_phone/', $data);

        return $response->json();
    }

    public static function postConfirmationCode($clubId, $data)
    {
        $apikey = Clubs::getKeyByClub($clubId);
        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apikey,
            ])
            ->post(env('API_ADDR') . '/confirm_phone/', $data);

        return $response->json();
    }

    public static function postNewPassword($clubId, $data)
    {
        $apikey = Clubs::getKeyByClub($clubId);
        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apikey,
            ])
            ->post(env('API_ADDR') . '/password/', $data);

        return $response->json();
    }

    public static function deleteTraining($clubId, $utoken, $appointmentId)
    {
        $apikey = Clubs::getKeyByClub($clubId);
        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apikey,
                'usertoken' => $utoken
            ])
            ->delete(env('API_ADDR') . '/appointment/', [
                'club_id' => $clubId,
                'appointment_id' => $appointmentId
            ]);

        return $response->json();
    }

    public static function getTrainers($clubId, $utoken)
    {
        $apikey = Clubs::getKeyByClub($clubId);

        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apikey,
                'usertoken' => $utoken
            ])
            ->get(env('API_ADDR') . '/appointment_trainers/', [
                "club_id" => $clubId
        ]);

        return $response->json();
    }

    public static function getServices($clubId, $utoken)
    {
        $apikey = Clubs::getKeyByClub($clubId);

        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apikey,
                'usertoken' => $utoken
            ])
            ->get(env('API_ADDR') . '/appointment_services/', [
                "club_id" => $clubId
            ]);

        return $response->json();
    }

    public static function getTimesOfService($clubId, $utoken, $employeeId, $serviceId)
    {
        $apikey = Clubs::getKeyByClub($clubId);

        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apikey,
                'usertoken' => $utoken
            ])
            ->get(env('API_ADDR') . '/appointment_services/', [
                "club_id" => $clubId,
                "employee_id" => $employeeId,
                "service_id" => $serviceId
            ]);

        return $response->json();
    }

    public static function getPromocodeCheck($clubId, $utoken, $queryParam, $data)
    {
        $apikey = Clubs::getKeyByClub($clubId);

        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders([
                'apikey' => $apikey,
                'usertoken' => $utoken
            ])
            ->get(env('API_ADDR') . '/cart_cost/?cart='.$queryParam, [
                "club_id" => $clubId,
                "promocode" => $data['promocode']
            ]);

        return $response->json();
    }
}
