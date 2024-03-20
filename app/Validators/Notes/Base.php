<?php

namespace App\Validators\Notes;

use App\Validators\BaseValidator;
use App\Models\{
    Folder,
    Note
};
use function Core\authId;
use Enums\SQL;

class Base extends BaseValidator
{
    protected array $skip = ['user_id', 'updated_at', 'pinned', 'completed', 'created_at'];

    protected function isBoolean(array $fields, string $key): bool
    {
        if (empty($fields[$key])) {
            return true;
        }

        $result = is_bool($fields[$key]) || $fields[$key] === 1;

        if (!$result) {
            $this->setError($key, "[$key] should be boolean");
        }

        return $result;
    }

    public function validateFolderId(array $fields, bool $isRequired = true): bool
    {
        if (empty($fields['folder_id']) && !$isRequired) {
            return true;
        }

        if (!is_int($fields['folder_id'])) {
            $this->setError('folder_id', 'folder id повинен мати значення int');
            return false;
        }

        $shared = Folder::where('title', value: Folder::SHARED_FOLDER)->take();

        if ($fields['folder_id'] === $shared->id) {
            $this->setError('folder_id', 'You can not create notes in shared folder');
            return false;
        }

        return Folder::where('id', value: $fields['folder_id'])->startCondition()->and('user_id', value: authId())
            ->or('user_id', SQL::IS, null)->endCondition()->exists();
    }

    protected function checkTitleOnDuplicate(string $title, int $folder_id): bool
    {
        $result = Note::where('title', SQL::EQUAL, value: $title)
            ->and('folder_id', value: $folder_id)
            ->and('user_id', value: authId())
            ->exists();

        if ($result) {
            $this->setError('title', 'Title with the same name already exists in the chosen directory');
        }

        return $result;
    }

    protected function checkTitle(array $fields): bool
    {
        if (isset($fields['title'])) {
            return preg_match('/[^\w\s\(\)\-]/i', $fields['title']) === 0;
        }

        return true;
    }

    protected function checkContent(array $fields): bool
    {
        if (isset($fields['content'])) {
            preg_replace("/<script.*?<\/script>/", '', $fields['content']);
            return preg_match('/.+/i', $fields['content']);
        }

        return true;
    }
}