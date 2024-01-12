<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    public $status = 200;
    public $message = 'OK';
    public $resource = null;


    public function __construct($status = 200, $message = 'OK', $resource = null)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }
}
