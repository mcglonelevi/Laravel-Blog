<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PostDeleteForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('delete', 'submit', [
              'attr' => [
                'class' => 'btn btn-danger pull-right'
              ]
            ]);
    }
}
