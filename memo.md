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

## Gestion des photos

```php
❯ composer require vich/uploader-bundle
```

**vich_uploader.yaml**

```yaml
vich_uploader:
  db_driver: orm

  mappings:
    property_image:
      uri_prefix: /images/properties
         upload_destination: '%kernel.project_dir%/public/images/properties'
```

**Property.php | entity**

```php
<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


// Validation
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Unique;

// Upload
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;




/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity("title")
 */

class Property
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(
     * min = 3,
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    public $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer");
     * @Assert\Range(
     *      min = 10,
     *      max = 1000,
     *      notInRangeMessage = "La surface doit être comprise entre {{ min }}m² et {{ max }}m²"
     * )
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     * min = 1,
     * max = 100,
     * minMessage= "Vous devez renseigner au minimum {{ min }} pièce",
     * maxMessage= "Vous devez renseigner au maximum {{ max }} pièce",
     * )
     */
    private $rooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     * min = 1,
     * max = 100,
     * minMessage= "Vous devez renseigner au minimum {{ min }} chambre",
     * maxMessage= "Vous ne pouvez renseigner maximum {{ max }} chambres",
     * )
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     * min = 0,
     * max = 20,
     * minMessage= "L'étage ne peut pas négatif",
     * maxMessage= "L'étage ne peut pas être supérieur à 10",
     * )
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "La ville ne peut contenir moins de  {{ limit }} caractères.",
     *      maxMessage = "La ville ne peut contenir plus de  {{ limit }} caractères.",
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $postale_code;

    /**
     * @ORM\Column(type="boolean", options ={"default":false}))
     */
    private $sold;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Heat::class, inversedBy="properties")
     */
    public $heat;

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="properties")
     *
     */

    private $options;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     *
     */
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="fileName")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    public function __construct()
    {
        // set creat_at default value at actual time
        $this->created_at = new \DateTime();

        // set default value of sold to false
        $this->sold = false;
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }




    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostaleCode(): ?int
    {
        return $this->postale_code;
    }

    public function setPostaleCode(int $postale_code): self
    {
        $this->postale_code = $postale_code;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 0, '', ' ');
    }


    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = (new Slugify())->slugify(strtolower($slug));

        return $this;
    }

    public function getHeatType(): string
    {
        return $this->heat->getType();
    }

    public function setHeatType(?Heat $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addProperty($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->removeElement($option)) {
            $option->removeProperty($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Get the value of fileName
     *
     * @return  string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     *
     * @param  string|null  $fileName
     *
     * @return  self
     */
    public function setFileName(?string $fileName): Property
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get the value of imageFile
     *
     * @return  File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
}

```

```php
❯ php bin/console make:migration
```

### Ajouter un champ pour les photos

```twig
{% extends 'base.html.twig' %}

{% block title  %}
	Éditer |
	{{property.title}}
{% endblock %}


{% block body %}
	<div class="container mt-4">
		<h1>
			{% block bigTitle %}
				Éditer les biens
			{% endblock %}
		</h1>

		{{form_start(form)}}

		<div class="row">
			<div class="col-md-4">{{form_row(form.title)}}</div>
			<div class="col-md-4">{{form_row(form.surface)}}</div>
			<div class="col-md-4">{{form_row(form.price)}}</div>
		</div>

		<div class="row">
			<div class="col-md-3">{{form_row(form.rooms)}}</div>
			<div class="col-md-3">{{form_row(form.bedrooms)}}</div>
			<div class="col-md-3">{{form_row(form.heat)}}</div>
			<div class="col-md-3">{{form_row(form.floor)}}</div>
		</div>
		<div class="row">
			<div class="col-md-2">{{form_row(form.imageFile)}}</div>
			<div class="col-md-3">{{form_row(form.address)}}</div>
			<div class="col-md-2">{{form_row(form.city)}}</div>
			<div class="col-md-3">{{form_row(form.postale_code)}}</div>
			<div class="col-md-2">{{form_row(form.sold)}}</div>

		</div>


		{{form_row(form.description)}}
		<div class="col-md-6"></div>


		{{form_rest(form)}}
		<button class="btn btn-primary">
			{% block createEdite %}
				A DEFINIR
			{% endblock %}
		</button>
		{{form_end(form)}}
	</div>
{% endblock %}
```

### show

```twig
{% if property.filename %}
    <img src="{{vich_uploader_asset(property,"imageFile")}}" alt="" class="card-img-top" style="width: 100%;height:auto;">

{% endif %}
```

### Redimensionner les images

```php
composer require liip/imagine-bundle
```

### configuration du filtre de redimentionnement

```yaml
# See dos how to configure the bundle: https://symfony.com/doc/current/bundles/LiipImagineBundle/basic-usage.html
liip_imagine:
  # valid drivers options include "gd" or "gmagick" or "imagick"
  driver: "gd"

  filter_sets:
    thumb:
      quality: 75
      filters:
        thumbnail:
          seize: [360, 230]
          mode: outbound
```

### Supression du cache

Il est possible d'utiliser doctrine avec des évènements

#### Création du service

```zsh
mkdir src/Listener/;
touch  src/Listener/ImageCacheSubscriber.php;
```

```php
<?php

namespace App\Listener;

use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping\PreRemove;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     *
     * @var UploadHelper
     */
    private $uploaderHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    // TODO: implement getSubscriberEvents() method
    // Les evenements à écouter
    public function getSubscribedEvents()
    {

        return [
            'preRemove',
            'preUpdate'
        ];
    }

    /**
     *
     * @return void
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Property) {
            return;
        }

        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    /**
     * @return void
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Property) {
            return;
        }
        if ($entity->getImageFile() instanceof UploadedFile) {
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }
}

```

#### Activer le service dans service.yaml

```yaml
# This file is the entry point to configure your own services.
# Files in the packages/ subdirectory configure your dependencies.

# Put parameters here that don't need to change on each machine where the app is deployed
# https://symfony.com/doc/current/best_practices/configuration.html#application-related-configuration
parameters:

services:
  # default configuration for services in *this* file
  _defaults:
    autowire: true # Automatically injects dependencies in your services.
    autoconfigure: true # Automatically registers your services as commands, event subscribers, etc.

  # makes classes in src/ available to be used as services
  # this creates a service per class whose id is the fully-qualified class name
  App\:
    resource: "../src/"
    exclude:
      - "../src/DependencyInjection/"
      - "../src/Entity/"
      - "../src/Kernel.php"
      - "../src/Tests/"

  # controllers are imported separately to make sure services can be injected
  # as action arguments even if you don't extend any base controller class
  App\Controller\:
    resource: "../src/Controller/"
    tags: ["controller.service_arguments"]

  # add more service definitions when explicit configuration is needed
  # please note that last definitions always *replace* previous ones
  App\Listener\ImageCacheSubscriber:
    tags:
      name: doctrine.event_subscriber
```
