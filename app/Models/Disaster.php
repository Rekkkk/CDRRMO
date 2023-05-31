<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disaster extends Model
{
    use HasFactory;

    protected $table = 'disaster';

    protected $primaryKey = 'disaster_id';

    protected $guarded = [];

    protected $fillable = [
        'disaster_type'
    ];

    public $timestamps = false;

    public function displayDisasterObject(){
        return $this->all()->sortBy('disaster_id');
    }

    public function updateDisasterObject($disasterData, $disasterId){
        $barangay = $this->find($disasterId);
        $barangay->update($disasterData);
    }

    public function removeDisasterObject($disaster){
        $disaster = $this->find($disaster);
        $disaster->delete();
    }
}
