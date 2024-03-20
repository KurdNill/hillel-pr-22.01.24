<?php

namespace App\Validators\Folders;

class UpdateFolderValidator extends CreateFolderValidator
{

    protected array $skip = ['user_id', 'updated_at'];
}