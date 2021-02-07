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

## système de recherche

Le Système de recherche n'est pas liée à la BDD. Il faut créer une entitée manuellement puis un formulaire qui va avec.

### PropertySeach Entity

```zsh
touch src/Entity/PropertySeach.php
```

```php
<?php
class PropertySearch
{
    /**
     * @var int|null
     * La variable peut être un entier ou null si aucune recherche n'est faite
     */
    private $maxPrice;

    /**
     * @var int|null
     * La variable peut être un entier ou null si aucune recherche n'est faite
     */
    private $minSurface;

    /**
     * Get la variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @return  int|null
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set la variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @param  int|null  $maxPrice  La variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @return  self
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get la variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @return  int|null
     */
    public function getMinSurface()
    {
        return $this->minSurface;
    }

    /**
     * Set la variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @param  int|null  $minSurface  La variable peut être un entier ou null si aucune recherche n'est faite
     *
     * @return  self
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface = $minSurface;

        return $this;
    }
}

```

### Pagination

```zsh
composer require knplabs/knp-paginator-bundle
```

**Créer le fichier de configuration**

```zsh
touch config/packages/knp.paginator.yaml
```

Il faut modifier notre Repository

```php
    public function findAllAvailableQuery($sold = "false", $order = "ASC"): Query
    {
        // QueryBuilder('p') is a an objcet that let us construct ( concevoir ) a query with an alias 'p'
        return $this->findVisibleQuery($sold, $order)
            // Check every Property still avaible ( not sold )
            ->getQuery();

        // On veut que la requeête pour la pagination
        // ->getResult();
    }
```

```yml
knp_paginator:
  page_range: 5 # number of links showed in the pagination menu (e.g: you have 10 pages, a page_range of 3, on the 5th page you'll see links to page 4, 5, 6)
  default_options:
    page_name: page # page query parameter name
    sort_field_name: sort # sort field query parameter name
    sort_direction_name: direction # sort direction query parameter name
    distinct: true # ensure distinct results, useful when ORM queries are using GROUP BY statements
    filter_field_name: filterField # filter field query parameter name
    filter_value_name: filterValue # filter value query parameter name
  template:
    pagination: "@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig" # sliding pagination controls template
    sortable: "@KnpPaginator/Pagination/sortable_link.html.twig" # sort link template
    filtration: "@KnpPaginator/Pagination/filtration.html.twig" # filters template
```

#### Fonction index dans propertyController.php

```php

    /**
     * @Route("/biens", name="property.index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        // Get all not solded properties ( all availables )
        $properties = $paginator->paginate(
            $this->em->findAllAvailableQuery("false"),
            $request->query->getInt('page', 1), /*page number*/
            12
        );
        // $this->em->findAllAvailable("false");

        // Send properties to the view
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            // 'formSearch' => $form->createView()
        ]);
    }
```

#### insérer la pagination dans twig

```twig
{% extends 'base.html.twig' %}

{% block title %}
	Voir tous nos biens
{% endblock %}

{% block body %}
	<div class="jumbotron">
		<div class="container">{# {{form_start(formSearch)}} #}
			{# {{form_end(formSearch)}} #}
		</div>
	</div>
	<div class="container mt-4">
		<h1>Voir tous nos biens</h1>
		<div class="row">
			{% for property in properties %}
				<div class="col-md-4">
					{% include "property/_property.html.twig" %}
				</div>
			{% endfor %}
		</div>
		<div class="pagination">
			{{ knp_pagination_render(properties) }}
		</div>
	</div>
{% endblock %}
```

### Formulaire de PropertySeach Entity

```php
❯ php bin/console make:form PropertySearchType

 The name of Entity or fully qualified model class name that the new form will be bound to (empty for none):
 > \App\Entity\PropertySearch

 created: src/Form/PropertySearchType.php
  Success!

 Next: Add fields to your form and start using it.
 Find the documentation at https://symfony.com/doc/current/forms.html
```

```php
<?php

namespace App\Form;

use App\Entity\PropertySearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface Minimale'
                ]
            ])
            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget Maximal'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            // Research must be done with get method
            'method' => 'get',
            // We don't need a token for a research
            'csrf_protection' => false
        ]);
    }
}
```

### Gestion des options

Chercher les biens en fonction des tags: près de la mere, appart avec ascenseur ...

Il faut une créer une entité pour les options qui sera lié aux propriétés

```bash
❯ php bin/console make:entity Option

 created: src/Entity/Option.php
 created: src/Repository/OptionRepository.php

 Entity generated! Now let\'s add some fields!
 You can always add more fields later manually or by re-running this command.

 New property name (press <return> to stop adding fields):
 > name

 Field type (enter ? to see all types) [string]:
 >

 Field length [255]:
 >

 Can this field be null in the database (nullable) (yes/no) [no]:
 >

 updated: src/Entity/Option.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 > properties

 Field type (enter ? to see all types) [string]:
 > relation

 What class should this entity be related to?:
 > Property

What type of relationship is this?
 ------------ ----------------------------------------------------------------------
  Type         Description
 ------------ ----------------------------------------------------------------------
  ManyToOne    Each Option relates to (has) one Property.
               Each Property can relate to (can have) many Option objects

  OneToMany    Each Option can relate to (can have) many Property objects.
               Each Property relates to (has) one Option

  ManyToMany   Each Option can relate to (can have) many Property objects.
               Each Property can also relate to (can also have) many Option objects

  OneToOne     Each Option relates to (has) exactly one Property.
               Each Property also relates to (has) exactly one Option.
 ------------ ----------------------------------------------------------------------

 Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
 > ManyToMany

 Do you want to add a new property to Property so that you can access/update Option objects from it - e.g. $property->getOptions()? (yes/no) [yes]:
 > yes

 A new property will also be added to the Property class so that you can access the related Option objects from it.

 New field name inside Property [options]:
 >

 updated: src/Entity/Option.php
 updated: src/Entity/Property.php

 Add another property? Enter the property name (or press <return> to stop adding fields):
 >



  Success!


 Next: When you\'re ready, create a migration with php bin/console make:migration
```

