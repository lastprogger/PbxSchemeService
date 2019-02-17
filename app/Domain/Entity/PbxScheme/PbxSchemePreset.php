<?php

namespace App\Domain\Entity\PbxScheme;

use App\Domain\Entity\PbxScheme\PbxScheme;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * App\Entity\CarBrand
 *
 * @property string         $id
 * @property string         $pbx_scheme_id
 * @property string         $name
 * @property Carbon         $deleted_at
 * @property Carbon         $created_at
 * @property Carbon         $updated_at
 * @property-read PbxScheme $scheme
 */
class PbxSchemePreset extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'pbx_scheme_presets';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    /**
     * @return HasOne
     */
    public function scheme()
    {
        return $this->hasOne(PbxScheme::class, 'id', 'pbx_scheme_id');
    }
}
