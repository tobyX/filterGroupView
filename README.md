filterThreadView
===============

Plugin for WBB forum, allows to filter the display of posts for any groups

Features
 * Es können vorgegebene Begriffe gefiltert werden, aber natürlich auch eigene Begriffe
 * Das Plugin wirkt auf alle Beiträge und kann durch Gruppenrechte verändert werden.
 * Man kann es pro Forum für Benutzer oder Gruppen ein- oder ausschalten
 * de, de-informal und en liegen bei
 * Man kann Beiträge kürzen lassen


Beschreibung/Anwendung
Man kann natürlich beliebige Begriffe wählen, von denen man nicht will, das jemand sie sehen kann.
Die Ersetzung kann natürlich beliebig angepasst werden, die Variablen heißen wbb.thread.filterguestmessage.
wbb.thread.filterguestmessage ist per BBCode zu formatieren.
Es gibt zusätzlich noch wbb.thread.filtergrouptruncatedmessage, was bei gekürzten Beiträgen verwendet wird.

Derzeit wirken die Modifikatoren isU auf den RegEx.
Es muss nur noch nach BBCode gefiltert werden, bei gecachten Beiträgen wird der Cache genullt. Das kann die Performance beeinträchtigen.

Die Optionen finden sich unter:

System -> Optionen -> Module an/aus -> Inhalte -> Filter / Filter Feeds
System -> Optionen -> Forum -> Beiträge -> Beitragsinhalte filtern

Das Gruppenrecht findet sich unter:

Allgemeine Rechte -> Forum -> Kann gefilterte Inhalte sehen

Das Forumrecht heißt:
"Kann gefilterte Inhalte sehen"

Damit kann man auf Forenebene die Filterung für beliebige Gruppen und Benutzer ein- und ausschalten.
