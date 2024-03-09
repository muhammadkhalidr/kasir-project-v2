<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id_setting'];
    protected $settings;
    protected $primaryKey = 'id_setting';

    public $incrementing = true;
    public $timestamps = true;
}
