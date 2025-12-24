<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use App\Models\Mart;

class ActiveMartScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();

        $activeMart = $user?->activeMart
            ?? Mart::where('nama_mart', 'TJMart Putra')->first();

        if ($activeMart) {
            $builder->whereHas('marts', function ($q) use ($activeMart) {
                $q->where('mart.id', $activeMart->id);
            });
        }
    }
}
