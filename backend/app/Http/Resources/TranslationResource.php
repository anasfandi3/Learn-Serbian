<?php

namespace App\Http\Resources;

use App\Models\Translation;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $records = Translation::all()->toArray();
        $random = rand(0, 100);
        $record = [
            'id' => $this->id,
            'image_name' => $this->image_name,
            'word' => $random > 50?$this->english: $this->serbian,
            'is_english' => $random > 50? true: false,
        ];
        return $record;
    }
}
