PHP EOL CSV Class
=============

This exists for one specific purpose - to provide a class for creating CSV files in PHP, while also allowing you to set a custom end-of-line character.

fputcsv allows you to specify a field delimiter, but strangely doesn't let you set the EOL character - which, when it insists on \n, isn't much use for files destined for Windows based systems.

I may extend this to do more in future, but for now it does exactly what I needed it for.
