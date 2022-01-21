<?php

namespace ActivityTimetable\Util;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Hessé <sylvain.carite@gmail.com>
 */
class Inflector
{
    public static function getFormErrorsAsString(FormInterface $form)
    {
        $message = "";
        foreach ($form->getErrors(true) as $index => $error) {
            $message .= "[".$index."] ".$error->getMessage()." ; ";
        }

        return substr($message, 0, -3);
    }

    public static function getRequestAttribute(Request $request, $attribute)
    {
        if ($request->attributes->has($attribute)) {
            return $request->attributes->get($attribute);
        }

        return;
    }

    public static function getRequestQuery(Request $request, $attribute)
    {
        if ($request->query->has($attribute)) {
            return $request->query->get($attribute);
        }

        return;
    }

    public static function getRequestRequest(Request $request, $attribute)
    {
        if ($request->request->has($attribute)) {
            return $request->request->get($attribute);
        }

        return;
    }

    public static function getExceptionAsString(\Exception $e, $recursive = false)
    {
        $message = "exception (".get_class($e)."): ".$e->getMessage();
        if ($recursive) {
            while (($previous = $e->getPrevious()) !== null) {
                $message .= " $$ previous exception (".get_class($previous)."): ".$previous->getMessage();
                $e = $previous;
            }
        }

        return $message;
    }
}
