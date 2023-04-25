<div>
<?php
foreach( $params as $k =>  $value ){
    if( $k == 'user' ){
        foreach($value as $key => $val){
            if( is_string($key) ){
                echo "<p>$key: $val</p>";
            }
        }
    } elseif( $k == 'order') {
        echo 'Мои заказы';
        foreach($value as $key => $val){
            echo '<hr>';
            echo "<p>". $params['tovar'][$key]['title'] ."</p>";
            echo "<p>Цена: ". $params['tovar'][$key]['price'] ."</p>";
            echo "<p>Описание: ". $params['tovar'][$key]['description'] ."</p>";
            echo "<p>Сколько было заказано: ". $params['order'][$key]['count'] ."</p>";
            echo "<p>Сумма: ". $params['order'][$key]['sum_price'] ."</p>";
        }
    }

}
?>
</div>