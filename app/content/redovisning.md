Redovisning
====================================
 
Kmom01: Me-sida
------------------------------------
Oerhört intressant att börja programmera enligt MVC. 


Som vanligt använder jag Sublime Text som min text editor, några plugins jag använder är SFTP, SublimeLinter och Emmet dock har jag ändrat färgtemat till vitt.

Google Chrome används flitigt som standard webläsare eftersom man alltid är inloggad på sitt google konto, bokmärken och historik sparas. Jag använder även 1Password som min lösenordshanterare. 

Det var ganska mycket att läsa för att komma igång med detta kursmomentet. Väldigt många nya svåra ord att förstå exempelvis Lazy initialization, dependency injection och så vidare.


Problem med Me-sida fanns helt klart, MOS hade missat lite information på http://dbwebb.se/kunskap/bygg-en-me-sida-med-anax-mvc men jag lyckades lösa det själv.

Några exempel på missar:

1. Ingen stylsheet på navbar, 
löstes med: `'stylesheets' => ['css/style.css', 'css/navbar.css'],`.
2. Använda URL_CLEAN 
löstes med:`$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);`.

Som tur är visade jag mos felen och bygg-en-me-sida är nu uppdaterad.
`2014-04-03 (B, mos) Vy welcome/page blir me/page, ändra $url::URL_CLEAN till \Anax\Url\CUrl::URL_CLEAN samt style till navbaren. `

Kursmoment 1 var inte särskilt svårt, det behövdes inte mycket kod för att implementera me-sidan. Det kändes skönt att behöva slippa skriva massa klasser och istället fokusera på mappstrukturen och hålla reda på alla miljontals filer. 

Jag är helt klart nöjd med detta kursmoment. Man fick insyn på hur ett ramverk kan byggas upp och användas.

Tidigare erfarenheter av ramverk är null. Har självklart hört talas om de största Laravel, Code Igniter och så vidare.



Kmom02: Kontroller och modeller
------------------------------------

####Composer
Pakethanterare för PHP, helt klart intressant. Att lätt inkludera andras projekt är suveränt för en open-source programmerare. 

####Packagist
Det finns miljontals paket på packagist, några intressanta jag hittade är [Twig](https://packagist.org/packages/twig/twig "Twig") och [phpunit](https://packagist.org/packages/phpunit/phpunit "phpunit").


####Problem
Många problem...

Anax-MVC var inte uppdaterat till senaste. Fick problem redan efter man hade kopierat vyerna. Fick göra en git clone och starta om från början. Mitt egna Git repository är nu helt meningslöst, tror att jag ska lösa det genom att forka från Mos istället för att bara kopiera det.

Ytterligare ett problem uppstår...

`(13:23:48) (@Olund) Bobbzorzen: vad fan är det för fel på kmom02`

Jag hade problem med att editera den första kommentaren, alla andra fungerade. ID blev fel? Efter många försök och ändringar i CommentController och CommentsInSession löstes problemet och jag blev överlycklig.

`(14:18:37) (@Olund) Jag LÖSTE DET`

`(14:24:57) (@Bobbzorzen) Belöna dig själv med en chokladboll ;P`

####Begrepp
Svårt var det. Svårt att förstå hur allt hänger ihop. 
Att `<?=$this->url->create('comment/add')?>` mappas till addAction metoden i CommentController klassen var riktigt snyggt, fast svårt att jobba med. 

####Svagheter/Förbättringar
Inga svagheter eller förbättringar jag kan säga just nu. Känner mig fortfarande väldigt novis i MVC.


####Tankar..
Onödigt att göra detta kursmomentet i sessions, tycker vi skulle kunna använda en databas direkt från början. Ingen annan kan se mina kommentarer just nu. Varför inte göra det korrekt från början....
Annars ett svårt men helt klart intressant kursmoment!



Kmom03: Bygg ett eget tema
------------------------------------
Äntligen klar med kursmoment 3. Massa pill för att få allting att fungera, tålamodet var rätt lågt vid flera tidpunkter.



####CSS-Ramverk



####LESS, lessphp och Semantic.gs



####Gridbaserad layout, vertikalt och horisontellt



####Font awesome, Bootstrap, Normalize



####Mitt tema












