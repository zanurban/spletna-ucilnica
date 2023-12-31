<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Auth\Authenticatable;



class User extends Model implements Authenticatable
{
    use HasUuids;
    use HasFactory;
    //use Authenticatable;
    public function getAuthIdentifierName()
    {
        return 'id'; // Change this to your primary key column name if it's different
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password; // Change this to your password column name if it's different
    }

    public function getRememberToken()
    {
        return $this->remember_token; // Change this to your remember token column name if it's different
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Change this to your remember token column name if it's different
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Change this to your remember token column name if it's different
    }
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
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'role',
    ];

    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, SubjectTeacher::class, 'teacher_id', 'id', 'id', 'subject_id');
    }
    public function subject()
    {
        return $this->belongsToMany(Subject::class, 'subject_students', 'student_id', 'subject_teacher_id')
            ->using(SubjectStudent::class)
            ->withPivot('subject_teacher_id')
            ->join('subject_teachers', 'subject_students.subject_teacher_id', '=', 'subject_teachers.id')
            ->join('subjects as subjects_alias', 'subject_teachers.subject_id', '=', 'subjects_alias.id')
            ->select('subjects_alias.*');
    }
    

}
