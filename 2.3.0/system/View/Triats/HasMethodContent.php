<?php

namespace System\View\Triats;

trait HasMethodContent
{
    private function checkMethodsContent()
    {
        $findMethods = $this->findMethods();
        if ($findMethods) {
            foreach ($findMethods as $method => $value) {
                $this->initialMethod($method , $value);
            }
        }
    }

    private function findMethods()
    {
        $methodsArray = [];
        preg_match_all("/@method\('([a-z]*)'\)/", $this->content, $methodsArray, PREG_UNMATCHED_AS_NULL);
        return isset($methodsArray[0]) && isset($methodsArray[1]) ? array_combine($methodsArray[0], $methodsArray[1]) : false;
    }

    private function initialMethod($method , $value)
    {
        $inputMethod = "<input type='hidden' name='_method' value='<?= '$value' ?>'>";
        return $this->content = str_replace($method, $inputMethod, $this->content);
    }
}
