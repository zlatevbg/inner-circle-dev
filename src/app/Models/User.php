<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function friends()
    {
        return $this->hasMany(Friend::class)->orderBy('friend_id');
    }

    public function connections($user)
    {
        $connections = User::selectRaw('users.name as user1, ff1.user_id as user1_id, ff2.user_id as user2_id, ff2.friend_id as friend_id, ff2.friend_name as friend')
            ->from('users')
            ->leftJoin('facebook_friends as ff1', 'users.id', '=', 'ff1.user_id')
            ->join('facebook_friends as ff2', function($join) {
                $join->on('ff1.friend_id', '=', 'ff2.friend_id')
                    ->whereColumn('ff1.user_id', '!=', 'ff2.user_id');
            })
            ->groupByRaw('ff1.user_id')
            ->groupBy('ff2.user_id')
            ->groupBy('ff2.friend_id')
            ->groupBy('ff2.friend_name')
            ->groupBy('users.name')
            ->get();

        $friends = collect();

        $nextFriend = $connections->where('user1_id', $this->id);
        $ids = $nextFriend->pluck('user2_id')->all();
        $nextFriend = $nextFriend->firstOrFail();

        for ($i = 0; $i < 5; $i++) {
            $friend = $connections->whereIn('user1_id', $ids);

            if (!in_array($user->id, $friend->pluck('user1_id')->all())) {
                $friend = $friend->where('user2_id', '!=', $nextFriend->user1_id);
                $ids = $friend->pluck('user2_id')->all();
                $friend = $friend->first();
                $nextFriend->user2 = $friend->user1;
                $friends->push($nextFriend);
                $nextFriend = $friend;
            } else {
                $friend = $friend->first();
                $nextFriend->user2 = $friend->user1;
                $friends->push($nextFriend);
                break;
            }
        }

        return $friends;
    }
}
