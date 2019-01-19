<?php

namespace App\Domain\Entity\PbxScheme;

use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * App\Entity\CarBrand
 *
 * @property string                                  $id
 * @property string                                  $node_type_id
 * @property string                                  $pbx_scheme_id
 * @property array                                   $data
 * @property Carbon                                  $deleted_at
 * @property Carbon                                  $created_at
 * @property Carbon                                  $updated_at
 * @property-read Collection|PbxSchemeNodeRelation[] $incomingRelations
 * @property-read PbxSchemeNodeRelation|null         $outgoingRelation
 * @property-read PbxScheme                          $pbxScheme
 * @property-read NodeType                           $nodeType
 */
class PbxSchemeNode extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $table = 'pbx_scheme_nodes';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'data' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    /**
     * @return BelongsTo
     */
    public function incomingRelations()
    {
        return $this->belongsTo(PbxSchemeNodeRelation::class, 'to_node_id');
    }

    /**
     * @return BelongsTo
     */
    public function outgoingRelation()
    {
        return $this->belongsTo(PbxSchemeNodeRelation::class, 'from_node_id');
    }

    /**
     * @return HasOne
     */
    public function pbxScheme()
    {
        return $this->hasOne(PbxScheme::class, 'pbx_scheme_id');
    }

    /**
     * @return HasOne
     */
    public function nodeType()
    {
        return $this->hasOne(NodeType::class, 'id', 'node_type_id');
    }
}