#### Création du CRUD pour Option

AdminOptionController

```php
<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Form\OptionType;
use Doctrine\ORM\EntityManager;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Componenté\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminOptionController extends AbstractController
{
    /**
     *
     * @var OptionRepository
     */

    private $repository;
    protected $em;

    public function __construct(OptionRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/options", name="admin.option.index")
     */
    public function index()
    {
        // Get all Options objects from DB
        $options = $this->repository->findAll();

        // send option in our index view
        return $this->render('admin/option/index.html.twig', compact('options'));
    }

    /**
     * @Route("/admin/option/{id}/edit/", name="admin.option.edit", methods="GET|POST")
     * @Route("/admin/option/create/", name="admin.option.create", methods="GET|POST")
     */
    public function createEdit(Option $option = null, Request $request)
    {
        if (!$option) {
            $option = new Option;
            $statue = 'crée';
        } else {
            $statue = 'édité';
        }
        // Utiliser une instance du formaulaire de Property avec les valeur de $options
        $form = $this->createForm(OptionType::class, $option);

        // Gérer la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // persist to the DB

            $this->em->persist($option);

            // Write into DB
            $this->em->flush();

            // Success Message

            $this->addFlash("sucess", "Le bien a bien été $statue");

            return $this->redirectToRoute('admin.option.index', [], 301);
        }

        // Formulaire à envoyer à la vue
        $form = $form->createView();


        $currentRoute = $request->attributes->get('_route');

        // En fonction de la route , envoyer la vue edition ou creation

        if ($currentRoute == 'admin.option.create') {
            return $this->render('admin/option/create.html.twig', ['property' => $option, 'form' => $form]);
        } else {
            return $this->render('admin/option/edite.html.twig', ['property' => $option, 'form' => $form]);
        }
    }

    /**
     * @Route("/admin/option/{id}/delete/", name="admin.option.delete")
     */
    public function delete(Option $option)
    {
        // Déclarer la suppression à l'entity manager
        $this->em->remove($option);

        // Supprimer de la base de donnée
        $this->em->flush();

        $this->addFlash("sucess", "Le bien a bien été supprimé");


        // Redirect to home page | Admin page
        return $this->redirectToRoute('admin.option.index', [], 301);
    }
}
```

Reprendre La configuration pour la vue à partir de AdminPropertyController

### La relation ManyToMany

Lorsqu'on édite le bien , on veut enrengistrer les options dans le bien.

Dans notre cas on est dans une ManyToMany bidirectionnelle

Un des elements de relation est propriétaire et c'est sur le propriétaire que l'on pourra utiliser la méthode add.

Le propriétaire **_est définit_** par le `inversedBy`

On veut que le propriétaire soit Property !!!

**PropertyController.php**

```php
/**
 * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="properties")
 */
private $options;
```

**OptionController.php**

```php
/**
 * @ORM\ManyToMany(targetEntity=Property::class, mappedBy="options")
 */
private $properties;
```

Si je veux avoir la propriété sur Property il faut donc

    * Créer l'option
    * Revenir sur Propriété et insérer une ligne options
    * Définir options en relation avec Option

### Modification SearchType

Ici on rajoute une ligne pour les options

```php
<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget Maximal'
                ]
            ])
            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface Minimale'
                ]
            ])
            ->add('options', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            // Research must be done with get method
            'method' => 'get',
            // We don't need a token for a research
            'csrf_protection' => false
        ]);
    }
    public function getBlockPrefix()
    {
        // Ne retien retourner comme prefix dans l'url
        // Avant https://localhost:8000/biens?property_search%5BminSurface%5D=&property_search%5BmaxPrice%5D=15
        // Après https://localhost:8000/biens?minSurface=11&maxPrice=16
        return '';
    }
}

```

### Modification SearchRepository

Il faut rajouter getter and setter pour récupérer les options

```php
/**
     * Get the value of options
     *
     * @return  ArrayCollection
     * Will return an empty ArrayCollection getOptions is null
     */
    public function getOptions()
    {
        return ($this->options === null) ?  new ArrayCollection : $this->options;
    }
```

### Modification du repository

```php
    public function findAllAvailableQuery(PropertySearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getMaxPrice()) {
            $query = $query
                ->andWhere('p.price <= :maxprice')
                ->setParameter('maxprice', $search->getMaxPrice());
        }

        if ($search->getMinSurface()) {

            $query = $query
                ->andWhere('p.surface >= :minsurface')
                ->setParameter('minsurface', $search->getMinSurface());
        }
        if ($search->getOptions()->count() > 0) {
            $key = 0;
            foreach ($search->getOptions() as $key => $option) {
                $key++;
                $query = $query
                    ->andWhere(":option$key MEMBER OF p.options")
                    ->setParameter("option$key", $option);
            }
        }
        return $query->getQuery();

        // On veut que la requeête pour la pagination
        // ->getResult();
    }
```
