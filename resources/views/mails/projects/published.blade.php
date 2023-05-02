<x-mail::message>
# {{$published_text}}
## {{$project->title}}
 
<p>
    {{$project->getAbstract(100)}}
</p>
 
@if ($project->is_published)   
<x-mail::button :url="$button_url">
  View Project
</x-mail::button>
@endif
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

