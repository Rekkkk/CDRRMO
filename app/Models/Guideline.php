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

    public function displayGuideline(){
        return $this->all();
    }

    public function registerGuidelineObject($guideline){
        return $this->create($guideline);
    }

    public function updateGuidelineObject($request, $guidelineId){

        $guidelineData = [
            'type' => Str::upper(trim($request->input('guideline_description')))
        ];

        $guideline = $this->find($guidelineId);
        $guideline->update($guidelineData);
    }

    public function removeGuidelineObject($guidelineId){
        $guideline = $this->find($guidelineId);
        $guideline->delete();
    }
}