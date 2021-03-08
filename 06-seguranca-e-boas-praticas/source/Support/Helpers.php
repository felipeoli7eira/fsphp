<?php

    /**
     * #####################
     * ###   VALIDATES   ###
     * ####################
    */

    function is_email(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function is_password(string $password): bool
    {
        $valid = mb_strlen($password) >= CONF_PASSWORD_MIN_LENGTH && mb_strlen($password) <= CONF_PASSWORD_MAX_LENGTH;

        return $valid;
    }

    function passwd(string $password): string
    {
        return password_hash($password, CONF_PASSWORD_ALGO, CONF_PASSWORD_OPTIONS);
    }

    function passwd_verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    function passwd_rehash(string $hash): bool
    {
        return password_needs_rehash($hash, CONF_PASSWORD_ALGO, CONF_PASSWORD_OPTIONS);
    }

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

    function str_studly_case(string $string): string
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
            str_studly_case($string)
        );
    }

    function str_title(string $string): string
    {
        return mb_convert_case( filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS), MB_CASE_TITLE);
    }

    function str_limit_words(string $string, int $limit, string $pointer = '...')#: string
    {
        $str = trim( filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));

        $arrayWords = explode(" ", $str);

        $countWords = count($arrayWords);

        if ($countWords > $countWords)
        {
            return $str;
        }

        $cut = implode(" ", array_slice($arrayWords, 0, $limit));

        return "{$cut}{$pointer}";
    }

    function str_limit_chars(string $string, int $limit, string $pointer = "..."): string
    {
        $str = trim( filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));

        if (mb_strlen($string) <= $limit)
        {
            return $string;
        }

        $cut = mb_substr(
            $string,
            0,
            mb_strrpos(mb_substr($string, 0, $limit), " ")
        );

        return "{$cut}{$pointer}";
    }

    /**
     * ######################
     * ###   NAVIGATION   ###
     * ######################
    */

    function url(string $path): string
    {
        return CONF_URL_BASE . "/" . ($path[0] === "/" ? mb_substr($path, 1) : $path);
    }

    function redirect(string $url): void
    {
        header("HTTP/1.1 302 Redirect");

        if (filter_var($url, FILTER_VALIDATE_URL))
        {
            header("Location: {$url}");
            exit;
        }

        $completeLocation = url($url);

        header("Location: {$completeLocation}");

        exit;
    }

    /**
     * ################
     * ###   CORE   ###
     * ################
    */

    function db(): PDO
    {
        return Source\Core\Connect::getInstance();
    }

    function message(): Source\Core\Message
    {
        return new Source\Core\Message();
    }

    function session(): Source\Core\Session
    {
        return new Source\Core\Session();
    }

    function user(): Source\Models\User
    {
        return new Source\Models\User();
    }