# Haushalts App

Dies ist eine PHP8 Webseite um einen Haushaltsplan zu verwalten.
Die App kann Einträge in der Exceldatei speichern und auflisten.
Desweitern kann man die Exceldatei herunterladen.

## Installation lokal

Der Interpreter PHP8.1 kann über folgenden Link heruntergeladen werden

[PHP8.1 Website](https://windows.php.net/download#php-8.1)

[PHP8.1 Download Link](https://windows.php.net/downloads/releases/php-8.1.6-Win32-vs16-x64.zip)

1. Das haushalt Projekt in einem Ordner speichern
2. Die ZIP Datei in einem Nebenordner von dem Projekt entpacken.
3. Die haushalt App im Datei Explorer öffnen und mit gedrückter shift Taste mit der rechten Maustaste in das Explorer Verzeichnis klicken. [Tutorial](https://www.howtogeek.com/165268/how-to-add-open-powershell-here-to-the-context-menu-in-windows/)
4. Mit diesem Befehl den lokalen Server starten `.\..\php-8.1.6-Win32-vs16-x64\php.exe -S localhost:3000 -t public/`
5. Die Website unter http://localhost:3000/ öffnen

## Benutzung

Auf der haushalt App gibt es eine `Übersicht` Seite mit der man über das Menü in die Erstellen, Listen und Download funktion wechseln kann.

Die Erstellen Seite ermöglicht es neue Einträge in der App zu erstellen und zu speichern.

Die Listen Seite listet die erstellten Einträge aus der Datei unter /public/dateien/excel.xslx auf.

Der Download Link startet einen Download der /public/dateien/excel.xslx 
