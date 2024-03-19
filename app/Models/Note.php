<?php

namespace App\Models;
use Core\Model;

class Note extends Model
{
    public static ?string $tableName = 'notes';
    public int $user_id, $folder_id;
    public string $title, $content, $created_at, $updated_at;
    public bool $pinned = false, $completed = false;
    public array $shared_users = [];
    public function withSharedUsers(): static
    {
        $this->shared_users = SharedNote::select(['user_id'])->where('note_id', value: $this->id)
            ->pluck('user_id');

        return $this;
    }
}