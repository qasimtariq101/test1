<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\ResetPassword as ResetPasswordNotification;
//use App\Notifications\VerifyEmail as RegisterAccountNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at','password','role','status','avatar','about','fb','tw','gp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function boot()
    {
        parent::boot();
        static::deleting(function($item) {

            if(file_exists(ltrim($item->avatar,'/'))) unlink(ltrim($item->avatar,'/'));

            \App\Models\SocialProfile::where('user_id',$item->id)->delete();
            \App\Models\Report::where('user_id',$item->id)->delete();
            \App\Models\Favorite::where('user_id',$item->id)->delete();
            \App\Models\Rating::where('user_id',$item->id)->delete();
            \risul\LaravelLikeComment\Models\Comment::where('user_id',$item->id)->delete();
            \risul\LaravelLikeComment\Models\Like::where('user_id',$item->id)->delete();

        });
    } 

    public function books()
    {
        return $this->hasMany('App\Models\Book','user_id','id');
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    } 

    public function sendEmailVerificationNotification()
    {
        try{
            $this->notify(new \App\Notifications\VerifyEmail);
        }
        catch(\Exception $e){    
            \Log::info($e->getMessage());        
            session()->flash('warning', __('Registration email was not sent due to invalid mail configuration'));
        }       
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'status' => 1,
        ])->save();
    }
    

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        try{
            $this->notify(new ResetPasswordNotification($token));
        }
        catch(\Exception $e){        
            \Log::info($e->getMessage());    
            session()->flash('warning', __('Reset password email was not sent due to invalid mail configuration'));
        }
    }   

    public function isAdmin()
    {
        if($this->role == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] = (!empty($this->attributes['avatar'])) ? url($this->attributes['avatar']) : 'https://ui-avatars.com/api/?background=random&name=' . $this->name;
    }

    public function getCreatedAgoAttribute()
    {
        return $this->attributes['created_ago'] =  (!empty($this->attributes['created_at']))?$this->created_at->diffForHumans():'-';
    }    

    public function getURLAttribute()
    {
        return $this->attributes['url'] =  url('u/'.$this->name);
    }        


    /**
     * Return the user attributes.

     * @return array
     */
    public static function getAuthor($id)
    {
        $user = self::find($id);
        return [
            'id'     => $user->id,
            'name'   => $user->name,
            'email'  => $user->email,
            'url'    => url('u/'.$user->name),  // Optional
            'avatar' => (!empty($user->avatar))?$user->avatar:'https://placehold.it/80x80/00a65a/ffffff/&text='.$user->name[0],  // Default avatar
            'admin'  => $user->role === 'admin', // bool
        ];
    }
}
