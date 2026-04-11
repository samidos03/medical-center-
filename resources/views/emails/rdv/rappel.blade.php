@component('mail::message')
# Rappel - Votre Appointments est demain

Bonjour **{{ $patient->name }}**,

Ceci est un rappel pour votre Appointments prevu **demain**.

@component('mail::panel')
**Details du Appointments**

- **Medecin :** {{ $medecin->name }}
- **Date :** {{ $date }}
- **Heure :** {{ $heure }}
@endcomponent

Merci de vous presenter 10 minutes avant l heure du Appointments.

@component('mail::button', ['url' => config('app.url'), 'color' => 'blue'])
Acceder a mon espace
@endcomponent

Cordialement,<br>
**Bahjawa Medical Center**
@endcomponent


