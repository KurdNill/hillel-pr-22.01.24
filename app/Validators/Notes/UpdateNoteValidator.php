<?php

namespace App\Validators\Notes;

use App\Models\Folder;

class UpdateNoteValidator extends Base
{
    protected array $rules = [
        //'title' => '/[\w\s\(\)\-]{3,}/i',
        //'content' => '/.+/i',
        //'folder_id' => '/\d+/i'
    ];

    protected array $errors = [
        //'title' => 'Title should contain characters, numbers and _-() symbols and has length more than 2 symbols',
        //'content' => 'Minimum length 1 symbol',
        //'folder_id' => 'folder id should be exists in request and has type integer'
    ];

    protected array $skip = ['user_id', 'folder_id', 'updated_at', 'pinned', 'completed', 'created_at'];

    public function validate(array $fields = []): bool
    {
        //validate folder id
        //перевірити назву чи не повторюється та чи це не специфічна папка
        //перевірити на bool значення [pinned, completed]
        return !in_array(false, [
            parent::validate($fields),
            $this->isBoolean($fields, 'pinned'),
            $this->isBoolean($fields, 'completed'),
            $this->validateFolderId($fields, false),
            $this->checkTitle($fields),
            $this->checkContent($fields),
        ]);
    }
}