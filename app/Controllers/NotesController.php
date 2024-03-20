<?php

namespace App\Controllers;

use App\Validators\Notes\{CreateNoteValidator, UpdateNoteValidator};
use App\Models\Note;
use function Core\{
    requestBody,
    authId
};
use Enums\SQL;

class NotesController extends BaseApiController
{
    public function index()
    {
        return $this->response(
            body: Note::where('user_id', value: authId())
                ->orderBy([
                    'pinned' => 'DESC',
                    'completed' => 'ASC',
                    'updated_at' => 'DESC'
                ])->get());
    }

    public function show(int $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return $this->response(404, errors: ['message' => 'Note not found']);
        }

        if ($note->user_id !== authId()) {
            return $this->response(403, errors: ['message' => 'This resource is forbidden for you']);
        }


        return $this->response(body: $note->withSharedUsers()->toArray());
    }

    public function store()
    {
        $data = array_merge(requestBody(), ['user_id' => authId()]);
        $validator = new CreateNoteValidator();

        if ($validator->validate($data) && $note = Note::create($data)) {
            return $this->response(body: $note->toArray());
        }

        return $this->response(422, errors: $validator->getErrors());
    }

    public function update(int $id)
    {
        $note = Note::find($id);

        if (!$note || $note->user_id !== authId()) {
            return $this->response(403, errors: ['message' => 'Нотатка не знайдена або недоступна']);
        }

        //folder_id, title, content, pinned, completed
        $data = [...requestBody(), 'updated_at' => date('Y-m-d H:i:s')];

        $validator = new UpdateNoteValidator();

        if ($validator->validate($data) && $note = $note->update($data)) {
            return $this->response(body: $note->toArray());
        }

        return $this->response(422, errors: $validator->getErrors());
        //в CreateNoteValidator були встановлені правила і помилки для title, content i folder_id, а в UpdateNoteValidator
        //мені довелось їх прибрати та додати нові методи в Notes\Base. Я правильно так зробив? Бо інакше, якби я залишив
        //правила та помилки і не додав методи, то мені би довелось постійно вказувати title i content, навіть якщо би я
        //не хотів їх оновлювати. Для folder_id ти ще на уроці вказав додаткове правило в методі Base\ValidateFolderId, що
        //folder_id не обов'язковий, але і для нього мені довелось прибрати правило та помилку. Отже, чи правильно було прибрати
        //правила та помилки і додати нові методи в Base?

        //замість правила для folder_id я додав перевірку на правильний тип даних в Base\ValidateFolderId для цього поля. Так можна?

        // В нас правило для заголовку таке: '/[\w\s\(\)\-]{3,}/i', але я через постмен створив такий заголовок і він підійшов:
        // "$#@+=~`123". Для content так само. Так повинно бути? Просто я не знаю, як інше правило придумати.
    }

    public function destroy($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return $this->response(404, errors: [
                'message' => 'Resource not found'
            ]);
        } else if ($note->user_id !== authId()) {
            return $this->response(403, errors: ['message' => 'This resource is forbidden for you']);
        }

        $result = Note::destroy($id);

        if (!$result) {
            return $this->response(422, errors: ['message' => 'Oops, smth went wrong']);
        }

        return $this->response();
    }
}