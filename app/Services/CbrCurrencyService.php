<?php


namespace App\Services;


use GuzzleHttp\Client;
use http\Exception\UnexpectedValueException;
use SimpleXMLElement;

class CbrCurrencyService
{
    private $client;

    const CBR_DAILY_CURRENCIES_URL = 'http://www.cbr.ru/scripts/XML_daily.asp';

    static $currenciesIds =
    [
        'usd' => 'R01235',
    ];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $currencyCipher
     * @param string $date
     * @return string|null
     * @throws \Exception
     */
    public function getCurrencyValueByDate(string $currencyCipher, string $date) {
        $response = $this->client->get(self::CBR_DAILY_CURRENCIES_URL, ['date_req' => $date]);

        if ($response->getStatusCode() !== 200
            || $response->getHeader('Content-Type')[0] !== 'application/xml; charset=windows-1251') {
            throw new \Exception("Unexpected response from CBR server");
        }

        $xmlResponse = new SimpleXMLElement($response->getBody()->getContents());

        $currencies = $xmlResponse;

        foreach ($currencies->children() as $currency) {
            $currencyId = (string)$currency->attributes()->{'ID'};
            if ($currencyId == self::$currenciesIds[$currencyCipher]) {
                $currencyValue = (string)$currency->{'Value'};
                return $currencyValue;
            }
        }

        return null;
    }
}