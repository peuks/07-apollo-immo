We can send to the view a formattedPrice by creating a new function in our controller

```php
  public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }
```

Slug can be directly defined in Property Entity

```php
composer require cocur/slugify
```

```php
    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }
```
