<?php
function calculateSaleTotal($items) {
    return collect($items)->sum(fn($item) =>
        ($item['price'] - $item['discount']) * $item['quantity']
    );
}