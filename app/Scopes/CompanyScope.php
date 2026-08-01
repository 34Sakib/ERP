<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class CompanyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (app()->runningInConsole()) {
            return;
        }

        $activeCompanyId = session('active_company_id');

        if (!$activeCompanyId && auth()->check()) {
            $activeCompanyId = auth()->user()->company_id;
        }

        if ($activeCompanyId) {
            $builder->where($model->getTable() . '.company_id', '=', $activeCompanyId);
        }
    }
}
