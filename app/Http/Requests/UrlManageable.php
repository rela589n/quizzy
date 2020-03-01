<?php


namespace App\Http\Requests;


interface UrlManageable
{
    public function setUrlManager(RequestUrlManager $urlManager);
}
