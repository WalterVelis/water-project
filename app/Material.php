<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    const COBRE = 0;
    const PVC_SANITARIO = 1;
    const PVC_HIDR_RD26 = 2;
    const CONDUIT = 3;
    const TUBOPLUS = 4;
    const PVC_HIDR_CED40 = 5;
    const BUSHING_GALVANIZADO = 6;
    const GALVANIZADA = 7;
    const ACERO = 8;
    const PLASTICO = 9;
    const PVC = 10;
    const SILICON = 11;
    const GARLOCK = 12;
    const BRONCE = 13;
    const HULE = 14;
    const SILER = 15;
    const PLOMO = 16;
    const OTRO = 17;

    public static function listType()
    {
        return [
            self::COBRE => "COBRE",
            self::PVC_SANITARIO => "PVC SANITARIO",
            self::PVC_HIDR_RD26 => "PVC HIDR RD26",
            self::CONDUIT => "CONDUIT",
            self::TUBOPLUS => "TUBOPLUS",
            self::PVC_HIDR_CED40 => "PVC HIDR CED40",
            self::BUSHING_GALVANIZADO => "BUSHING GALVANIZADO",
            self::GALVANIZADA => "GALVANIZADA",
            self::ACERO => "ACERO",
            self::PLASTICO => "PLÁSTICO",
            self::PVC => "PVC",
            self::SILICON => "SILICON",
            self::GARLOCK => "GARLOCK",
            self::BRONCE => "BRONCE",
            self::HULE => "HULE",
            self::SILER => "SILER",
            self::PLOMO => "50% ESTAÑO y 50% PLOMO",
            self::OTRO => "OTRO",
        ];
    }

    public function typeLabel()
    {
        $list = self::listType();

        // little validation here just in case someone mess things
        // up and there's a ghost status saved in DB
        return isset($list[$this->type])
            ? $list[$this->type]
            : $this->type;
    }

    protected $fillable = [
        'name',
        'type',
        'unit',
    ];

    public function providers()
    {
        return $this->hasMany('App\MaterialProvider');
    }
}
