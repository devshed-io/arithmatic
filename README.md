<br><br>
<h1 width="400" align="center" >Arithmatic</h1>
<p align="center">
    <a href="https://github.com/devshed-io/arithmatic/actions/workflows/phpunit.yml"><img src="https://github.com/devshed-io/arithmatic/actions/workflows/phpunit.yml/badge.svg" alt="Tests"></a>
    <a href="https://github.com/devshed-io/arithmatic/releases"><img src="https://img.shields.io/github/v/release/devshed-io/arithmatic?label=Latest%20Release" alt="Latest Release"></a>
    <a href="https://packagist.org/packages/devshed-io/aritmatic"><img src="https://img.shields.io/packagist/l/devshed-io/arithmatic" alt="License"></a>
    <a href="https://packagist.org/packages/devshed-io/arithmatic"><img src="https://img.shields.io/packagist/dt/devshed-io/arithmatic" alt="Total Downloads"></a>
</p>

Chainable math methods for PHP. Designed to make working with math more fluent and easier to read.

### Installation (via Composer)

```bash
composer require devshed-io/arithmatic
```

### Usage

Basic usage allows you to chain methods for better readability:
```php
Arithmatic
    ::start(5)
    ->add(5)
    ->subtract(7);
    ->divide(2);
    ->multiply(7)
    ->output();
```

The when method will execute the given callback when the first argument given to the method evaluates to true:
```php
Arithmatic
    ::start(10)
    ->when(true, fn (Arithmatic $calculation) => $calculation->subtract(5))->output();
```

When also provides a third method that will run when the conditional evaluates to false:
```php
Arithmatic
    ::start(10)
    ->when(
        false,
        fn (Arithmatic $calculation) => $calculation->subtract(5),
        fn (Arithmatic $calculation) => $calculation->add(5), // This will run...
    )
    ->output();
```

Arithmatic also provides the underlying run API so you can chain methods with arrays:
```php
Arithmatic
    ::make(10)
    ->run([
        'add' => 5,
        'divide' => 2,
        'round'
    ])
    ->output(); // 3
```

N.B. Unless you call `output`, arithmatic will provide an instance of itself. It can be coerced to a string using the `__toString()` or `(string)` methods.

### Available Methods
- percentageOf
- percentageChange
- divide
- subtract
- add
- multiply
- mean
- round
- clamp
- clone

### Testing (with Docker Compose)

```bash
docker-compose run --rm php vendor/bin/phpunit --testdox
```

### License

[MIT license](https://opensource.org/licenses/MIT)
