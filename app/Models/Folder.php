<?php

namespace App\Models;
use Core\Model;

class Folder extends Model
{
    const SHARED_FOLDER = 'Shared';
    const GENERAL_FOLDER = 'General';

    static public ?string $tableName = 'folders';
    public int|null $user_id;
    public string $title, $created_at, $updated_at;
}