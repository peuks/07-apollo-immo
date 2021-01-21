We can send to the view a formattedPrice by creating a new function in our controller

```php
  public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }
```
