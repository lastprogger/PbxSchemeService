<?php

namespace App\Domain\Entity\PbxScheme;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * App\Entity\CarBrand
 *
 * @property integer                 $id
 * @property string                  $from_node_id
 * @property string                  $to_node_id
 * @property string                  $pbx_scheme_id
 * @property string                  $type
 * @property Carbon                  $deleted_at
 * @property Carbon                  $created_at
 * @property Carbon                  $updated_at
 * @property-read PbxSchemeNode      $toNode
 * @property-read PbxSchemeNode|null $fromNode
 */
class PbxSchemeNodeRelation extends Model
{
    use SoftDeletes;

    public const TYPE_DIRECT   = 'direct';
    public const TYPE_POSITIVE = 'positive';
    public const TYPE_NEGATIVE = 'negative';

    protected $table = 'pbx_scheme_node_relations';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return HasOne
     */
    public function toNode()
    {
        return $this->hasOne(PbxSchemeNode::class, 'to_node_id');
    }

    /**
     * @return HasOne
     */
    public function fromNode()
    {
        return $this->hasOne(PbxSchemeNode::class, 'from_node_id');
    }

    /**
     * @return HasOne
     */
    public function pbxScheme()
    {
        return $this->hasOne(PbxScheme::class, 'pbx_scheme_id');
    }
}
