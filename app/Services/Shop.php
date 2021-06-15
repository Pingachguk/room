<?php

namespace App\Services;

class Shop
{
    public static function getCategory($item)
    {
        $title = trim($item['title']);
        $category = $item['category']['title'];
        $categorySlug = Null;
        $categoryPackage = Null;

        if ($category == "Аренда") $categorySlug = "office";
        if ($category == "Пакеты тренировок") $categorySlug = "trainer";

        if (str_contains($title, 'Пакет')) $categoryPackage = true;

        $categories = [
            'Пробная тренировка с тренером' => ['first' => 'trainer'],
            'Разовая тренировка с тренером' => ['once' => 'trainer'],
            'Разовая аренда студии' => ['once' => 'office'],
            'Аренда зала Москва ул. Новотушинская д. 2' => ['once' => 'office'],
            'аренда зала автозаводская д. 23б' => ['once' => 'office']
        ];

        if ($categoryPackage && $categorySlug) return ['package' => $categorySlug];

        foreach ($categories as $item) {
            if ($item == $title) return $categories[$item];
        }
    }
}
