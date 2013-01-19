filterGuestView
===============

Plugin for WBB forum, allows to filter the display of posts for guests

Features
 * Es können beliebige feste oder variable Begriffe durch einen anderen Begriff ausgeblendet werden (auch mehrzeilig)
 * Das Plugin wirkt auf alle Beiträge die ein Gast sehen kann
 * Man kann es ein- und ausschalten, auch pro Forum
 * deutsch, deutsch-du und english liegen bei


Beschreibung/Anwendung
Man kann natürlich beliebige Begriffe wählen, von denen man nicht will, das Gäste sie sehen können.
Die Ersetzung kann natürlich beliebig angepasst werden,
die Variablen heißen wbb.thread.filterguestmessage und wbb.thread.filterguestmessage.html.

wbb.thread.filterguestmessage.html wirkt bei gecachten Beiträgen, dort kann man (nur) HTML einsetzen.
wbb.thread.filterguestmessage ist per BBCode zu formatieren.

Die Plugin-Optionen finden sich unter System => Optionen => Nachrichten => Gästeansicht filtern.
Derzeit wirken die Modifikatoren isU auf den RegEx.
Achtung! Um korrekt alle Beiträge zu filtern muss man sowohl nach BB-Code wie auch nach HTML filtern!
Das ist notwendig, weil neuere Beiträge gecacht sind und daher direkt in HTML vorliegen und nicht extra geparst werden!

Beispiele

z.B. kann man alle URLs ausblenden: <a href=\"http://*>*</a> Man gebe diesen String an und aus allen URLs wird "(Dieser Begriff wurde für Gäste ausgeblendet. Um ihn doch lesen zu können sollten Sie sich anmelden!)" Man will einen Link auf die Registrierung setzen.
Dazu schreibt man in

wbb.thread.filterguestmessage: [url='index.php?page=Register']TEXT[/url]

und in

wbb.thread.filterguestmessage.html: <a href=\"index.php?page=Register\">TEXT</a>


Diverse Regular Expressions

    URLs:
        HTML: <a href=*>*</a>
        BB-Code: [url*[/url]

    Video:
        HTML: <object*</object>
        BB-Code:
        [youtube]*[/youtube]
        [myvideo]*[/myvideo]
        [myspace]*[/myspace]
        [googlevideo]*[/googlevideo]
        [clipfish]*[/clipfish]
        [sevenload]*[/sevenload]
        [video]*[/video]

    Quotes:

    HTML: <blockquote class="quoteBox">*</blockquote>
    BB-Code: [quote*


Codeblöcke (PHP, MySQL, usw):

    HTML: <div class="codeBox">*<div>*<table>*</table>*</div>*</div>
    BB-Code:
    [code]*code]
    [php]*[/php]
    [mysql]*[/mysql]

Bilder:

    HTML: <img*>
    BB-Code:
    [img]*[/img]


Links

    Beispiel: Allgemein gnod
    Regular Expressions: http://www.regenechsen.de/phpwcms/index.php?regex
    RegEx?-Modifikatoren: http://www.regenechsen.de/phpwcms/index.php?regex_allg_liste
