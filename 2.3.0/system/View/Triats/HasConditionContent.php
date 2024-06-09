<?php

namespace System\View\Triats;

trait HasConditionContent
{
    //rules If
    private function checkIfCondition()
    {
        $ConditionOpened = $this->findIfOpeneds();
        if ($ConditionOpened) {
            foreach ($ConditionOpened as $key => $value) {
                $this->initialIfOpened($key, $value);
            };
        }

        $ConditionClosed = $this->findIfClosed();
        if ($ConditionClosed) {
            foreach ($ConditionClosed as $end) {
                $this->initialIfClosed($end);
            };
        }
    }
    private function checkElseContent()
    {
        $findElse = $this->findElse();
        if ($findElse) {
            foreach ($findElse as $else) {
                $this->initialElse($else);
            };
        }
    }

    private function checkElseIfContent()
    {
        $findElseIfOpened = $this->findElseIfOpeneds();
        if ($findElseIfOpened) {
            foreach ($findElseIfOpened as $key => $value) {
                $this->initialElseIfOpened($key, $value);
            };
        }
    }
    private function findElseIfOpeneds()
    {
        $elseIfOpenedArray = [];
        preg_match_all("/@elseif\(([A-z0-9$&+,:;=?@#|'_<>.^*()%! -]*)\)/", $this->content, $elseIfOpenedArray, PREG_UNMATCHED_AS_NULL);
        return isset($elseIfOpenedArray[0]) && isset($elseIfOpenedArray[1]) ? array_combine($elseIfOpenedArray[0], $elseIfOpenedArray[1]) : false;
    }
    private function findIfOpeneds()
    {
        $ifOpenedArray = [];
        preg_match_all("/@if \(([A-z0-9$&+,:;=?@#|_'<>.^*()%! -]*)\)/", $this->content, $ifOpenedArray, PREG_UNMATCHED_AS_NULL);
        return isset($ifOpenedArray[0]) && isset($ifOpenedArray[1]) ? array_combine($ifOpenedArray[0], $ifOpenedArray[1]) : false;
    }

    private function findIfClosed()
    {
        $ifClosedArray = [];
        preg_match_all("/@endif/", $this->content, $ifClosedArray, PREG_UNMATCHED_AS_NULL);
        return isset($ifClosedArray[0]) ? $ifClosedArray[0] : false;
    }

    private function findElse()
    {
        $elseArray = [];
        preg_match_all("/@else/", $this->content, $elseArray, PREG_UNMATCHED_AS_NULL);
        return isset($elseArray[0]) ? $elseArray[0] : false;
    }

    private function initialIfOpened($condition, $rules)
    {
        $conditionIfOpened = "<?php if({$rules}){ ?>";
        return $this->content = str_replace($condition, $conditionIfOpened, $this->content);
    }

    private function initialElse($input)
    {
        $tagElse = "<? }else {?>";
        return $this->content = str_replace($input, $tagElse, $this->content);
    }

    private function initialIfClosed($endIf)
    {
        $conditionIfClosed = "<? } ?>";
        return $this->content = str_replace($endIf, $conditionIfClosed, $this->content);
    }
    private function initialElseIfOpened($condition, $rules)
    {
        $ElseIfOpened = "<? }elseif({$rules}) { ?>";
        return $this->content = str_replace($condition, $ElseIfOpened, $this->content);
    }
}