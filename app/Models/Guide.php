<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory;

    protected $table = 'guide';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'label',
        'content',
        'guideline_id'
    ];

    public $timestamps = false;

    public function retreiveAllGuide($guidelineId){
        return $this->where('guideline_id', Crypt::decryptString($guidelineId))->get();
    }

    public function registerGuideObject($guide){
        return $this->insert($guide);
    }

    public function updateGuideObject($request, $guideId){
        $guideData = [
            'label' => Str::of(trim($request->input('label')))->title(),
            'content' => Str::ucfirst(trim($request->input('content')))
        ];

        $guide = $this->find($guideId);
        $guide->update($guideData);
    }

    public function removeGuideObject($guideId){
        $guide = $this->find($guideId);
        $guide->delete();
    }
}
