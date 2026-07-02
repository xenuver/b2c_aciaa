<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Notification extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'message', 'type', 'link', 'is_read'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kirim notifikasi ke semua user dengan role admin.
     */
    public static function sendToAdmins(string $title, string $message, string $type = 'info', ?string $link = null): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            self::create([
                'user_id' => $admin->id,
                'title'   => $title,
                'message' => $message,
                'type'    => $type,
                'link'    => $link,
                'is_read' => false,
            ]);
        }
    }
}
