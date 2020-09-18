<?php
function get_query_string()
{
    return $_SERVER['QUERY_STRING'];
}

function cast_to_date($date)
{
    return date_format(date_create($date),'Y-m-d');
}

function forceRedirect($url)
{
    return '<script>window.location.href="'.$url.'"</script>';
}
?>