<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function download()
    {
        return $this->hasOne(TaskFile::class);
    }

    public function sub()
    {
        return $this->hasMany(SubTask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }

    public function task_files()
    {
        return $this->hasMany(TaskFile::class);
    }
}
