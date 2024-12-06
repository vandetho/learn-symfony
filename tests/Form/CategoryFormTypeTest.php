<?php

namespace App\Tests\Form;

use App\Entity\Category;
use App\Form\CategoryFormType;
use Symfony\Component\Form\Test\TypeTestCase;

class CategoryFormTypeTest extends TypeTestCase
{
    public function testSubmit(): void
    {
        $formData = [
            'name' => 'Category 1',
        ];

        $category = new Category();

        $form = $this->factory->create(CategoryFormType::class, $category);
        $form->submit($formData);

        $expected = new Category();
        $expected->setName('Category 1');
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $category);
    }
}
