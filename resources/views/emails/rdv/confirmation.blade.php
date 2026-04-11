@component('mail::message')
# Confirm Password de votre Appointments

Bonjour **{{ $patient->name }}**,

Votre Appointments a ete confirme avec succes.

@component('mail::panel')
**Details du Appointments**

- **Medecin :** {{ $medecin->name }}
- **Date :** {{ $date }}
- **Heure :** {{ $heure }}
- **Statut :** Confirme
@endcomponent

Si vous souhaitez annuler ou modifier votre Appointments, veuillez nous contacter.

@component('mail::button', ['url' => config('app.url'), 'color' => 'blue'])
Acceder a mon espace
@endcomponent

Merci de votre confiance,<br>
**Bahjawa Medical Center**
@endcomponent


