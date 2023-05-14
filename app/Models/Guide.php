<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory;

    protected $table = 'guide';

    protected $primaryKey = 'guide_id';

    protected $guarded = [];

    protected $fillable = [
        'guide_description',
        'guide_content',
        'guideline_id'
    ];

    public $timestamps = true;

    public function registerGuideObject($guide){
        return $this->create($guide);
    }

    public function updateGuideObject($request, $guideId){
        $guideData = [
            'guide_description' => Str::of(trim($request->input('guide_description')))->title(),
            'guide_content' => Str::of(trim($request->input('guide_content')))->title()
        ];

        $guide = $this->find($guideId);
        $guide->update($guideData);
    }

    public function removeGuideObject($guideId){
        $guide = $this->find($guideId);
        $guide->delete();
    }
}
