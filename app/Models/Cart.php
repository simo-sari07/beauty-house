<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function mergeToUser($user, $sessionId)
    {
        $guestCart = self::where('session_id', $sessionId)->first();

        if (!$guestCart) {
            return;
        }

        $userCart = self::firstOrCreate(['user_id' => $user->id]);

        if ($userCart->id === $guestCart->id) {
            // It's the same cart, just ensure user_id is set and session_id is cleared
            $guestCart->update([
                'user_id' => $user->id,
                'session_id' => null
            ]);
            return;
        }

        foreach ($guestCart->items as $guestItem) {
            $existingItem = $userCart->items()
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($existingItem) {
                $existingItem->quantity += $guestItem->quantity;
                $existingItem->save();
            } else {
                $guestItem->update(['cart_id' => $userCart->id]);
            }
        }

        $guestCart->delete();
    }
}
