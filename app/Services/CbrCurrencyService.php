<?php

namespace App\Services;

use SimpleXMLElement;
use GuzzleHttp\Client;

class CbrCurrencyService implements CurrencyServiceInterface
{
    private $client;

    private const CBR_DAILY_CURRENCIES_URL = 'http://www.cbr.ru/scripts/XML_daily.asp';

    private static $currenciesIds =
        [
            'usd' => 'R01235',
            'eur' => 'R01239',
            'gpb' => 'R01035',
        ];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCurrencyCodes()
    {
        return array_keys(self::$currenciesIds);
    }

    /**
     * @param string $currencyCode
     * @param string $date
     *
     * @throws \Exception
     *
     * @return string|null
     */
    public function getCurrencyValueByDate(string $currencyCode, string $date)
    {
        $response = $this->client->get(self::CBR_DAILY_CURRENCIES_URL, ['date_req' => $date]);

        if ($response->getStatusCode() !== 200
            || $response->getHeader('Content-Type')[0] !== 'application/xml; charset=windows-1251') {
            throw new \Exception('Unexpected response from CBR server');
        }

        $xmlResponse = new SimpleXMLElement($response->getBody()->getContents());

        $currencies = $xmlResponse;

        foreach ($currencies->children() as $currency) {
            $currencyId = (string) $currency->attributes()->{'ID'};
            if ($currencyId == self::$currenciesIds[$currencyCode]) {
                $currencyValue = (string) $currency->{'Value'};

                return $currencyValue;
            }
        }
    }
}
