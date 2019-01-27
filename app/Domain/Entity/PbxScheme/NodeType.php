<?php

namespace App\Domain\Entity\PbxScheme;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * @property string  $id
 * @property string  $name
 * @property string  $type
 * @property boolean $deleted
 * @property Carbon  $deleted_at
 * @property Carbon  $created_at
 */
class NodeType extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    public const NAME_DIAL              = 'dial';
    public const NAME_GROUP_DIAL        = 'group_dial';
    public const NAME_SMS_BUSINESS_CARD = 'sms_business_card';
    public const NAME_SMS_APOLOGIES     = 'sms_apologies';
    public const NAME_QUEUE             = 'queue';
    public const NAME_SMS               = 'sms';
    public const NAME_PLAYBACK          = 'playback';

    public const TYPE_CONDITION = 'condition';
    public const TYPE_ACTION    = 'action';

    protected $table      = 'node_types';
    public    $timestamps = false;

    protected $dates = ['created_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::creating(
            function ($model) {
                $model->id = Uuid::uuid4()->toString();
            }
        );
    }
}
