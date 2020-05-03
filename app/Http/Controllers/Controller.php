<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return Cache::remember('views.your.view.name', 5, function (){
            return $this->data()->render();
        });
    }

    private function data()
    {
        $response = $this->getBazzarInfo();
        $data = $response['products'];

        $products = collect($data)->map(function ($item) {
            $item['sell_summary'] = array_slice($item['sell_summary'], 0, 5);
            $item['buy_summary'] = array_slice($item['buy_summary'], 0, 5);

            $item['sellVolume'] = number_format($item['quick_status']['sellMovingWeek'], 0, '.', ',');
            $item['buyVolume'] = number_format($item['quick_status']['buyMovingWeek'], 0, '.', ',');

            $firstSell = Arr::first($item['sell_summary']);
            $firsBuy = Arr::first($item['buy_summary']);

            $sellPrice = $firsBuy ? $firsBuy['pricePerUnit'] : 0;
            $buyPrice = $firstSell ? $firstSell['pricePerUnit'] : 0;

            $item['percentage_raw'] = ($sellPrice == 0 || $buyPrice == 0) ? 0 : ($sellPrice - $buyPrice) * (100 / $buyPrice);
            $item['percentage'] = number_format($item['percentage_raw'], 1);

            $item['buyPrice'] = number_format($buyPrice, 1, '.', ',');
            $item['sellPrice'] = number_format($sellPrice, 1, '.', ',');

            $item['item_name'] = Arr::get(self::ITEM_NAME, $item['product_id'], $item['product_id']);

            $item['profit'] = number_format($sellPrice - $buyPrice, 1);

            unset($item['quick_status']);

            return $item;
        });

        $products = $products->sortByDesc('percentage');

        return view('stonkz', [
            'items' => $products,
        ]);
    }

    private function getBazzarInfo()
    {
        return Http::get(config('services.hypixel.url') . 'skyblock/bazaar', [
            'key' => config('services.hypixel.key'),
        ]);
    }

    const ITEM_NAME = [
        'INK_SACK:3' => 'COCOA_BEANS',
        'INK_SACK:4' => 'LAPIS',
        'LOG' => 'OAK',
        'LOG:2' => 'BIRCH',
        'LOG:1' => 'SPRUCE',
        'LOG_2:1' => 'DARK_OAK',
        'LOG_2' => 'ACACIA',
        'LOG:3' => 'JUNGLE',
        'RAW_FISH:1' => 'SALMON',
        'RAW_FISH:2' => 'CLOWNFISH',
        'RAW_FISH:3' => 'PUFFERFISH',
        'HUGE_MUSHROOM_1' => 'BROWN_MUSHROOM_BLOCK',
        'HUGE_MUSHROOM_2' => 'RED_MUSHROOM_BLOCK',
    ];
}
