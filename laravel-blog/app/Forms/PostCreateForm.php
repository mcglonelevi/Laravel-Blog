<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Illuminate\Support\Facades\Auth;

class PostCreateForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('user_id', 'hidden', [
              'value' => Auth::user()->id
            ])
            ->add('tags', 'text')
            ->add('submit', 'submit');
    }
}
