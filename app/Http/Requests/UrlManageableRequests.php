<?php


namespace App\Http\Requests;

trait UrlManageableRequests
{
    /**
     * @var RequestUrlManager
     */
    protected $urlManager;

    /**
     * @param RequestUrlManager $urlManager
     */
    public function setUrlManager(RequestUrlManager $urlManager): void
    {
        $this->urlManager = $urlManager;
    }

    /**
     * @return RequestUrlManager
     */
    public function getUrlManager()
    {
        return $this->urlManager;
    }
}
