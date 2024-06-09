<?php

namespace System\View\Triats;

trait HasForContent
{
    //rules for

    private function checkForLoopsContent()
    {
        $findForOpened = $this->findForOpened();
        if ($findForOpened) {
            foreach ($findForOpened as $key => $value) {
                $this->initialForOpened($key, $value);
            };
        }

        $findForClosed = $this->findForClosed();
        if ($findForClosed) {
            foreach ($findForClosed as $closed) {
                $this->initialForClosed($closed);
            };
        }
    }

    private function findForOpened()
    {
        $forArray = [];
        preg_match_all("/@for \(([A-z0-9$&+,:;=?@#|'<>.^*()%! -]*)\)/", $this->content, $forArray, PREG_UNMATCHED_AS_NULL);
        return isset($forArray[0]) && isset($forArray[1]) ? array_combine($forArray[0], $forArray[1]) : false;
    }
    private function findForClosed()
    {
        $endforArray = [];
        preg_match_all("/@endfor/", $this->content, $endforArray, PREG_UNMATCHED_AS_NULL);
        return isset($endforArray[0]) ? $endforArray[0] : false;
    }

    private function initialForOpened($nameLoop, $rules)
    {
        $ForOpened = "<?php for({$rules}){ ?>";
        return $this->content = str_replace($nameLoop, $ForOpened, $this->content);
    }

    private function initialForClosed($nameLoop)
    {
        $ForClosed = "<?php } ?>";
        return $this->content = str_replace($nameLoop, $ForClosed, $this->content);
    }
}
