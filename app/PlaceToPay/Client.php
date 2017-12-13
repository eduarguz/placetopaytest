<?php

namespace App\PlaceToPay;

use SoapClient;

class Client
{
    /** The Base url for the web service */
    const BASE_WSDL = "https://test.placetopay.com/soap/pse/?wsdl";

    /** The location of the web service */
    const BASE_LOCATION = "https://test.placetopay.com/soap/pse/";

    /**
     * Call an action.
     *
     * @param $name
     * @param array $params
     * @return object
     */
    public function action($name, $params = [])
    {
        $soap = new SoapClient(self::BASE_WSDL, [
            'location' => self::BASE_LOCATION,
        ]);

        return $soap->$name($params);
    }
}