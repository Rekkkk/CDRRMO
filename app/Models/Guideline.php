<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guideline extends Model
{
    use HasFactory;

    protected $table = 'guideline';

    protected $primaryKey = 'guideline_id';

    protected $guarded = [];

    protected $fillable = [
        'guideline_id',
        'guideline_description',
    ];

    public $timestamps = true;

    public function displayGuideline(){
        return $this->all();
    }
}