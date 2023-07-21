<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'books';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function($item) {

            if(in_array($item->storage, ['uploads','ftp','s3']))
            {
                if (\Storage::disk($item->storage)->exists($item->file)) {
                    \Storage::disk($item->storage)->delete($item->file);
                }
            }

            if(file_exists(ltrim($item->thumbnail,'/'))) unlink(ltrim($item->thumbnail,'/'));

            \App\Models\Report::where('book_id',$item->id)->delete();
            \App\Models\Favorite::where('book_id',$item->id)->delete();
            \App\Models\Rating::where('book_id',$item->id)->delete();
            \risul\LaravelLikeComment\Models\Comment::where('item_id',$item->id)->delete();
            \risul\LaravelLikeComment\Models\Like::where('item_id',$item->id)->delete();

        });
    } 

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function category()
    {
        return $this->hasOne('App\Models\Category','id','category_id');
    }    

    public function ratings()
    {
        return $this->hasMany('App\Models\Rating','book_id','id');
    }

    public function active_category()
    {
        return $this->hasOne('App\Models\Category','id','category_id')->where('active',1);
    }

    public function getTitleFAttribute()
    {
        return $this->attributes['title_f'] = (!empty($this->title))?$this->title:__('Untitled');
    }  

    public function getShortOverviewAttribute()
    {
        return $this->attributes['short_overview'] = str_limit(strip_tags($this->overview),100,'');
    }        

    public function getViewsFAttribute()
    {
        return $this->attributes['views_f'] = number_format_short($this->views);
    }      

    public function getDownloadsFAttribute()
    {
        return $this->attributes['downloads_f'] = number_format_short($this->downloads);
    }   

    public function getURLAttribute()
    {
        return $this->attributes['url'] = route('book.show',[$this->slug]);
    }    

    public function getThumbnailFAttribute()
    {
        if(!empty($this->thumbnail)){
            return $this->attributes['thumbnail_f'] = url($this->thumbnail);        
        }
        else{

            return $this->attributes['thumbnail_f'] = 'https://place-hold.it/258x387/5DBCD2/fff.png&bold&text='.urlencode($this->title_f);
        }        
    }

    public function getCreatedAgoAttribute()
    {
        return $this->attributes['created_ago'] = $this->created_at->diffForHumans();
    }

    public function getLabelAttribute()
    {   
        $label = '';
        if($this->featured == 1) $label = __('Featured');
        elseif(date('Y-m-d',strtotime($this->created_at)) == date('Y-m-d')) $label = __('HOT');
        return $this->attributes['label'] = $label;
    }     

    public function getTagsFAttribute()
    {   
        $tags = [];
        foreach (explode(',', $this->tags) as $tag) {
            array_push($tags, '<a href="'.buildQuery(['tag'=>trim($tag)]).'">'.trim($tag).'</a>');
        }
        return $this->attributes['tags_f'] = implode(', ', $tags);
    }    

    public function getSizeAttribute()
    {  
        if(!in_array($this->storage, ['uploads','ftp','s3'])) return $this->attributes['size'] = '';

        if(empty($this->file_size)){
            $bytes = (file_exists(ltrim($this->file,'/')))?filesize(ltrim($this->file,'/')):0;
        }
        else{
            $bytes = $this->file_size;
        }

        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $this->attributes['size'] = $bytes;
    }

    public function getTypeAttribute()
    {
        if(in_array($this->storage, ['external_link','google_drive_link','embed_code'])) return $this->attributes['type'] = 'Embed';
        if(empty($this->file_type))
        {
            $book_file_type = explode('.', $this->file);
            $book_type      = end($book_file_type);
        }
        else{
            $book_type = $this->file_type;
        }
        return $this->attributes['type'] = $book_type;
    }    

    public function getFileFAttribute()
    {
        if(in_array($this->storage, ['external_link','google_drive_link','embed_code'])) return $this->attributes['file_f'] = $this->file;
        return $this->attributes['file_f'] = config('filesystems.disks.' . $this->storage . '.url') . $this->file;
    }

}


