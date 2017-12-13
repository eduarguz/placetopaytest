<?php

namespace App\Billing;

class Person
{
    public $document = '';
    public $documentType = '';
    public $firstName = '';
    public $lastName = '';
    public $company = '';
    public $emailAddress = '';
    public $address = '';
    public $city = '';
    public $province = '';
    public $country = '';
    public $phone = '';
    public $mobile = '';

    /**
     * Creates a Person using an email and a request with some data.
     *
     * @param $email
     * @param $request
     * @return \App\Billing\Person
     */
    public static function fromRequest($email, $request) {
        $person = new self();

        $person->document= $request->document;
        $person->documentType= $request->document_type;
        $person->firstName= $request->first_name;
        $person->lastName= $request->last_name;
        $person->emailAddress= $email;

        return $person;
    }
}