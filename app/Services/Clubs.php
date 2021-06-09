<?php

namespace App\Services;

class Clubs
{
    public static function getKeyByClub(string $id)
    {
        $apiKeysClubs = [
            "bf1e201a-01c3-11eb-bbdb-005056838e97" => "24955a4d-0467-4886-ba0b-1f54d5a50bb2",
            "a23e2522-e7ad-11ea-bbd8-005056838e97" => "c164bc33-4dfe-4235-bae7-0b5aa38f2452",
            "e64f0bc2-0652-11eb-bbdb-005056838e97" => "a955977a-1177-48a5-a12a-70199432c5cb",
            "22bd71b4-e7af-11ea-bbd8-005056838e97" => "1799c52b-a66a-4187-ac5a-073e4515ec46",
            "d987364c-e7ae-11ea-bbd8-005056838e97" => "0cc5eb3f-a77e-406d-a212-aa3d514415d3",
            "630de9d9-e7ae-11ea-bbd8-005056838e97" => "19d06469-3a5e-43f9-977c-ca18324a31e1",
            "cb28be84-0651-11eb-bbdb-005056838e97" => "bf10824c-dab7-413d-addf-cc80c4111576",
            "39158ee8-e79e-11ea-bbd8-005056838e97" => "1a5a6f3b-4504-40b7-b286-14941fd2f635",
            "d2c3b3d6-e7ad-11ea-bbd8-005056838e97" => "9c5a3bb6-16b1-48f3-9e78-84299a619fda",
            "37948207-e7ae-11ea-bbd8-005056838e97" => "31b8db60-cb60-457f-bed0-69c9a3a65e84",
            "64b8476a-e7ad-11ea-bbd8-005056838e97" => "6a8a7d85-4836-4ace-a495-9a5262975b83",
            "915d3c3b-daff-11ea-bbd8-005056838e97" => "e25f4e9d-92ec-4750-9b84-8655bb89f0ff",
            "603cb73d-e7af-11ea-bbd8-005056838e97" => "f7bd7973-287a-4a0e-a706-745b25758182",
            "42632fd3-e7af-11ea-bbd8-005056838e97" => "bfbce456-def7-43d0-a8f4-725176c67341",
            "15281aec-07c8-11eb-bbdb-005056838e97" => "bf54b61c-9039-4df2-b837-d85c6f0cbf4f",
            "b9ea102a-0ec0-11eb-bbdb-005056838e97" => "f8e758e6-effe-4516-9ae1-34a946a0d5b9",
            "129d154c-0ec1-11eb-bbdb-005056838e97" => "f3525e34-b232-4c1e-a2b7-11ae35f8bbaf"
        ];
        $apiKey = $apiKeysClubs[$id];
        return $apiKey;
    }
}
