<?php

namespace App\Models;

// Carbon è una libreria per gestire le date
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["type_id", "title", "image", "text", "is_published"];

    //relazione 1(type) a N(projects) con Type
    public function type() {
        return $this->belongsTo(Type::class);
    }

    //relazione N(projects) a N(technologies)
    public function technologies() {
        return $this->belongsToMany(Technology::class);
    }

    //funzione per generare un abstract del text
    public function getAbstract($max=50) {
        return substr($this->text, 0, $max) . "...";
    }

    //funzione per generare slug unico
    public static function generateSlug($title) {
        //genera slug
        $possible_slug = Str::of($title)->slug('-');

        //array di progetti in cui lo slug = $possible_slug
        $projects = Project::where('slug',  $possible_slug)->get();

        //controllo che slug sia unico e se non lo è lo rigenero
        //while finchè c' è qualcosa dentro array projects, se è vuoto (e quindi slug è unico) non entrerà nemmeno nel while
        $original_slug = $possible_slug;
        $i = 2;
        
        while(count($projects)) {
            $possible_slug = $original_slug . "-" . $i;
            $projects = Project::where('slug',  $possible_slug)->get();
            $i++;
        }

        return $possible_slug;
    }

    //funzione(mutator) per modificare formato data in cui si presenta l' updated_at
    protected function getUpdatedAtAttribute($value) {
        // return date('d/m/Y H:i', strtotime($value));
        $date_from = Carbon::create($value);
        $date_now = Carbon::now(); 
        return str_replace('prima', 'fa', $date_from->diffForHumans($date_now));
        // return Carbon::now()->format('d/m/Y H:i');
    }

    //funzione(mutator) per modificare formato data in cui si presenta il created_at
    protected function getCreatedAtAttribute($value) {
        Carbon::setLocale('it');
        $date_from = Carbon::create($value);
        $date_now = Carbon::now(); 
        return str_replace('prima', 'fa', $date_from->diffForHumans($date_now));
    }

    //funzione(non mutator) per mostrare placeholder dell' immagine qualora essa non ci sia
    public function getImageUri() {
       return $this->image ? url('storage/' . $this->image) : 'https://www.frosinonecalcio.com/wp-content/uploads/2021/09/default-placeholder.png';
    }
}