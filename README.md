# Simple work with directories
This package allows you to simply work with directories. Create, delete, rename and empty directories.

## Installation
You can install the package via composer:

```composer require grinderspro/directory-manipulator```

## Usage

### Simple create a directory

To create a directory, use the ```create()``` method. If you use the ```create()``` method without parameters, then the directory will be created in the temporary system folder by default.

```php
require __DIR__ . '/vendor/autoload.php';

use Grinderspro\DirectoryManipulator\DirectoryManipulator;

(new DirectoryManipulator())->create();
```

Create many directories

```php
$dm = (new DirectoryManipulator())->location('/var/tmp/')->clear();

for ($i=1; $i<=10; ++$i) {
    $dm->name('gm'.$i)->create();
}
```

Create directory - "/var/tmp/{time()}"

```php
(new DirectoryManipulator())->location('/var/tmp/')->name()->create();
```

Create directory - "/var/tmp/grinderspro"

```php
(new DirectoryManipulator())->location('/var/tmp/')->name('grinderspro')->create();
```
```php
(new DirectoryManipulator())->location('/var/tmp/grinderspro')->create();
```

```php
if((new DirectoryManipulator())->location('/var/tmp/grinderspro')->create())
    return true;
```

To get the full path of the newly created directory, use the ```path()``` method without parameters.

```php
$dirName = (new DirectoryManipulator())->create('/var/tmp/')->name()->path();
```

### Delete directories

```php
(new DirectoryManipulator())->location('/var/tmp/')->name('grinderspro')->delete();
```

```php
(new DirectoryManipulator())->location('/var/tmp/grinderspro')->delete();
```

### Clear directory

```php
(new DirectoryManipulator())->location('/var/tmp/grinderspro')->clear();
```