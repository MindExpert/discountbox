<?php

namespace App\Models\Concerns;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use InvalidArgumentException;

/**
 * @property Note $notes
 */
trait HasNotes
{
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'noteable', 'noteable_type', 'noteable_id', 'id');
    }

    public function addNote(?string $title, ?string $type = null, ?string $description = null, ?User $author = null): Note
    {
        $author = $author ?? user();

        $note = new Note([
            'title'       => $title,
            'type'        => $type,
            'description' => $description,
            'author_id'   => $author->id,
        ]);

        $this->notes()->save($note);

        return $note;
    }

    public function editNote(Note $note, ?string $title, ?string $type = null, ?string $description = null, ?bool $quietly = false): Note
    {
        if ($note->noteable_id !== $this->id || $note->noteable_type !== static::$morph_key) {
            throw new InvalidArgumentException('Note is not related to this model.');
        }

        if ($quietly) {
            $note->updateQuietly([
                'title'       => $title,
                'type'        => $type,
                'description' => $description,
            ]);

            return $note->refresh();
        }

        $note->update([
            'title'       => $title,
            'type'        => $type,
            'description' => $description,
        ]);

        return $note->refresh();
    }

    public function deleteNote(Note $note, ?bool $force = false): ?bool
    {
        if ($note->noteable_id !== $this->id || $note->noteable_type !== static::$morph_key) {
            throw new InvalidArgumentException('Note is not related to this model.');
        }

        if ($force) {
            return $note->forceDelete();
        }

        return $note->delete();
    }

    public function deleteNotes(): void
    {
        $this->notes()->delete();
        $this->unsetRelation('notes');
    }
}
