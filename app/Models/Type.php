<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;


    protected $fillable = ['label', 'color'];

    //relazione 1(type) a N(projects) con Type
    public function projects() {
        return $this->hasMany(Project::class);
    }


    //funzione per la pill
    public function getPillHTML() {
        return '<span class="badge rounded-pill" style="background-color:' . $this->color . '">' . $this->label . '</span>';
    }
}