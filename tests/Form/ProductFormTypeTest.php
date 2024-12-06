<?php

namespace App\Tests\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\CategoryRepository;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormFactoryInterface;

class ProductFormTypeTest extends KernelTestCase
{
    private Category $category;

    protected function setUp(): void
    {
        $this->category = $this->createCategory();
    }

    public function testSubmit(): void
    {
        $formFactory = self::getContainer()->get(FormFactoryInterface::class);

        $category = $this->createCategory();
        $faker = Factory::create();
        $name = $faker->word();
        $description = $faker->sentence();
        $price = $faker->randomFloat(2, 0, 100);
        $formData = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category' => $this->category->getId(),
        ];

        $product = new Product();

        $form = $formFactory->create(ProductFormType::class, $product);
        $form->submit($formData);

        $expected = new Product();
        $expected->setName($name);
        $expected->setDescription($description);
        $expected->setPrice($price);
        $expected->setCategory($this->category);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $product);
    }

    private function createCategory(): Category
    {
        /** @var CategoryRepository $repository */
        $repository = self::getContainer()->get(CategoryRepository::class);
        $faker = Factory::create();
        $name = $faker->word();
        $category = new Category();
        $category->setName($name);
        $repository->getEntityManager()->persist($category);
        $repository->getEntityManager()->flush();
        return $category;
    }
}
