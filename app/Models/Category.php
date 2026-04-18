<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'status'
    ];

    /* ==================================
    TABLE NAME (optional if custom)
    ================================== */
    protected $table = 'categories';

    /* ==================================
    PRIMARY KEY
    ================================== */
    protected $primaryKey = 'id';

    /* ==================================
    GETTERS
    ================================== */

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /* ==================================
    SETTERS
    ================================== */

    public function setName($value)
    {
        $this->name = $value;
    }

    public function setSlug($value)
    {
        $this->slug = $value;
    }

    public function setImage($value)
    {
        $this->image = $value;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    /* ==================================
    EXTRA HELPERS
    ================================== */

    public function isActive()
    {
        return $this->status == 1;
    }

    public function isInactive()
    {
        return $this->status == 0;
    }
}