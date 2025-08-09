<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
public function created(User $user)
    {
        // Buat UserProfile baru dan kaitkan dengan user yang baru saja dibuat
        // Isi kolom 'name' dan 'email' dari data User
        $user->profile()->create([
            'name'  => $user->name,
            'email' => $user->email,
            // Anda bisa mengisi kolom lain dengan nilai default atau null
            // 'profile_photo' => null,
            // 'birthdate' => null,
            // 'gender' => null,
            // 'phone_number' => null,
            // 'social_media' => null,
        ]);

        // Alternatif jika Anda ingin membuat UserProfile tanpa menggunakan relationship create()
        // UserProfile::create([
        //     'user_id' => $user->id,
        //     'name' => $user->name,
        //     'email' => $user->email,
        // ]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
     public function updated(User $user)
    {
        // Opsional: Jika Anda ingin agar perubahan nama/email di User juga update di UserProfile
        if ($user->isDirty('name') || $user->isDirty('email')) {
            $user->profile()->update([
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
