<?php

namespace App\Controllers;

use App\Validators\SharedNoteValidator;
use App\Models\SharedNote;
use App\Models\Note;
use function Core\requestBody;

class SharedNotesController extends BaseApiController
{
    protected SharedNoteValidator $validator;

    public function __construct()
    {
        $this->validator = new SharedNoteValidator();
    }

    public function add(int $note_id)
    {
        $data = [
            'note_id' => $note_id,
            ...requestBody()
        ];


        if (
            $this->validator->validate($data) &&
            !$this->validator->isNoteSharedWithUser($data) &&
            $sharedNote = SharedNote::create($data)
        ) {
            $note = Note::find($sharedNote->note_id);
            return $this->response(body: $note->toArray());
        }

        return $this->response(422, errors: $this->validator->getErrors());
    }

    public function remove(int $note_id)
    {
        //Коли я не вказую 'user_id', в мене з'являється помилка. Тобто, user_id повинен завжди бути вказаним, так?

        //user_id в таблиці shared_notes - це той користувач, якому відправили? Чи це той корстувач, який відправив?

        //я додав іншу перевірку на тип даних user_id в SharedNoteValidator\validate, бо перевірка по правилу не працювала. Так можна?

        //Додав додаткову перевірку до методу SharedNoteValidator\sharedUserIsNotOwner на існування нотатки, бо можна вказати
        //неіснуючу нотатку. Можна було викинути виключення або встановити помилку, і я встановив помилку. Нам потрібні
        //відповіді саме в форматі помилки, я правильно розумію?

        //Прибрав з методу, в якому ми зараз знаходимось, таку перевірку: $this->validator->isNoteSharedWithUser($data).
        //Коли ця перевірка була, встановлювалась помилка в методі SharedNoteValidator\isNotSharedWithUser, хоча зараз її
        //не повинно було бути, бо нам і потрібні нотатки, які існують. Коли прибрав цю перевірку, то помилка встановлюється коли
        //нотатки немає (нам це потрібно), а коли нотатка є, то вона видаляється без помилки. Так підійде?
        $data = [
            'note_id' => $note_id,
            ...requestBody()
        ];

        //if ($this->validator->validate($data) && $this->validator->isNoteSharedWithUser($data)) {
        if ($this->validator->validate($data)) {
            $sharedNote = SharedNote::where('note_id', value: $data['note_id'])
                ->and('user_id', value: $data['user_id'])->take();

            if (!$sharedNote) {
                throw new \Exception('Shared note does not exist', 404);
            }

            SharedNote::destroy($sharedNote->id);

            return $this->response(body: $sharedNote->toArray());
        }

        return $this->response(422, errors: $this->validator->getErrors());
    }
}