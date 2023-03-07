<?php

namespace App\Traits;

use Google\Cloud\Translate\TranslateClient;

trait TranslateTrait
{
    protected $translate;

    public function init()
    {
        $this->translate = new TranslateClient(['key' => "AIzaSyAfOJSpC3gbMCbR8l4Swu9y064UDk9Jav8"]);
    }

    public function translate($content, $source, $target, $format = 'text')
    {

        if ($source == $target) {
            return $content;
        } else {
            $translation = $this->translate->translate($content, [
                'source' => $source,
                'target' => $target,
                'format' => $format,
            ]);
            return $translation["text"];
        }
    }
}
