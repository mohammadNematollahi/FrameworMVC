<?php

namespace System\View\Triats;


trait HasForEachContent
{
    //rules foreach
    private function checkForeachLoopsContent()
    {
        $findForeachs = $this->findForeachsOpened();
        if ($findForeachs) {
            foreach ($findForeachs as $key => $value) {
                $this->initialForeachOpened($key, $value);
            };
        }

        $ConditionClosed = $this->findForeachsClosed();
        if ($ConditionClosed) {
            foreach ($ConditionClosed as $closed) {
                $this->initialForeachClosed($closed);
            };
        }
    }

    private function findForeachsOpened()
    {
        $foreachArray = [];
        preg_match_all("/@foreach \(([A-z0-9$&+,:;=?@#|'<>.^*()%! -]*)\)/", $this->content, $foreachArray, PREG_UNMATCHED_AS_NULL);
        return isset($foreachArray[0]) && isset($foreachArray[1]) ? array_combine($foreachArray[0], $foreachArray[1]) : false;
    }

    private function initialForeachOpened($nameLoop, $rules)
    {
        $foreachOpened = "<?php foreach({$rules}){ ?>";
        return $this->content = str_replace($nameLoop, $foreachOpened, $this->content);
    }

    private function findForeachsClosed()
    {
        $foreachClosedArray = [];
        preg_match_all("/@endforeach/", $this->content, $foreachClosedArray, PREG_UNMATCHED_AS_NULL);
        return isset($foreachClosedArray[0]) ? $foreachClosedArray[0] : false;
    }

    private function initialForeachClosed($nameLoop)
    {
        $foreachClosed = "<?php } ?>";
        return $this->content = str_replace($nameLoop, $foreachClosed, $this->content);
    }
}
