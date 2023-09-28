<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectStudent extends Model
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
        'student_id',
        'subject_teacher_id',
    ];

    /**
     * Get the student associated with the subject_student.
     */
    public function student()
    {
        return $this->hasMany(User::class, 'student_id');
    }

    /**
     * Get the subject_teacher associated with the subject_student.
     */
    public function subjectTeacher()
    {
        return $this->belongsTo(SubjectTeacher::class, 'subject_teacher_id');
    }
}
