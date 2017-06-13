<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PostEditForm extends Form
{
    public function buildForm()
    {
        $tagsText = $this->model->tags->pluck('title')->toArray();
        $tagsText = implode(", ", $tagsText);
        $this
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('tags', 'text', [
              'value' => $tagsText
            ])
            ->add('submit', 'submit');
    }
}
