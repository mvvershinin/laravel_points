<?php

namespace App\Services\Geocoding;

use App\Dtos\Geocoding\AddressDto;
use GuzzleHttp\Client;

final class YandexGeocodingService extends AbstractGeocodingService
{
    public function __construct(
        protected Client $yandexClient
    )
    {

    }

    /**
     * @param float $lat
     * @param float $lon
     * @return AddressDto
     * @throws \Exception
     */
    public function getAddressByPoint(float $lat, float $lon): AddressDto
    {
        $yandexData = $this->getYandexResponse($lat, $lon);

        return new AddressDto($yandexData->text, $yandexData->kind);
    }

    /**
     * @param float $lat
     * @param float $lon
     * @return object
     * @throws \Exception
     */
    protected function getYandexResponse(float $lat, float $lon): object
    {
        try {
            $apiKey = config('geocoding.yandex_apiKey');
            $url = "https://geocode-maps.yandex.ru/1.x?apikey=$apiKey&geocode=$lat,$lon&format=json&results=1";

            $response = $this->yandexClient->get($url);
            $contents = json_decode($response->getBody()->getContents());
            $geoDataObject = array_pop($contents->response->GeoObjectCollection->featureMember);

            return $geoDataObject->GeoObject->metaDataProperty->GeocoderMetaData;
        } catch (\Throwable $exception) {
            throw new \Exception('unable get point data from yandex:: ' . $exception->getMessage());
        }
    }
}
