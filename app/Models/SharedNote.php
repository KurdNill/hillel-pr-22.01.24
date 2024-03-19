<?php

namespace App\Models;
use Core\Model;

class SharedNote extends Model
{
    public static ?string $tableName = 'shared_notes';
    public int $user_id, $note_id;
}