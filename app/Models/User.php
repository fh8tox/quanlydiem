<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tên bảng (không bắt buộc vì Laravel tự hiểu)
     */
    protected $table = 'users';

    /**
     * Các field cho phép gán hàng loạt
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * Ẩn khi trả về JSON
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ép kiểu dữ liệu
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // =========================
    // RELATIONSHIPS
    // =========================

    /**
     * 1 user là 1 student
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }

    // =========================
    // HELPER FUNCTIONS (PHÂN QUYỀN)
    // =========================

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }
}