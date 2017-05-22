<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PostEditForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('submit', 'submit');
    }
}
