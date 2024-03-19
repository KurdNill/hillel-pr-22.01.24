<?php

namespace App\Validators;

use App\Models\{User, SharedNote, Note};

class SharedNoteValidator extends BaseValidator
{
    protected array $rules = [
        'user_id' => '/\d+/i',
        'note_id' => '/\d+/i'
    ];

    protected array $errors = [
        'user_id' => 'User id should be integer',
        'note_id' => 'Note id should be integer'
    ];


    protected function isUserExists(array $fields): bool
    {
        $exists = User::where('id', value: $fields['user_id'])->exists();

        if (!$exists) {
            $this->setError('user_id', 'Wrong shared user id');
        }

        return $exists;
    }

    public function isNoteSharedWithUser(array $fields): bool
    {
        $alreadyShared = SharedNote::where('user_id', value: $fields['user_id'])
            ->and('note_id', value: $fields['note_id'])->exists();

        if ($alreadyShared) {
            $this->setError('message', "Note with id=$fields[note_id] already shared with user_id=$fields[user_id]");
        }

        return $alreadyShared;
    }

    protected function sharedUserIsNotOwner(array $fields): bool
    {
        $note = Note::find($fields['note_id']);

        //або if (empty($note)) {}
        if (!$note) {
            //throw new \Exception('Нотатка не знайдена', 404);
            $this->setError('note_id', 'Нотатка не знайдена');
            return false;
        }

        return $fields['user_id'] !== $note->user_id;
    }

    public function validate(array $fields = []): bool
    {
        if (!is_int($fields['user_id'])) {
            unset($this->errors['note_id']);
            return false;
        }

        return !in_array(false, [
            parent::validate($fields),
            $this->isUserExists($fields),
            $this->sharedUserIsNotOwner($fields)
        ]);
    }
}