<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class Guideline extends Model
{
    use HasFactory;

    protected $table = 'guideline';

    protected $primaryKey = 'guideline_id';

    protected $guarded = [];

    protected $fillable = [
        'guideline_description'
    ];

    public $timestamps = true;

    public function displayGuideline(){
        return $this->all();
    }

    public function registerGuidelineObject($guideline){
        return $this->create($guideline);
    }

    public function updateGuidelineObject($request, $guidelineId){

        $guidelineData = [
            'guideline_description' => Str::upper(trim($request->input('guideline_description')))
        ];

        $guideline = $this->find($guidelineId);
        $guideline->update($guidelineData);
    }

    public function removeGuidelineObject($guidelineId){
        $guideline = $this->find($guidelineId);
        $guideline->delete();
    }
}