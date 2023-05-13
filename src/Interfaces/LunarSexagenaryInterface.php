<?php namespace VanTran\LunarCalendar\Interfaces;

interface LunarSexagenaryInterface extends FormatterInterface
{
    /**
     * Trả về 1 đối tượng Can hoặc Chi
     * 
     * @param string $key 
     * @return TermInterface 
     */
    public function getTerm(string $key): TermInterface;
}