<?php

namespace App\Http\Controllers;

use App\Services\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\Clubs;
use App\Services\Client;
use App\Services\RequestDB;

class ApiController extends Controller
{
    public function clubs()
    {
        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders(['apikey' => '1a5a6f3b-4504-40b7-b286-14941fd2f635'])
            ->get(env('API_ADDR') . '/clubs/');
        return response(json_encode($response->json()['data'], JSON_UNESCAPED_UNICODE), 200);
    }

    public function club(Request $request, $id)
    {
        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders(['apikey' => Clubs::getKeyByClub($id)])
            ->get(env('API_ADDR') . '/clubs/');
        return response(json_encode($response->json()['data'], JSON_UNESCAPED_UNICODE), 200);
    }

    public function confirmPhone(Request $request)
    {
        $data = $request->input();
        $club_id = $request->header('club_id');

        if (key_exists('confirmation_code', $data)) {
            $response = RequestDB::postConfirmationCode($club_id, $data);
            return response($response);
        } else {
            $code = RequestDB::getCodeOnPhone($club_id, $data);
            return response($code);
        }
    }


    public function resetPassword(Request $request)
    {
        $data = $request->input();
        $club_id = $request->header('club_id');

        $response = RequestDB::postNewPassword($club_id, $data);
        return response($response);
    }


    public function register(Request $request)
    {
        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders(['apikey' => Clubs::getKeyByClub($request->header('club_id'))])
            ->post(env('API_ADDR') . '/reg_and_auth_client/', $request->input());
        if ($response->json()['reuslt']) {
            $utoken = $response->json()['data']['user_token'];
            return response('200', 200)->cookie('utoken', $utoken, 60 * 24);
        } else {
            return response($response->json());
        }
    }


    public function login(Request $request)
    {
        $response = Http::withBasicAuth(env('APP_BASIC_LOGIN'), env('APP_BASIC_PASSWORD'))
            ->withHeaders(['apikey' => Clubs::getKeyByClub($request->header('club_id'))])
            ->post(env('API_ADDR') . '/auth_client/', $request->input());

        if ($response->json()['result']) {
            $utoken = $response->json()['data']['user_token'];
            return response('200', 200)->cookie('utoken', $utoken, 60 * 24);
        } else {
            return response($response->json(), 4003);
        }
    }

    public function getClient(Request $request)
    {
        $apiKey = Clubs::getKeyByClub($request->header('club_id'));
        $utoken = $request->cookie('utoken');

        $week_name = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        $month_name = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        $month_short_name = ['Янв', 'Фев', 'Мар', 'Апр', 'Мая', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Нояб', 'Дек'];

        $client = RequestDB::getClient($apiKey, $utoken);
        if (!($client->json())['result']) {
            return $client->json();
        }
        $tickets = RequestDB::getTickets($apiKey, $utoken);
        $appointments = RequestDB::getAppointments($apiKey, $utoken);

        $clientJson = $client->json();
        $ticketsJson = $tickets->json();
        $appointmentsJson = $appointments->json();

        if ($ticketsJson['result']) {
            $clientJson = Client::setSubscriptions($clientJson, $ticketsJson);
        }

        if ($appointmentsJson['result'] && sizeof($appointmentsJson['data'] != 0)) {
            $clientJson = Client::setAppointments($clientJson, $appointmentsJson, $utoken);
        }

        return $appointmentsJson;
    }

    public function updateClient(Request $request)
    {
        $utoken = $request->cookie('utoken');
        $response = RequestDB::updateClient($utoken, $request->input());
        return response($response->json());
    }

//@app.post("/api/images/upload")
//async def create_upload_file(file: UploadFile = File(...)):

//@app.post("/api/verified/send", name='Заявка на верефикацию паспорта')
//async def verified_send(item: ModelVerifiedSend):

//@app.get("/api/training/cancel")
//def get_training_cancel(club_id: Optional[str] = Query(...), appointment_id: Optional[str] = Query(...), utoken: str = Header(...)):
    public function getTrainingCancel(Request $request)
    {
        $club_id = $request->header("club_id");
        $utoken = $request->cookie("utoken");

    }

//@app.get("/api/trainers/detail")
//def get_trainer_detail(club_id: Optional[str] = Query(...), employee_id: Optional[str] = Query(...), utoken: str = Header(...)):
    public function getTrainerDetail(Request $request)
    {
        $club_id = $request->header("club_id");
        $utoken = $request->cookie("utoken");

    }

//@app.get("/api/trainers", name="Свободные тренера и время")
//def get_trainers_all(club_id: Optional[str] = Query(...), date: Optional[str] = Query(None), time: Optional[str] = Query(None), utoken: str = Header(...)):
    public function getTrainersAll(Request $request)
    {
        $clubId = $request->header("club_id");
        $utoken = $request->cookie("utoken");
        $data = $request->input();

        $trainers = Trainer::getAllTrainers($clubId, $utoken);
        $services = Trainer::getServices($clubId, $utoken);

        return response($trainers);
    }

//@app.get("/api/promocode/check", name="Стоимость корзины + промокод")
//def get_promocode_check(club_id: Optional[str] = Query(...),
    public function getPromocodeCheck(Request $request)
    {

    }

//@app.get("/api/shop/products", name="Абонементы / каталог товаров")
//def get_shop_products(club_id: Optional[str] = Query(...), utoken: str = Header(...)):

//@app.post("/api/subscription/write", name="Запись на тренеровку с абонемента")
//def subscriptions_write(item: ModelSubscriptionWrite, utoken: str = Header(...)):

//@app.post("/api/subscription/product/reserved", name="Оплата забронированной тренеровки")
//def subscriptions_write(item: ModelSubscriptionWrite, utoken: str = Header(...)):

//@app.post("/api/subscription/write/once", name="Бронирование тренеровки перед оплатой")
//def subscriptions_write(item: ModelSubscriptionReserved, utoken: str = Header(...)):

//@app.post("/api/subscription/product/pay", name="Покупка абонемента")
//def subscriptions_product_pay(item: ModelSubscriptionPay, utoken: str = Header(...)):

//@app.get("/api/order/check", name="Подтверждение заказа")
//def order_confirm(orderId: Optional[str] = Query(...), utoken: str = Header(...)):

//@app.get("/api/payment/webhook_notify", name="Статусы сделок от сбера")
//def sber_callback(item: ModelCallback):


}
