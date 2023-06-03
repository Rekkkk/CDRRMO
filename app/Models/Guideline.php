<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guideline extends Model
{
    use HasFactory;

    protected $table = 'guideline';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'type'
    ];

    public $timestamps = false;

    public function registerGuidelineObject($guideline){
        return $this->create($guideline);
    }

    public function updateGuidelineObject($request, $guidelineId){

        $guidelineData = [
            'type' => Str::upper(trim($request->input('type')))
        ];

        $guideline = $this->find($guidelineId);
        $guideline->update($guidelineData);
    }

    public function removeGuidelineObject($guidelineId){
        $guideline = $this->find($guidelineId);
        $guideline->delete();
    }
}