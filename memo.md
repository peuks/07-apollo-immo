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

## Controller dans un namespace séparé

```
mkdir src/Admin && touch src/Admin/AdminPropertyController.php
```

```php
// src/Admin/AdminPropertyController.php
<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    /**
     * @Route("/admin/property", name="admin_property")
     */
    public function index(): Response
    {
        return $this->render('admin_property/index.html.twig', [
            'controller_name' => 'AdminPropertyController',
        ]);
    }
}
```

## Securité

Création de la class utilisateur qui doit avoir la UserInterface
