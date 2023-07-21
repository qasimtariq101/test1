<?php

if (!function_exists('buildQuery')) {

    function buildQuery($new=[])
    {
    	$current = request()->query();
        $query = array_merge($current,$new);
        unset($query['page']);
    	return url()->current() .'?'.http_build_query($query);       
    }
}

if (!function_exists('unsetQuery')) {

    function unsetQuery($keys=[])
    {
        $query = request()->query();
        foreach ($keys as $key) {
            unset($query[$key]);
        }   
        unset($query['page']);     
        return url()->current() .'?'.http_build_query($query);
    }
}

if (!function_exists('alert_messages_admin')) {

    function alert_messages_admin($messages, $type = 'success')
    {
        switch ($type) {
            case 'success':
                $style = 'alert-success';
                break;            
            
            case 'info':
                $style = 'alert-info';
                break;            
            
            case 'error':
                $style = 'alert-danger';
                break;            

            case 'warning':
                $style = 'alert-warning';
                break;

            default:
                $style = 'alert-success';
                break;
        }

        if(is_string($messages)){
            return '<div class="alert alert-dismissable '.$style.'">
                                                    <button type="button" class="close" data-dismiss="alert">
                                                        ×
                                                    </button>
                                                    <div class="alert-content">
                                                        '.$messages.'
                                                    </div>
                                                </div>';
        }
        if(is_array($messages))
        {   
            $msg = '<div class="alert alert-dismissable '.$style.'"> <button type = "button" class="close" data-dismiss = "alert">×</button>';
            foreach ($messages as $message) {
                $msg .= '<li>'.$message.'</li>';
            }
            $msg .= '</div>';
            return $msg;
        }
        echo "hi";
    }
}


if (!function_exists('alert_messages')) {

    function alert_messages($messages, $type = 'success')
    {
        switch ($type) {
            case 'success':
                $style = 'style-02';
                break;            
            
            case 'info':
                $style = 'style-04';
                break;            
            
            case 'error':
                $style = 'style-03';
                break;            

            case 'warning':
                $style = 'style-05';
                break;

            default:
                $style = 'style-01';
                break;
        }

        if(is_string($messages)){
            return '<div class="alert ct-alert-1 '.$style.'">
                                                    <button type="button" class="close" data-dismiss="alert">
                                                        <i class="ti-close"></i> 
                                                    </button>
                                                    <div class="alert-content">
                                                        '.$messages.'
                                                    </div>
                                                </div>';
        }
        if(is_array($messages))
        {   
            $msg = '<div class="alert ct-alert-1 '.$style.'"> <button type = "button" class="close" data-dismiss = "alert">x</button>';
            foreach ($messages as $message) {
                $msg .= '<li>'.$message.'</li>';
            }
            $msg .= '</div>';
            return $msg;
        }
        echo "hi";
    }
}

if(!function_exists('book_icon'))
{
    function book_icon($file)
    {
        $file = explode('.', $file);
        $file_ext = end($file);

        if(in_array($file_ext, ['pdf'])){
            return 'fa-file-pdf-o';
        }
        elseif (in_array($file_ext, ['doc','docx','docm','dot','dotx','dotm','rtf'])) {
            return 'fa-file-word-o';
        }
        elseif (in_array($file_ext, ['xls','xlsx'])) {
            return 'fa-file-excel-o';
        }
        elseif (in_array($file_ext, ['ppt','pptx'])) {
            return 'fa-file-powerpoint-o';
        }
        elseif (in_array($file_ext, ['txt'])) {
            return 'fa-file-text-o';
        }         
        elseif (in_array($file_ext, ['mp3','wav'])) {
            return 'fa-file-audio-o';
        }        
        else{
            return 'fa-file-o';
        }
    }
}

if(!function_exists('number_format_short'))
{
    function number_format_short($n, $precision = 1) 
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
        return $n_format . $suffix;
    }
}

