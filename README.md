
Installation
============
```bash
composer require ob-ivan/sd-debugger
```


Usage
=====
```php
// Enable or disable depending on your environment
debug()->enable(isset($_GET['debug']));

// Only print/log if debug is enabled
debug()->pre('ids', $ids);
debug()->log('ids', $ids);

// Always print/log
debug(true)->log('ids', $ids);
```
