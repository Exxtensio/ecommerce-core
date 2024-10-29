<?php

namespace Sambu\Ecommerce\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Sambu\Ecommerce\Models\Geo\Currency;

class ExchangeRateService
{
    private ?string $apiKey;
    private string $endpoint;
    private string $exception = "You need to add `EXCHANGERATE_API_KEY`. Go to https://www.exchangerate-api.com to register and generate the key.";

    public function __construct()
    {
        $this->apiKey = config('ecommerce.exchangerateApiKey') ?? null;
        $this->endpoint = "//v6.exchangerate-api.com/v6/$this->apiKey/latest/USD";
    }

    /**
     * @throws Exception
     */
    public function update(): void
    {
        if(empty($this->apiKey)) throw new Exception($this->exception);
        try {
            $response = Http::get($this->endpoint);
            if ($response->ok()) {
                $responseJson = $response->json();
                if (isset($responseJson['conversion_rates'])) {
                    collect($responseJson['conversion_rates'])->map(function ($v, $k) {
                        Currency::where('code', $k)->update([
                           'rate' => $v
                        ]);
                    });
                }
            }
        } catch (\Exception $e) {}
    }
}
