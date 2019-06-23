<?php

if (!function_exists('is_local')) {
    /**
     * check env is local
     *
     * @return null
     * @author willy.lai<willy.lai@astrocorp.com.tw>
     */
    function is_local()
    {
        return config('app.env') === 'local';
    }
}
