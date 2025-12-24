<?php

if (! function_exists('navIconClass')) {
    function navIconClass(bool $active): string
    {
        return $active
            ? 'bg-[#E68757]/20 text-[#930014] ring-[#DB4B3A]'
            : 'text-black hover:text-[#DB4B3A] hover:bg-[#E7BD8A]/30';
    }
}
