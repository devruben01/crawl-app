<?php

namespace App\Contracts;

interface TransformerInterface
{
    /**
     * Should return a new transformer object for this model.
     *
     */
    public function getTransformer();
}
