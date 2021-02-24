<?php

    /**
     * ##################
     * ###   STRING   ###
     * ##################
    */

    function str_slug(string $string): string
    {
        $string = filter_var( mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
        $invalid = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        $valid = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        $slug = str_replace(["-----", "----", "---", "--"], "-",
            str_replace(" ", "-",
                trim(
                    strtr(
                        utf8_decode($string),
                        utf8_decode($invalid),
                        $valid
                    )
                )
            )
        );

        return $slug;
    }

    function str_study_case(string $string): string
    {
        $str = str_slug($string);
        $strWithSpace = str_replace("-", " ", $str);
        $convertCase = mb_convert_case($strWithSpace, MB_CASE_TITLE);

        $studyCase = str_replace(" ", "", $convertCase);

        return $studyCase;
    }

    function str_camel_case(string $string): string
    {
        return lcfirst(
            str_study_case($string)
        );
    }