<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTeacher extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'subject_id',
        'teacher_id',
    ];

    /**
     * Get the subject associated with the subject_teacher.
     */
    public function subject()
    {
        return $this->hasMany(Subject::class);
    }

    /**
     * Get the teacher associated with the subject_teacher.
     */
    public function teacher()
    {
        return $this->hasMany(User::class, 'teacher_id');
    }
}
