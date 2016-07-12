<?php
if( is_active_sidebar('main-sidebar')){
    dynamic_sidebar('main-sidebar');
}else{
    echo ' go to Appearance and add some widgets. ';
}