<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disaster extends Model
{
    use HasFactory;

    protected $table = 'disaster';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'type'
    ];

    public $timestamps = false;

    public function updateDisasterObject($disasterData, $disasterId){
        $disaster = $this->find($disasterId);
        $disaster->update($disasterData);
    }

    public function removeDisasterObject($disaster){
        $disaster = $this->find($disaster);
        $disaster->delete();
    }
}
