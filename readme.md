# DIJ Assessment-PHP-Developer

Bij DIJ werken we met PHP, Laravel en implementeren we vaak REST API's. 
We zijn best nieuwsgierig hoe jij dat precies aanpakt. 

Afgezien van de opdracht zelf zijn er aantal dingen die we graag willen zien:
- Maak gebruik van versiebeheer. Bij voorkeur git.
- Automatische Tests. Bijv feature tests, end-to-end tests of unit tests. Als je iets beters weet mag dat natuurlijk ook!
- Gebruik als basis het Laravel framework. Je kan de docs hier vinden: https://laravel.com

## Opdracht

Het komt vaak voor dat je wachtwoorden of andere gevoelige gegevens moet delen met collega's, een externe partij of een klant.
Om te voorkomen dat deze data uitlekt kan je gebruik maken van een Secure Messaging Application. 
Aan jou de taak om een simpele SMA op te zetten. Wat we ongeveer verwachten:

1. Een pagina om een bericht te versleutelen
    * We hoeven alleen tekst op te sturen
    * Soms wil ik een bericht naar een collega sturen. Het zou handig zijn als ik optioneel een collega kan kiezen uit een lijst zodat ik zijn gegevens niet in hoef te voeren, daarvoor kan je gebruik maken van deze 'API': https://pastebin.com/raw/uDzdKzGG (Behalve het opslaan van de gekozen collega in bijv. je database hoef je hier niet echt iets mee te doen)
2. Na het versleutelen krijg ik een URL naar de ontsleutel pagina en een wachtwoord om het bericht te ontsleutelen
3. Bericht ontsleutel pagina
    * Om de veiligheid te garanderen heb je het wachtwoord nodig om de gegevens in te zien
    * De pagina moet automatisch verlopen na een bepaalde tijd en/of te verwijderen zijn nadat hij gelezen is

## Assessment opsturen
We hebben alvast een beginnetje voor je gemaakt in de 'assignment' map. Daar vind je een (bijna) lege Laravel installatie met Tailwindcss. 
Om je een beetje te helpen staat er ook alvast een simpel formuliertje klaar inclusief een feature test.
Clone deze repository of maak je eigen repo aan. Stuur ons een linkje naar je repo of stuur hem daarna in een zipje onze kant op. 
We hebben liever geen forks of pull requests, dan kan iedereen de oplossing bij elkaar afkijken ;)
