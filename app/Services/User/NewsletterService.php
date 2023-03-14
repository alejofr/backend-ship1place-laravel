<?php

namespace App\Services\User;

use DateTime;

class NewsletterService{

    private $newsletter;
    public function __construct($isNewsletter = false)
    {
       $this->newsletter =  $isNewsletter;
    }

    public function consent_date() : DateTime | null
    {
        return  $this->newsletter ? new DateTime() : null;
    }
}