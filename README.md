func-mimetype
=============

Mimetype helper functions

Usage
----
```php
ld('func/mimetype');

$file = 'test.html';
$mimetype = system_extension_mime_type($file); //returns text/html
$ext = system_mime_type_extension('text/html'); //returns .html
```

Reference
----

### (string) system_extension_mime_type($file)
Returns the mime type purely by file extension

### (string) system_mime_type_extension($mimetype)
Returns the file extension assoicated with the mime type

