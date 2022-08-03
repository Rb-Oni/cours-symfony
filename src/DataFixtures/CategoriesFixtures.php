<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Informatique', null, 1, $manager);

        $this->createCategory('Ordinateurs portables', $parent, 3, $manager);
        $this->createCategory('Ecrans', $parent, 2, $manager);
        $this->createCategory('Souris', $parent, 4, $manager);

        $parent = $this->createCategory('Mode', null, 5, $manager);

        $this->createCategory('Homme', $parent, 8, $manager);
        $this->createCategory('Femme', $parent, 7, $manager);
        $this->createCategory('Enfant', $parent, 6, $manager);

        $manager->flush();
    }
    public function createCategory(string $name, Categories $parent = null, int $categoryOrder, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setCategoryOrder($categoryOrder);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-' . $this->counter, $category);
        $this->counter++;

        return $category;
    }
}
