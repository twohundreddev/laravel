
<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

expect()
    ->extend(
        'toExtendModel',
        fn () => expect($this->value)
            ->toExtend(Model::class)
    );

expect()
    ->extend(
        'toExtendPivot',
        fn () => expect($this->value)
            ->toExtend(Pivot::class)
    );

expect()
    ->extend(
        'toHaveFillableAttributes',
        fn (array $fillable) => expect((new $this->value)->getFillable())
            ->toBe($fillable)
    );

expect()
    ->extend(
        'toHaveHiddenAttributes',
        fn (array $hidden) => expect((new $this->value)->getHidden())
            ->toBe($hidden)
    );

expect()
    ->extend(
        'toHaveAppendsAttributes',
        fn (array $appends) => expect((new $this->value)->getAppends())
            ->toBe($appends)
    );

expect()
    ->extend(
        'toHaveCastsAttributes',
        fn (array $casts) => expect((new $this->value)->getCasts())
            ->toBe($casts)
    );
