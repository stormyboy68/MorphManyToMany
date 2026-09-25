<?php

namespace ASB\MorphMTM\Exceptions;

use RuntimeException;

class DuplicateMtmModelException extends RuntimeException
{
    public static function forTitle(string $title, ?string $modelType = null): self
    {
        $msg = $modelType
            ? "MTM model with title '{$title}' and model_type '{$modelType}' already exists."
            : "MTM model with title '{$title}' already exists.";

        return new self($msg);
    }

    public static function cannotRestore(string $title): self
    {
        return new self(
            "Cannot restore '{$title}': an active record with the same title already exists."
        );
    }

    public static function lockFailed(string $title): self
    {
        return new self(
            "Could not acquire lock for '{$title}'. Another process is creating it."
        );
    }
}
