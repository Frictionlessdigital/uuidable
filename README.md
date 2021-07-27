# FLS :: Uuidable

Add [UUID](https://en.wikipedia.org/wiki/Universally_unique_identifier) behavior to your Eloquent models.

## Installation

```bash
composer require "frictionlessditial\uuidable":"^1.0"
```

Note that root namespace for the package is `Fls` not `Frictionlessditial`.

### Config

The package does not require configuration.

## Integration

To add behavior to your model, simply import the trait:
```php
use Fls\Uuidable\Uuidable;

class User extends Model
{
    use Uuidable;
    ...
}
```

If you want to update the field to within which the UUID is stored, define a static model propery like so:

```php
use Fls\Uuidable\Uuidable;

class User extends Model
{
    use Uuidable;
    ...

    /**
     * Name of the field to to store the UUID
     *
     * @var string
     */
    const UUID = 'diuu';
}
```

## Usage

`Fls\Uuidable\Uuidable` trait adds a number of methods to your model:

### Uuidable::findByUuid

Similar to `find($key)`, `findByUuid($uuid)` will locate the first Uuidable model where the value of the fild matches the argument.
```php
$user  = User::findByUuid(string $uuid);
```

You can also pass an array of column you want to hydrate from the database as a second argument:

```php
$user  = User::findByUuid(string $uuid, ['email', 'password']);
```

Under the hood the method relies on `whereUuid()`

### Uuidable::whereUuid()

Scope the model by uuid value. You can use a string value, an array, pass in Arrayable class. **N.B.** *if you pass an Eloquent Collection, it will be parsed for its model keys, which will be passed as a scoping argument.*

```php
$builder  = User::whereUuid(string $uuid);
```
or
```php
$builder  = User::whereUuid([$uuid]);
```
or
```php
$builder  = User::whereUuid(collect([$uuid]));
```
or
```php
$builder  = User::whereUuid(Users::pluck('uuid'));
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email support@frictionlesssolutions.com instead of using the issue tracker.

## Credits

- [Cyrill N Kalita][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/nickfls
[link-contributors]: ../../contributors

___

<p align="center"><a href="http://frictionlesssolutions.com" title="Fricitonless Solutions Inc."><img src="./resources/docs/gramma.png"></a></p>
