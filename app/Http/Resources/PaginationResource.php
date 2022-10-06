<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    public $status;
    public $message;
    public $page;
    public $totalPage;
    public $totalData;

    public function __construct(
        $status,
        $message,
        $page,
        $totalPage,
        $totalData,
        $resource
    )
    {
        parent::__construct($resource);
        $this->status  = $status;
        $this->message = $message;
        $this->page = $page;
        $this->totalData = $totalData;
        $this->totalPage = $totalPage;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status'    => $this->status,
            'message'   => $this->message,
            'data'      => $this->resource,
            'meta'      => [
                "currentPage"          => $this->page,
                "totalData"     => $this->totalData,
                "totalPage"     => $this->totalPage
            ]
        ];
    }
}
